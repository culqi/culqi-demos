export const formatAmount = (amount) => {
    const amountStringified = amount.toString();
    const decimalAmount = amountStringified.length - 2;
    return `${amountStringified.slice(0, decimalAmount)}.${amountStringified.slice(decimalAmount)}`
}
export function generateRandomEmail() {
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
export function generateRandomName(length) {
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
  
  export const generateCustomerData = () => {
    const firstName = generateRandomName(Math.floor(Math.random() * 5) + 6);
    const lastName = generateRandomName(Math.floor(Math.random() * 5) + 6);
    const phone = "9" + Array.from({ length: 8 }, () => Math.floor(Math.random() * 10)).join('');
    const email = generateRandomEmail();
    const countryCode = Math.random() < 0.5 ? "PE" : "US";
  
    return {
      firstName,
      lastName,
      address: "Av siempre viva",
      addressCity: "Lima",
      countryCode,
      phone,
      email
    };
  };