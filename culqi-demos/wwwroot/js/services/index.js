import { checkoutConfig } from "../config/index.js";

class Service {
    #BASE_URL = checkoutConfig.URL_BASE;

    #http = async ({ endPoint, method = "POST", data = {}, headers = {} }) => {
        try {
            const response = await axios({
                method,
                url: `${this.#BASE_URL}/${endPoint}`,
                headers: { "Content-Type": "application/json", ...headers },
                data
            });
            const { statusCode, body } = response.data
            const bodyTransform = JSON.parse(body);
            return { statusCode, data: bodyTransform };
        } catch (err) {
            return { statusCode: err.response.status, data: err.response.data };
        }
    };

    createOrder = async (bodyOrder) => {
        return this.#http({ endPoint: "Order", data: bodyOrder });
    };

    generateCharge = async (bodyCharges) => {
        return this.#http({ endPoint: "Charge", data: bodyCharges });
    };

    createCustomer = async (bodyCustomers) => {
        return this.#http({ endPoint: "Customer", data: bodyCustomers });
    };

    createCard = async (bodyCard) => {
        return this.#http({ endPoint: "Card", data: bodyCard });
    };
}

export default Service;
