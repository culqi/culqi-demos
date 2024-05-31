import Service from "../index.js";
import config,{ customerInfo } from "../../config/index.js";

const service = new Service();

export const generateOrderImpl = async () => {
  const bodyRequest = {
    amount: config.TOTAL_AMOUNT,
    currency_code: config.CURRENCY,
    description: 'Venta de prueba',
    order_number: 'pedido-' +(new Date).getTime(),
    client_details: {
      first_name: customerInfo.firstName,
      last_name: customerInfo.lastName,
      email: customerInfo.email,
      phone_number: customerInfo.phone
    },
  }
  return service.createOrder(bodyRequest);
}

export const generateChargeImpl = async ({
  email,
  tokenId,
  deviceId,
  parameters3DS = null,
}) => {
  const bodyRequest = {
    amount: config.TOTAL_AMOUNT,
    currency_code: config.CURRENCY,
    email: email,
    source_id: tokenId,
    antifraud_details: {
	  first_name: customerInfo.firstName,
      last_name: customerInfo.lastName,
      email: customerInfo.email,
      phone_number: customerInfo.phone,
      device_finger_print_id: deviceId,
    },
  };
  return service.generateCharge(
    parameters3DS
      ? { ...bodyRequest, authentication_3DS: { ...parameters3DS } }
      : bodyRequest
  );
};

export const createCardImpl = async ({
  customerId,
  tokenId,
  deviceId,
  parameters3DS = null,
}) => {
  const bodyRequest = {
    customer_id: customerId,
    token_id: tokenId,
    device_finger_print_id: deviceId,
  };
  return service.createCard(
    parameters3DS
      ? { ...bodyRequest, authentication_3DS: { ...parameters3DS } }
      : bodyRequest
  );
};

export const createCustomerImpl = async ({
  firstName,
  lastName,
  email,
  address,
  address_c,
  phone,
}) => {
  return service.createCustomer({
    first_name: firstName,
    last_name: lastName,
    email: email,
    address: address,
    address_city: address_c,
    country_code: config.COUNTRY_CODE,
    phone_number: phone,
  });
};
