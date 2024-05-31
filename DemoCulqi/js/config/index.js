//integracion
export const checkoutConfig = Object.freeze({
    TOTAL_AMOUNT: 600,
    CURRENCY: "PEN",
    PUBLIC_KEY: "pk_test_e94078b9b248675d",
    COUNTRY_CODE: "PE",
    RSA_ID: "2ab335ad-c40d-4375-8dad-3ea315de23b0",
    RSA_PUBLIC_KEY: '-----BEGIN PUBLIC KEY-----'+
    'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC9hD00BnivDj73/1SKZw5AyQvw'+
    'FpvR/DKzW7Jqg1iwFWXrX6k1r57qZJH2wF1tZ9T3wTyw1we6BYgwPNRVC1IXe+E8'+
    'B6xAWG8ta7BCZK/a6IFL+l9Q9BhkHBeVTD7qGEfCjhnB7QtyrTQwmytoNBKk1Tl7'+
    'kbz8NO7jeiUxkZm75wIDAQAB'+
    '-----END PUBLIC KEY-----',
    ACTIVE_ENCRYPT: false,
    URL_BASE: "https://localhost:44342"
});

export default Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "pk_test_e94078b9b248675d",
  COUNTRY_CODE: "PE",
  RSA_ID: "2ab335ad-c40d-4375-8dad-3ea315de23b0",
  RSA_PUBLIC_KEY: '-----BEGIN PUBLIC KEY-----'+
  'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC9hD00BnivDj73/1SKZw5AyQvw'+
  'FpvR/DKzW7Jqg1iwFWXrX6k1r57qZJH2wF1tZ9T3wTyw1we6BYgwPNRVC1IXe+E8'+
  'B6xAWG8ta7BCZK/a6IFL+l9Q9BhkHBeVTD7qGEfCjhnB7QtyrTQwmytoNBKk1Tl7'+
  'kbz8NO7jeiUxkZm75wIDAQAB'+
  '-----END PUBLIC KEY-----',
  URL_BASE: "https://localhost:44342",
});

export const customerInfo = {
  firstName: "Fernando",
  lastName: "Chullo",
  address: "Coop. Villa el Sol",
  address_c: "Palo Alto",
  phone: "945737476",
  email: "review1" + Math.floor(Math.random() * 100) + "@culqi.com",
};
