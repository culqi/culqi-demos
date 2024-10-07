import Service from "../index.js";
import {checkoutConfig, customerInfo} from "../../config/index.js";

const service = new Service();

export const generateOrderImpl = async () => {
  var currentDate = new Date();
  currentDate.setDate(currentDate.getDate() + 1);
  var epochMilliseconds = currentDate.getTime();
  var epochSeconds = Math.floor(epochMilliseconds / 1000);
  console.log(epochSeconds);

  const bodyRequest = {
    amount: checkoutConfig.TOTAL_AMOUNT,
    currency_code: checkoutConfig.CURRENCY,
    description: "Venta de prueba",
    order_number: "pedido-" + new Date().getTime(),
    client_details: {
      first_name: customerInfo.firstName,
      last_name: customerInfo.lastName,
      email: customerInfo.email,
      phone_number: customerInfo.phone
    },
    expiration_date: epochSeconds
  };
  return service.createOrder(bodyRequest);
};

export const generateChargeImpl = async ({
  email,
  tokenId,
  deviceId,
  parameters3DS = null
}) => {
  const bodyRequest = {
    amount: checkoutConfig.TOTAL_AMOUNT,
    currency_code: checkoutConfig.CURRENCY,
    email: email,
    source_id: tokenId,
    antifraud_details: {
      first_name: customerInfo.firstName,
      last_name: customerInfo.lastName,
      email: customerInfo.email,
      phone_number: customerInfo.phone,
      device_finger_print_id: deviceId
    }
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
  parameters3DS = null
}) => {
  const bodyRequest = {
    customer_id: customerId,
    token_id: tokenId,
    device_finger_print_id: deviceId
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
  addressCity,
  phone
}) => {
  return service.createCustomer({
    first_name: firstName,
    last_name: lastName,
    email: email,
    address: address,
    address_city: addressCity,
    country_code: checkoutConfig.COUNTRY_CODE,
    phone_number: phone
  });
};

export const createPlanImpl = async ({

}) => {
  const planResponse = await service.createPlan({});
  const planData = planResponse.data;

  return await service.getPlan({plan_id: planData.id});

};

export const createSubscriptionImpl = async ({
  cardId,
  planId
}) => {
  return service.createSubscription({
    card_id: cardId,
    plan_id: planId
  });
};
