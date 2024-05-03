import { checkoutConfig } from "../config/index.js";

class Service {
  #BASE_URL = `${checkoutConfig.URL_BASE}/culqi`;

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

  createOrder = async (bodyOrder) => {
    return this.#http({ endPoint: "generateOrder", data: bodyOrder });
  };

  generateCharge = async (bodyCharges) => {
    return this.#http({ endPoint: "generateCharge", data: bodyCharges });
  };

  createCustomer = async (bodyCustomers) => {
    return this.#http({ endPoint: "generateCustomer", data: bodyCustomers });
  };

  createCard = async (bodyCard) => {
    return this.#http({ endPoint: "generateCard", data: bodyCard });
  };
}

export default Service;
