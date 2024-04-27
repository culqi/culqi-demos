import { checkoutConfig } from "../config/index.js";

class Service {
  #BASE_URL = checkoutConfig.URL_BASE + "/culqi";

  #http2 = async ({ endPoint, method = "POST", body = {}, headers = {} }) => {
    try {
      const response = await fetch(`${this.#BASE_URL}/${endPoint}`, {
        headers: { "Content-Type": "application/json", ...headers },
        body: JSON.stringify(body),
        method
      });
      const responseJSON = await response.json();
      return { statusCode: response.status, data: responseJSON };
    } catch (err) {
      return { statusCode: 502, data: err };
    }
  };

  #http = async ({ endPoint, method = "POST", body = {}, headers = {} }) => {
    let statusCode = 502;
    try {
      const response = await $.ajax({
        type: "POST",
        url: `${this.#BASE_URL}/${endPoint}`,
        headers: { "Content-Type": "application/json", ...headers },
        data: JSON.stringify(body),
        success: function (data, status, xhr) {
          statusCode = xhr.status;
          //response = data;
        }
      });
      const responseJSON = await response;
      console.log("statusCode", statusCode);
      return { statusCode: statusCode, data: responseJSON };
    } catch (err) {
      return { statusCode: statusCode, data: null };
    }
  };

  createOrder = async (bodyOrder) => {
    return this.#http({ endPoint: "generateOrder", body: bodyOrder });
  };

  generateCharge = async (bodyCharges) => {
    return this.#http({ endPoint: "generateCharge", body: bodyCharges });
  };

  createCustomer = async (bodyCustomers) => {
    return this.#http2({ endPoint: "createCustomer", body: bodyCustomers });
  };

  createCard = async (bodyCard) => {
    return this.#http({ endPoint: "createCard", body: bodyCard });
  };
}

export default Service;
