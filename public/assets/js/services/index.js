class Service {
  constructor(baseURL) {
    this.#BASE_URL = baseURL;
  }

  #BASE_URL;

  #http = async ({ endPoint, method = "POST", data = {}, headers = {} }) => {
    try {
      const response = await axios({
        method,
        url: `${this.#BASE_URL}/${endPoint}`,
        headers: {
          "Content-Type": "application/json",
          ...headers
        },
        data
      });
      return { statusCode: response.status, data: response.data };
    } catch (err) {
      return { statusCode: err.response.status, data: err.response.data };
    }
  };

  createOrder = async (bodyOrder) => {
    return this.#http({ endPoint: "ajax/order.php", data: bodyOrder });
  };

  generateCharge = async (bodyCharges, Secret_key) => {
    return this.#http({ endPoint: "charges", data: bodyCharges, headers: { Authorization: "Bearer " + Secret_key } });
  };

  createCustomer = async (bodyCustomers, Secret_key) => {
    return this.#http({ endPoint: "customers", data: bodyCustomers, headers: { Authorization: "Bearer " + Secret_key } });
  };

  createCard = async (bodyCard, Secret_key) => {
    return this.#http({ endPoint: "cards", data: bodyCard, headers: { Authorization: "Bearer " + Secret_key } });
  };
}

export default Service;
