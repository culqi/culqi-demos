//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "<<LLAVE PÚBLICA>>",
  COUNTRY_CODE: "PE",
  RSA_ID: "<<RSA ID>>",
  RSA_PUBLIC_KEY: "<<LLAVE PúBLICA RSA>>",
  URL_BASE: "http://localhost/culqi-demos"
});

export const customerInfo = {
  firstName: "Dennis",
  lastName: "Demo",
  address: "Av siempre viva",
  addressCity: "Lima",
  phone: "999999999",
  email: "review1" + Math.floor(Math.random() * 100) + "@culqi.com"
};
