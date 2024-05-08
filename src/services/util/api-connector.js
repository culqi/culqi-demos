import axios from "axios";

const axiosInstance = axios.create({
  headers: {
    "Content-Type": "application/json",
    Authorization: `Bearer ${import.meta.env.VITE_APP_CULQI_SECRETKEY}`
  },
  baseURL: import.meta.env.VITE_APP_CULQI_API_URL
});

axiosInstance.interceptors.response.use(null, (error) => {
  if (error && error.message === "Network Error") {
    return {
      data: { message: "¡Ups! Algo salió mal. Intente mas tarde." },
      status: 400
    };
  }
  return { data: error.response?.data, status: error.response?.status };
});

const get = async (path, headers = {}, params = {}) => {
  return axiosInstance.get(path, { headers, params });
};

const post = async (path, payload, headers = {}, params = {}) => {
  return axiosInstance.post(path, payload, { headers, params });
};

export { get, post };
