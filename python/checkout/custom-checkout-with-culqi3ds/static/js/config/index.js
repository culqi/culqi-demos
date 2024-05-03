//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "INSERTE_SU_LLAVE_PUBLICA",
  COUNTRY_CODE: "PE",
  RSA_ID: "INSERTE_SU_RSA_ID",
  RSA_PUBLIC_KEY:
    "INSERTE_SU_LLAVE_RSA",
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
