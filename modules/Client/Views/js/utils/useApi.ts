import axios, {AxiosInstance} from 'axios';
import {useUserSession} from '../storage/useSessionStorage';
import {useToaster} from './toaster';
import * as H from './helper';

let api: AxiosInstance;
let isRefreshing = false;
let failedQueue: any[] = [];

const successCodes = ['200', '201', '202', '203', '204'];
const processQueue = (error: any, token: string | null | undefined = null) => {
    failedQueue.forEach((prom: any) => {
        if (error) {
            prom.reject(error);
        } else {
            prom.resolve(token);
        }
    });
    failedQueue = [];
};

export const createApi = (baseUrl: string) => {
    api = axios.create({
        baseURL: baseUrl,
    });

    api.interceptors.request.use((config) => {
        const userSession = useUserSession();
        if (userSession.isLoggedIn && userSession.token) {
            config.headers = {
                ...config.headers,
                Authorization: `Bearer ${userSession.token}`,
            };
        }
        return config;
    });

    api.interceptors.response.use(
        (response) => handleResponse(response),
        async (error) => {
            const originalRequest = error.config;
            if (error.response?.status === 401 && !originalRequest._retry) {
                if (isRefreshing) {
                    return new Promise((resolve, reject) => {
                        failedQueue.push({ resolve, reject });
                    })
                        .then((token) => {
                            originalRequest.headers['Authorization'] = `Bearer ${token}`;
                            return api(originalRequest);
                        })
                        .catch((err) => Promise.reject(err));
                }

                originalRequest._retry = true;
                isRefreshing = true;

                try {
                    const refreshToken = localStorage.getItem('token');
                    const { data } = await axios.post(`${baseUrl}/auth/refresh`, null, {
                        headers: {
                            'Authorization': `Bearer ${refreshToken}`,
                            'Content-Type': 'application/json',
                        },
                    });

                    const userSession = useUserSession();
                    const { access_token } = data.data;
                    localStorage.setItem('token', access_token);
                    userSession.setToken(access_token);

                    processQueue(null, access_token);

                    originalRequest.headers['Authorization'] = `Bearer ${access_token}`;
                    return api(originalRequest);
                } catch (err) {
                    processQueue(err, null);
                    localStorage.clear();
                    window.location.href = '/auth/login';
                    return Promise.reject(err);
                } finally {
                    isRefreshing = false;
                }
            }else if (error.response?.status === 404 && error.response?.data?.errors) {
                if (error.response?.data?.errors) {
                    const errorsArray = H.errorToArray(error.response?.data?.errors);
                    H.alert('warning', H.formatErrorMessage(errorsArray[0]));
                } else {
                    H.alert('warning', error.response?.message);
                }
                return;
            }else if (error.response?.status === 409 && error.response?.data?.message != "Conflict") {
                if (error.response?.data?.errors) {
                    const errorsArray = H.errorToArray(error.response?.data?.errors);
                    H.alert('warning', H.formatErrorMessage(errorsArray[0]));
                } else {
                    H.alert('warning', error.response?.message);
                }
                return;
            } else if (error.response?.status === 403) {
                if(error.response.data.errors){
                    const errorsArray = H.errorToArray(error.response.data.errors);
                    H.alert('warning', H.formatErrorMessage(errorsArray[0]))
                    return;
                }else{
                    H.alert('warning', error.response?.message)
                    return;
                }
            }
            else if (
                !(error.response?.status === 400 && error.response?.data?.message === 'Validation Error') &&
                !(error.response?.status === 404 && error.response?.data?.message === 'Not Found') &&
                !(error.response?.status === 400 && error.response?.data?.errors?.bpjs)
            ) {
                H.alert('warning', error.response != undefined ? error.response?.data?.message : error.message)
            }else if (error.response?.status === 400 && !error.response?.data?.errors?.bpjs) {
                const errorsArray = H.errorToArray(error.response.data.errors);
                H.alert('warning', H.formatErrorMessage(errorsArray[0]))
                return;
            } else if (error.response?.status == 500){
                H.alert('error', "Terjadi Kesalahan Pada Server !");
                return;
            }

            return Promise.reject(error);
        }
    );

    return api;
};

const handleResponse = (response: any) => {
    return response;
};
const formatUrl = (url: string): string => {
    return url.startsWith('/') ? url : '/' + url;
};
export const useApi = () => {
    const baseUrl = `/`;
    const apiInstance = createApi(baseUrl);
    return {
        get: (url: string, params?: any) => apiInstance.get(formatUrl(url),{ params }).then((res) => {
            return handleAllResponse(res, undefined, true)
        }),
        post: (url: string, data: any, message?: string, config?: any) => apiInstance.post(formatUrl(url), data, config).then((res) => {
            return handleAllResponse(res, message);
        }),
        put: (url: string, data: any, message?: string) => apiInstance.put(formatUrl(url), data).then((res) => {
            return handleAllResponse(res, message);
        }),
        patch: (url: string, data: any, message?: string) => apiInstance.patch(formatUrl(url), data).then((res) => {
            return handleAllResponse(res, message);
        }),
        delete: (url: string, message?: string) => apiInstance.delete(formatUrl(url)).then((res) => handleAllResponse(res, message)),
    };
};

const handleAllResponse = (response: any, message?: string, skipMessage?: boolean) => {
    const responseMessage = response?.data?.message || 'Success';
    const toaster = useToaster()
    const successMessage = message || adjustSuccessMessage(responseMessage) || 'Success';
    if (!skipMessage) {
        if (successCodes.includes(response.data.rc)) {
            toaster.success(successMessage);
        }
    }
    return response.data;
};

// Message adjustment function
const adjustSuccessMessage = (message: string) => {
    switch (message) {
        case 'Successfully':
        case 'Successfully Create':
        case 'Successfully Update':
        case 'Successfully Delete':
            return 'Sukses';
        default:
            return message;
    }
};

