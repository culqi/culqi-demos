import config from "./index.js";

const culqiConfig = ({ orderId }) => {
  Culqi.publicKey = config.PUBLIC_KEY;
  Culqi.settings({
    currency: config.CURRENCY,
    amount: config.TOTAL_AMOUNT,
    title: "INTERSEGURO", //Obligatorio para yape
    order: orderId, // Este parámetro es requerido para realizar pagos con pagoEfectivo, billeteras y Cuotéalo
    xculqirsaid: config.RSA_ID,
    rsapublickey: config.RSA_PUBLIC_KEY
  });

  Culqi.options({
    lang: "auto",
    installments: true,
    paymentMethods: {
      tarjeta: true,
      bancaMovil: true,
      agente: true,
      billetera: true,
      cuotealo: true
      //yape: false --> Solo para deshabilitar yape
    },
    style: {
      //logo: 'https://culqi.com/LogoCulqi.png',
      bannerColor: "", // hexadecimal
      buttonBackground: "", // hexadecimal
      menuColor: "", // hexadecimal
      linksColor: "", // hexadecimal
      buttonText: "", // texto que tomará el botón
      buttonTextColor: "", // hexadecimal
      priceColor: "" // hexadecimal
    }
  });
};
export default culqiConfig;
