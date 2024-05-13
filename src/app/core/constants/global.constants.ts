import { encrypt, publicKey, rsaId, rsaPublickKey } from '../../env/dev.env';
import { ICustomer } from '../interfaces/global.interface';

export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: 'PEN',
  PUBLIC_KEY: publicKey,
  COUNTRY_CODE: 'PE',
  RSA_ID: rsaId,
  RSA_PUBLIC_KEY: rsaPublickKey,
  URL_BASE: 'http://localhost:4200',
  ACTIVE_ENCRYPT: encrypt,
});

export const customerInfo = (random: number): ICustomer => {
  return {
    firstName: 'Dennis',
    lastName: 'Demo',
    address: 'Av siempre viva',
    addressCity: 'Lima',
    phone: '999999999',
    email: `review1${random}@culqi.com`,
  };
};
