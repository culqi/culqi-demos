//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "pk_test_e94078b9b248675d",
  COUNTRY_CODE: "PE",
  RSA_ID: "de35e120-e297-4b96-97ef-10a43423ddec",
  RSA_PUBLIC_KEY: "-----BEGIN PUBLIC KEY-----\n" +
      "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDswQycch0x/7GZ0oFojkWCYv+g\n" +
      "r5CyfBKXc3Izq+btIEMCrkDrIsz4Lnl5E3FSD7/htFn1oE84SaDKl5DgbNoev3pM\n" +
      "C7MDDgdCFrHODOp7aXwjG8NaiCbiymyBglXyEN28hLvgHpvZmAn6KFo0lMGuKnz8\n" +
      "HiuTfpBl6HpD6+02SQIDAQAB\n" +
      "-----END PUBLIC KEY-----",
  URL_BASE: "http://localhost/culqi-demos"
});

export const customerInfo = {
  firstName: "Dennis",
  lastName: "Demo",
  address: "Av siempre viva",
  addressCity: "Lima",
  phone: "999999999",
  email: "review-" + Math.floor(Date.now() / 1000) + "@culqi.com"
};
