//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "<<LLAVE PÚBLICA>>",
  COUNTRY_CODE: "PE",
  RSA_ID: "<<LLAVE PÚBLICA RSA ID>>",
  RSA_PUBLIC_KEY: "<<LLAVE PÚBLICA RSA>>",
  URL_BASE: "http://localhost:3000"
});

export const customerInfo = {
  firstName: "Dennis",
  lastName: "Demo",
  address: "Av siempre viva",
  addressCity: "Lima",
  phone: "999999999",
  email: "review1" + Math.floor(Math.random() * 100) + "@culqi.com"
};
