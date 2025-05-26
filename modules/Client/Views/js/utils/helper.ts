import {useToaster} from "./toaster";


// import { useToaster } from 'primevue/usetoast';


export function errorToArray(error: any) {
  return Object.values(error).flat()
}
export function formatErrorMessage(message: any) {
  if (!message) return ''
  return message
    .replace('Field ', '')
    .replace('_', ' ')
    .replace(/detail\.\d+\./g, '')
    .replace(/details\.\d+\./g, '')
    .replace('id ', '')
    .replace('pasien.', '')
    .replace('pasien detail.', '')
    .replace('pasien_penanggung_jawab.', '')
    .replace('pasien penanggung jawab.', '')
    .replace('Field ', '')
    .replace('data.', '')
    .replace(/pasien_alamat\.\d+\./g, '')
    .replace('id ', '');
}
type typeNotify =
  | "success"
  | "error"
  | "info"
  | "purple"
  | "orange"
  | "primary"
  | "blue"
  | "green"
  | "warning";
export function alert(type: typeNotify, message: any, title: any = null): any { 
  const toast = useToaster();
  title = title ? title : "Info";
  if (type == "success") {
    toast.success(message, title);
  } else if (type == "error") {
    toast.error(message, title);
  } else if (type == "info") {
    toast.info(message, title);
  } else if (type == "warning") {
    toast.warn(message, title);
  }
}