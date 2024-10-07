import { checkoutConfig } from "../config/index.js";

class Service {
  #BASE_URL = `${checkoutConfig.URL_BASE}`;

  #http = async ({ endPoint, method = "POST", data = {}, headers = {} }) => {
    try {
      const response = await axios({
        method,
        url: `${this.#BASE_URL}/${endPoint}`,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
          ...headers
        },
        data: new URLSearchParams(data)
      });
      return { statusCode: response.status, data: response.data };
    } catch (err) {
      return { statusCode: err.response.status, data: err.response.data };
    }
  };

  createOrder = async (bodyOrder) => {
    return this.#http({ endPoint: "ajax/order.php", data: bodyOrder });
  };

  generateCharge = async (bodyCharges) => {
    return this.#http({ endPoint: "ajax/charge.php", data: bodyCharges });
  };

  createCustomer = async (bodyCustomers) => {
    return this.#http({ endPoint: "ajax/customer.php", data: bodyCustomers });
  };

  createCard = async (bodyCard) => {
    return this.#http({ endPoint: "ajax/card.php", data: bodyCard });
  };

  createPlan = async (bodyPlan) => {
    return this.#http({ endPoint: "ajax/plan.php", data: bodyPlan });
  };

  getPlan = async (bodyGetPlan) => {
    return this.#http({ endPoint: "ajax/get-plan.php", data: bodyGetPlan });
  };

  createSubscription = async (bodySubscription) => {
    return this.#http({ endPoint: "ajax/subscription.php", data: bodySubscription });
  };
}

export default Service;
