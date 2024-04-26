export const checkoutConfig = {
  TOTAL_AMOUNT: 700,
  CURRENCY: "PEN",
  PUBLIC_KEY: "pk_test_e94078b9b248675d",
  RSA_ID: "de35e120-e297-4b96-97ef-10a43423ddec",
  RSA_PUBLIC_KEY:
    "-----BEGIN PUBLIC KEY-----" +
    "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDswQycch0x/7GZ0oFojkWCYv+g" +
    "r5CyfBKXc3Izq+btIEMCrkDrIsz4Lnl5E3FSD7/htFn1oE84SaDKl5DgbNoev3pM" +
    "C7MDDgdCFrHODOp7aXwjG8NaiCbiymyBglXyEN28hLvgHpvZmAn6KFo0lMGuKnz8" +
    "HiuTfpBl6HpD6+02SQIDAQAB" +
    "-----END PUBLIC KEY-----",
  COUNTRY_CODE: "PE",
  URL_BASE: "http://localhost/culqi-php-demo-checkoutv4-culqi3ds",
  ACTIVE_ENCRYPT: true
};

export const customerInfo = {
  firstName: "Dennis",
  lastName: "demo",
  address: "Coop. Villa el Sol",
  address_c: "Palo Alto",
  phone: "900000001",
  email: "review1" + Math.floor(Math.random() * 100) + "@culqi.com"
};
