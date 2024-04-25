import { checkoutConfig } from "../config/index.js";
class Service {
  #BASE_URL = checkoutConfig.URL_BASE;
  /*
  #http = async ({ endPoint, method = 'POST', body = {}, headers = {} }) => {
    const authentication_3DS = body.authentication_3DS ? {
      eci: body.authentication_3DS.eci,
      xid: body.authentication_3DS.xid,
      cavv: body.authentication_3DS.cavv,
      protocolVersion: body.authentication_3DS.protocolVersion,
      directoryServerTransactionId: body.authentication_3DS.directoryServerTransactionId,
    } : null;
    try {
      const response = await fetch(`${this.#BASE_URL}/${endPoint}`,
        {
          headers: { 'Content-Type': 'application/x-www-form-urlencoded', ...headers },
          body: new URLSearchParams({
            amount: body.amount,
            currency_code: body.currency_code,
            email: body.email,
            token: body.source_id,
            customer_id: body.customer_id,
            deviceId: body.antifraud_details.device_finger_print_id,
            ...authentication_3DS,
          }),
          method
        });
      const responseJSON = await response;
      return { statusCode: response.status, data: responseJSON }
    } catch (err) {
      return { statusCode: 502, data: null }
    }
  }
*/
  #http2 = async ({ endPoint, method = "POST", body = {}, headers = {} }) => {
    let statusCode = 502;

    const bodyRequest = {
      amount: body.amount,
      currency_code: body.currency_code
    };

    try {
      const response = await $.ajax({
        type: "POST",
        url: `${this.#BASE_URL}/${endPoint}`,
        data: bodyRequest,
        success: function (data, status, xhr) {
          statusCode = xhr.status;
          //response = data;
        }
      });
      console.log("statusCode", statusCode);
      const responseJSON = await JSON.parse(response);
      console.log(responseJSON);
      return { statusCode: statusCode, data: responseJSON };
    } catch (err) {
      return { statusCode: statusCode, data: null };
    }
    /*
    if (responseJSON.object === "order") {
      return { statusCode: statusCode, data: responseJSON }
    } else {
      return { statusCode: 401, data: responseJSON }
    }*/
  };

  #http3 = async ({ endPoint, method = "POST", body = {}, headers = {} }) => {
    let statusCode = 502;
    const authentication_3DS = body.authentication_3DS
      ? {
          eci: body.authentication_3DS.eci,
          xid: body.authentication_3DS.xid,
          cavv: body.authentication_3DS.cavv,
          protocolVersion: body.authentication_3DS.protocolVersion,
          directoryServerTransactionId:
            body.authentication_3DS.directoryServerTransactionId
        }
      : null;

    const bodyRequest = {
      amount: body.amount,
      currency_code: body.currency_code,
      email: body.email,
      token: body.source_id,
      customer_id: body.customer_id,
      deviceId: body.antifraud_details.device_finger_print_id,
      ...authentication_3DS
    };
    try {
      const response = await $.ajax({
        type: "POST",
        url: `${this.#BASE_URL}/${endPoint}`,
        data: bodyRequest,
        success: function (data, status, xhr) {
          statusCode = xhr.status;
          console.log("statusCode " + statusCode);
          //response = data;
        }
      });
      console.log("gg", statusCode);
      const responseJSON = await JSON.parse(response);
      return { statusCode: statusCode, data: responseJSON };
    } catch (err) {
      return { statusCode: statusCode, data: null };
    }
  };

  createOrder = async (bodyOrder) => {
    return this.#http2({ endPoint: "ajax/order.php", body: bodyOrder });
  };
  createCard = async (bodyCard) => {
    return this.#http3({ endPoint: "ajax/card.php", body: bodyCard });
  };
  createCharge = async (bodyCharge) => {
    return this.#http3({ endPoint: "ajax/charge.php", body: bodyCharge });
  };
}
export default Service;
