const publicKey = import.meta.env.VITE_APP_CULQI_PUBLICKEY;
const rsaId = import.meta.env.VITE_APP_CULQI_RSA_ID;
const rsaPublicKey = import.meta.env.VITE_APP_CULQI_RSA_ID;
const isRequiredEncrypt = import.meta.env.VITE_APP_CULQI_ACTIVE_ENCRYPT;
const isActiveEncrypt = isRequiredEncrypt && isRequiredEncrypt === "true";

const currency = import.meta.env.VITE_APP_CULQI_CURRENCY;

//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: currency,
  PUBLIC_KEY: publicKey,
  COUNTRY_CODE: "PE",
  RSA_ID: rsaId,
  RSA_PUBLIC_KEY: rsaPublicKey,
  URL_BASE: "http://localhost:5173",
  ACTIVE_ENCRYPT: isActiveEncrypt
});

// export const customerInfo = {
//   firstName: "Dennis",
//   lastName: "Demo",
//   address: "Av siempre viva",
//   addressCity: "Lima",
//   phone: "999999999",
//   email: "review1" + Math.floor(Math.random() * 100) + "@culqi.com"
// };

export const customerInfo = (random) => {
  return {
    firstName: "Dennis",
    lastName: "Demo",
    address: "Av siempre viva",
    addressCity: "Lima",
    phone: "999999999",
    email: `review1${random}@culqi.com`
  };
};
