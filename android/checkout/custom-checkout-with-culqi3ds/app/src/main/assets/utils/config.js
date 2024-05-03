// Configuración inicial de Culqi
const culqiCheckoutConfig = (dataParams) => {
  const publicKey = dataParams.publicKey;

  const settings = {
    title: dataParams.title,
    order: dataParams.orderId,
    currency: dataParams.currency_code,
    amount: dataParams.amount
    //excludencryptoperations: [''],
  };

  if (dataParams.rsa_id) {
    settings.xculqirsaid = dataParams.rsa_id;
    settings.rsapublickey = dataParams.rsa_publickey;
  }

  const options = {
    lang: "auto",
    installments: true,
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
    buttonCardPayText: "Pagar", // texto que tomará el botón
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

const culqi3dsConfig = (pk) => {
  Culqi3DS.options = {
    showModal: true,
    showLoading: true,
    showIcon: true,
    closeModalAction: () => window.location.reload(true)
    // style: {
    //     btnColor: "red",
    //     btnTextColor: "yellow",
    // },
  };

  Culqi3DS.publicKey = pk;
};

const apiUrl = "https://api.culqi.com/v2";

export { culqiCheckoutConfig, culqi3dsConfig, apiUrl };
