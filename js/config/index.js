//integracion
export const checkoutConfig = Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "<<LLAVE PÚBLICA>>",
  COUNTRY_CODE: "PE",
  RSA_ID: "<<RSA ID>>",
  RSA_PUBLIC_KEY: "<<LLAVE PúBLICA RSA>>",
  ACTIVE_ENCRYPT: false,
  URL_BASE: "http://localhost/culqi-demos-Php-checkout-charge"
});

//genera datos nuevos en el load
function generateRandomEmail() {
  const chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
  const domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'culqi.com'];
  let username = '';
  
  // Generar nombre del correo (username) de long entre 6 y 12 caracteres
  const usernameLength = Math.floor(Math.random() * 7) + 6;
  
  for (let i = 0; i < usernameLength; i++) {
    const randomChar = chars.charAt(Math.floor(Math.random() * chars.length));
    username += randomChar;
  }
  
  // Elegir un dominio aleatorio
  const domain = domains[Math.floor(Math.random() * domains.length)];
  
  // Devolver el correo electrónico completo
  return `${username}@${domain}`;
}
//genera nombre y apellido
 const generateRandomName = (length) => {
  const chars = 'abcdefghijklmnopqrstuvwxyz';
  let name = '';

  // Generar una cadena de letras aleatorias de longitud dada
  for (let i = 0; i < length; i++) {
    const randomChar = chars.charAt(Math.floor(Math.random() * chars.length));
    name += randomChar;
  }

  // Capitalizar la primera letra
  return name.charAt(0).toUpperCase() + name.slice(1);
};

// Generar un nombre de 6-10 letras aleatorias
const firstName = generateRandomName(Math.floor(Math.random() * 5) + 6); // Longitud entre 6 y 10
const lastName = generateRandomName(Math.floor(Math.random() * 5) + 6);
const phone = "9" + Array.from({ length: 8 }, () => Math.floor(Math.random() * 10)).join('');
const email = generateRandomEmail();
const countryCode =  Math.random() < 0.5 ? "PE":"US";

 export const customerInfo = {
  firstName: firstName,
  lastName: lastName,
  address: "Av siempre viva",
  addressCity: "Lima",
  countryCode ,
  phone: phone,
  email: generateRandomEmail() //"review" + Math.floor(Math.random() * 100) + "@culqi.com"
};
