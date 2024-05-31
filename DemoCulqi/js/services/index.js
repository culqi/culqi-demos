import config  from "../config/index.js"

class Service {
  #BASE_URL = config.URL_BASE+"/api";

  #http = async ({ endPoint, body = {}, headers = {} }) => {
    try {
      const response = await fetch(`${this.#BASE_URL}/${endPoint}`, {
        headers: { "Content-Type": "application/json", ...headers },
        body: JSON.stringify(body),
        method: "POST",
      });
      const responseJSON = await response.json();
      return { statusCode: response.status, data: responseJSON };
    } catch (err) {
      return { statusCode: 502, data: err };
    }
  };
  
  #http2 = async ({ endPoint, body = {}, headers = {} }) => {
	let statusCode = 502; 
	try {
	    const response = await $.ajax({
	      type: 'POST',
	      url: `${this.#BASE_URL}/${endPoint}`,
	      headers: { "Content-Type": "application/json", ...headers },
	      data: JSON.stringify(body),
	      success: function (data, status, xhr) {
	        statusCode = xhr.status;
	        //response = data;
	      }
	    });
	    const responseJSON = response;
	    return { statusCode, data: responseJSON }
    } catch (err) {
      return { statusCode, data: null }
    }
  }

    createOrder = async (bodyOrder) => {
    return this.#http2({ endPoint: "order", body: bodyOrder });
  }
  
  generateCharge = async (bodyCharges) => {
    return this.#http2({ endPoint: "Charge", body: bodyCharges });
  };

  createCustomer = async (bodyCustomers) => {
    return this.#http({ endPoint: "Customer", body: bodyCustomers });
  };

  createCard = async (bodyCard) => {
    return this.#http2({ endPoint: "Card", body: bodyCard });
  };
}

export default Service;