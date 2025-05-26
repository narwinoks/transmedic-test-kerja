<?php

namespace Modules\Server\Services\Auth;

use App\ServerResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Server\Repositories\User\UserInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use function App\error;
use Exception;
/**
 * @author narnowin195@gmail.com
 */
class AuthService implements AuthImplement
{
    protected UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function login($username, $password): array
    {
        $token = auth()->attempt(['username' => $username, 'password' => $password]);
        if (! $token) {
            throw new HttpResponseException(error(ServerResponse::DATA_NOT_FOUND, 404));
        }
        $response = [
            'expired' => auth()->factory()->getTTL() * 60,
            'type' => 'bearer',
            'token' => $token,
        ];

        return $response;
    }

    public function refreshToken(): array
    {
        try {
            $oldToken = auth()->getToken();
            $token = auth()->refresh();
            auth()->invalidate($oldToken);
            $response = [
                'data' => [
                    'access_token' => $token,
                    'type' => 'bearer',
                    'expired' => auth()->factory()->getTTL() * 60,
                ],
            ];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $error = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
            Log::error('REFRESH TOKEN : '.json_encode($error, JSON_PRETTY_PRINT));
            throw new HttpResponseException(error(ServerResponse::UNAUTHORIZED, 401));
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $error = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
            Log::error('REFRESH TOKEN : '.json_encode($error, JSON_PRETTY_PRINT));
            throw new HttpResponseException(error(ServerResponse::UNAUTHORIZED, 401));
        } catch (Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
            Log::error('REFRESH TOKEN : '.json_encode($error, JSON_PRETTY_PRINT));
            throw new HttpResponseException(error(ServerResponse::UNAUTHORIZED, 401));
        }

        return $response;
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            Cache::flush();
            auth()->logout();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $error = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
            Log::error('LOGOUT  : '.json_encode($error['message'], JSON_PRETTY_PRINT));
            throw new HttpResponseException(error(ServerResponse::UNAUTHORIZED, 401));
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $error = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
            Log::error('LOGOUT  : '.json_encode($error['message'], JSON_PRETTY_PRINT));
            throw new HttpResponseException(error(ServerResponse::UNAUTHORIZED, 401));
        } catch (Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
            Log::error('LOGOUT  : '.json_encode($error['message'], JSON_PRETTY_PRINT));
            throw new HttpResponseException(error(ServerResponse::INTERNAL_SERVER_ERROR, 401));
        }

        return true;
    }
}
