import { Injectable } from '@angular/core';
import { checkoutConfig, customerInfo } from '../constants/global.constants';
import { getEpochSeconds } from '../helpers/global.helpers';
import { post } from '../utils/api-connector.utils';
import { culqi_pathname } from '../constants/http.constants';

@Injectable({
  providedIn: 'root',
})
export class CulqiApiService {
  constructor() {}

  generateOrderRequest = (epochSeconds: number) => {
    const customer = customerInfo(getEpochSeconds());
    return {
      amount: checkoutConfig.TOTAL_AMOUNT,
      currency_code: checkoutConfig.CURRENCY,
      description: 'Venta de prueba',
      order_number: `pedido-${new Date().getTime()}`,
      client_details: {
        first_name: customer.firstName,
        last_name: customer.lastName,
        email: customer.email,
        phone_number: customer.phone,
      },
      expiration_date: epochSeconds,
    };
  };

  createOrder = async () => {
    const epochSeconds = getEpochSeconds();
    const bodyRequest = this.generateOrderRequest(epochSeconds);
    const { data, status } = await post(culqi_pathname.order, bodyRequest);

    if (status === 200 || status === 201) {
      return { data, status };
    }
    return { data, status };
  };

  generateChargeRequest = ({
    email,
    tokenId,
    deviceId,
  }: {
    email: string;
    tokenId: string;
    deviceId: string;
  }) => {
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
        device_finger_print_id: deviceId,
      },
    };
  };

  createCharge = async ({
    email,
    tokenId,
    deviceId,
    parameters3DS = null,
  }: {
    email: string;
    tokenId: string;
    deviceId: string;
    parameters3DS?: object | null;
  }) => {
    const bodyRequest = this.generateChargeRequest({
      email,
      tokenId,
      deviceId,
    });

    const payload = parameters3DS
      ? { ...bodyRequest, authentication_3DS: { ...parameters3DS } }
      : bodyRequest;
    const { data, status } = await post(culqi_pathname.charge, payload, {});

    if (status === 200 || status === 201) {
      return { data, status };
    }
    return { data, status };
  };
}
