import { checkoutConfig } from "./index.js";

const culqiConfig = (jsonParams) => {
  const publicKey = checkoutConfig.PUBLIC_KEY;

  let settings = {
    currency: checkoutConfig.CURRENCY,
    amount: jsonParams.amount,
    title: "TAXI MAXIN", //Obligatorio para yape
    order: jsonParams.orderId
  };

  if (checkoutConfig.ACTIVE_ENCRYPT) {
    settings.xculqirsaid = checkoutConfig.RSA_ID;
    settings.rsapublickey = checkoutConfig.RSA_PUBLIC_KEY;
  }

  const options = {
    lang: "auto",
    installments: jsonParams.installments,
    paymentMethods: {
      tarjeta: true,
      bancaMovil: true,
      agente: true,
      billetera: true,
      cuotealo: true,
      yape: true
    }
  };

  const appearance = {
    buttonCardPayText: jsonParams.buttonTex, // texto que tomará el botón
    //logo: 'https://culqi.com/LogoCulqi.png',
    defaultStyle: {
      bannerColor: "", // hexadecimal
      buttonBackground: "", // hexadecimal
      menuColor: "", // hexadecimal
      linksColor: "", // hexadecimal
      buttonTextColor: "", // hexadecimal
      priceColor: "" // hexadecimal
    },
    rules: {} // reglas css
  };

  const config = {
    settings,
    options,
    appearance
  };

  return new CulqiCheckout(publicKey, config);
};

export { culqiConfig };
