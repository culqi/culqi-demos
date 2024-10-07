//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "INSERTE_SU_LLAVE_PUBLICA",//INSERTE_SU_LLAVE_PUBLICA
  COUNTRY_CODE: "PE",
  RSA_ID: "INSERTE_SU_RSA_ID",
  RSA_PUBLIC_KEY: "INSERTE_SU_LLAVE_RSA",
  URL_BASE: "http://localhost/culqi-demos-feature-ajustes-demo-recurrencia-v"
});

export const customerInfo = {
  firstName: "Dennis",
  lastName: "Demo",
  address: "Av siempre viva",
  addressCity: "Lima",
  phone: "999999999",
  email: "review-" + Math.floor(Date.now() / 1000) + "@culqi.com"
};
