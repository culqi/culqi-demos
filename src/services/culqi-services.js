import { checkoutConfig, customerInfo } from "../config";
import { post } from "./util/api-connector";
import { culqiPathName } from "./util/http.constants";

const getEpochSeconds = () => {
  const currentDate = new Date();
  currentDate.setDate(currentDate.getDate() + 1);
  return Math.floor(currentDate.getTime() / 1000);
};

const generateOrderRequest = (epochSeconds) => {
  const customer = customerInfo(getEpochSeconds());
  return {
    amount: checkoutConfig.TOTAL_AMOUNT,
    currency_code: checkoutConfig.CURRENCY,
    description: "Venta de prueba",
    order_number: `pedido-${new Date().getTime()}`,
    client_details: {
      first_name: customer.firstName,
      last_name: customer.lastName,
      email: customer.email,
      phone_number: customer.phone
    },
    expiration_date: epochSeconds
  };
};

export const createOrder = async () => {
  const epochSeconds = getEpochSeconds();
  const bodyRequest = generateOrderRequest(epochSeconds);
  const { data, status } = await post(culqiPathName.order, bodyRequest);

  if (status === 200 || status === 201) {
    return { data, status };
  }
  return { data, status };
};

const generateChargeRequest = ({ email, tokenId, deviceId }) => {
  const customer = customerInfo(getEpochSeconds());
  return {
    amount: checkoutConfig.TOTAL_AMOUNT,
    currency_code: checkoutConfig.CURRENCY,
    email: email,
    source_id: tokenId,
    antifraud_details: {
      first_name: customer.firstName,
      last_name: customer.lastName,
      email: customer.email,
      phone_number: customer.phone,
      device_finger_print_id: deviceId
    }
  };
};

export const createCharge = async ({
  email,
  tokenId,
  deviceId,
  parameters3DS = null
}) => {
  const bodyRequest = generateChargeRequest({ email, tokenId, deviceId });

  const payload = parameters3DS
    ? { ...bodyRequest, authentication_3DS: { ...parameters3DS } }
    : bodyRequest;
  const { data, status } = await post(culqiPathName.charge, payload);

  if (status === 200 || status === 201) {
    return { data, status };
  }
  return { data, status };
};

const generateCardRequest = ({ customerId, tokenId, deviceId }) => ({
  customer_id: customerId,
  token_id: tokenId,
  device_finger_print_id: deviceId
});

export const createCard = async ({
  customerId,
  tokenId,
  deviceId,
  parameters3DS = null
}) => {
  const bodyRequest = generateCardRequest({ customerId, tokenId, deviceId });
  const payload = parameters3DS
    ? { ...bodyRequest, authentication_3DS: { ...parameters3DS } }
    : bodyRequest;
  return post(culqiPathName.card, payload);
};

export const createCustomer = async ({
  firstName,
  lastName,
  email,
  address,
  addressCity,
  phone
}) => {
  return post(culqiPathName.customer, {
    first_name: firstName,
    last_name: lastName,
    email: email,
    address: address,
    address_city: addressCity,
    country_code: checkoutConfig.COUNTRY_CODE,
    phone_number: phone
  });
};
