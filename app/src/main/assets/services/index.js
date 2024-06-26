import { apiUrl } from "../config/index.js";

class Service {
  #BASE_URL = apiUrl;

  #http = async ({ endPoint, method = "POST", data = {}, headers = {} }) => {
    try {
      const response = await axios({
        method,
        url: `${this.#BASE_URL}/${endPoint}`,
        headers: { "Content-Type": "application/json", ...headers },
        data
      });
      return { statusCode: response.status, data: response.data };
    } catch (err) {
      return { statusCode: err.response.status, data: err.response.data };
    }
  };

  generateCharge = async (bodyCharges, headers) => {
    return this.#http({ endPoint: "charges", data: bodyCharges, headers });
  };
}

export default Service;
