import axios, { AxiosError, type AxiosResponse } from 'axios';
import { secretKey } from '../../env/dev.env';
import { culqi_url_base } from '../constants/http.constants';
import { HEADERS, HTTP, VALUE } from '../enum/http.enum';

const axiosInstance = axios.create({
  headers: {
    [HEADERS.CONTENT_TYPE]: VALUE.APPLICATION_JSON,
    [HEADERS.AUTHORIZATION]: `Bearer ${secretKey}`,
  },
  baseURL: culqi_url_base.api,
});

axiosInstance.interceptors.response.use(null, (error: AxiosError) => {
  if (error && error.message === 'Network Error') {
    return {
      data: { message: '¡Ups! Algo salió mal. Intente mas tarde.' },
      status: HTTP.STATUS_CODE_400,
    };
  }
  return { data: error.response?.data, status: error.response?.status };
});

const get = async (
  path: string,
  headers?: object,
  params?: object
): Promise<AxiosResponse> => {
  return axiosInstance.get(path, { headers, params });
};

const post = async (
  path: string,
  payload: object,
  headers?: object,
  params?: object
): Promise<AxiosResponse> => {
  return axiosInstance.post(path, payload, { headers, params });
};

export { get, post };
