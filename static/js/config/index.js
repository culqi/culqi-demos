//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "pk_test_e94078b9b248675d",
  COUNTRY_CODE: "PE",
  RSA_ID: "de35e120-e297-4b96-97ef-10a43423ddec",
  RSA_PUBLIC_KEY: '-----BEGIN PUBLIC KEY-----'+
  'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDswQycch0x/7GZ0oFojkWCYv+g'+
  'r5CyfBKXc3Izq+btIEMCrkDrIsz4Lnl5E3FSD7/htFn1oE84SaDKl5DgbNoev3pM'+
  'C7MDDgdCFrHODOp7aXwjG8NaiCbiymyBglXyEN28hLvgHpvZmAn6KFo0lMGuKnz8'+
  'HiuTfpBl6HpD6+02SQIDAQAB'+
  '-----END PUBLIC KEY-----',
  ACTIVE_ENCRYPT: 1,
  URL_BASE: "http://localhost:5100"
});

export const customerInfo = {
  firstName: "Dennis",
  lastName: "Demo",
  address: "Av siempre viva",
  addressCity: "Lima",
  phone: "999999999",
  email: "review1" + Math.floor(Math.random() * 100) + "@culqi.com"
};
