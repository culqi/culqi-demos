import Service from "../services/index.js";
import { Loader } from "../utils/loader.js";

const culqiConfig = (configParams, openType) => {
  const settings = {
    title: configParams.title,
    currency: configParams.currency,
    amount: configParams.amount,
    order: configParams.orderId,
  };

  const options = {
    lang: 'auto',
    installments: openType ? true : false,
    modal: true,
    paymentMethods: {
      tarjeta: true,
      yape: false,
      billetera: false,
      bancaMovil: false,
      agente: false,
      cuotealo: false,
    }
  };

  const appearance = {
    theme: "default",
    hiddenCulqiLogo: false,
    hiddenBannerContent: false,
    hiddenBanner: false,
    hiddenToolBarAmount: false,
    emailInputDisabled: false,
    menuType: "sidebar",
    logo: "https://culqi.com/assets/images/brand/brand.svg",
    buttonCardPayText: configParams.buttonTex,
    variables: {
      fontFamily: "monospace",
      fontWeightNormal: "500",
      borderRadius: "8px",
      colorBackground: "#0A2540",
      colorPrimary: "#EFC078",
      colorPrimaryText: "#1A1B25",
      colorText: "white",
      colorTextSecondary: "white",
      colorTextPlaceholder: "#727F96",
      colorIconTab: "white",
      colorLogo: "dark",
      soyUnaVariable: "blue",
    },
    rules: {},
  };

  const config = {
    settings,
    options,
    appearance,
  };

  return new CulqiCheckout(configParams.publicKey, config);
};

const culqi3DSConfig = async (chargeOrCard, email, body, configParams) => {
  Culqi3DS.publicKey = configParams.publicKey;

  Culqi3DS.options = {
    showModal: true,
    showLoading: true,
    showIcon: true,
    closeModalAction: () => window.location.reload(true),
  };

  Culqi3DS.settings = {
    charge: {
      currency: 'PEN',
      totalAmount: '100',
      returnUrl: window.location.origin,
    },
    card: {
      email,
    },
  };

  
  const deviceId =  await Culqi3DS.generateDevice();

  window.addEventListener("message", async function (event) {
    if (event.origin === window.location.origin) {
      const response = event.data;
      if (response.loading) {} else {}

      if (response.parameters3DS) {
        console.log("deviceId::::", deviceId);
        console.log("Parameters 3DS:", response.parameters3DS);

        const bodyFormat = {
          ...body, 
          antifraud_details: {
            device_finger_print_id: deviceId,
          },
          authentication_3DS: {
            ...response.parameters3DS,
          },
        };

        alert("Creando servicio con 3ds : " + chargeOrCard);

        const service = new Service(configParams.baseURL);
        const resp = chargeOrCard === true ?
            await service.generateCharge(bodyFormat, configParams.secretKey) : 
            await service.createCard(bodyFormat, configParams.secretKey);

        if (resp.statusCode === 201) {

          console.log("Card creado: ", resp.data);

          alert("Card creado: " + resp.data.id);

          createLocalCard(resp.data);
        } else {
          alert("Error al crear la tarjeta con 3ds");
          console.log("Error al crear la tarjeta con 3ds: ", resp.data);
        }

        if (resp.statusCode === 201 || resp.statusCode === 200) {
          Culqi3DS.reset();
        } else {
          Culqi3DS.reset();
        }
      }

      if (response.error) {
        console.log("Error:", response.error);
      }
    }
  }, false);
}

export const checkout = {
  open: (configParams) => {
    const CulqiInstance = culqiConfig(configParams, false);
    CulqiInstance.culqi = () => checkout.handleCulqiCard(CulqiInstance, configParams);
    CulqiInstance.open();
  },
  openCheckout: (configParams, saveCard) => {
    const CulqiInstance = culqiConfig(configParams, true);
    CulqiInstance.culqi = () => checkout.handleCulqiCheckout(CulqiInstance, configParams, saveCard);
    CulqiInstance.open();
  },
  handleCulqiCard: async (CulqiInstance, configParams) => {
    if (CulqiInstance?.token) {
      Loader(true);
      const tokenId = CulqiInstance.token.id;
      const email = CulqiInstance.token.email; 
      CulqiInstance.close();

      const service = new Service(configParams.baseURL);

      let bodyCard = {
        token_id: tokenId,
        customer_id: configParams.customer_code
      };

      const response = await service.createCard(bodyCard, configParams.secretKey);

      culqi3DSConfig(false, email, bodyCard, configParams);

      if (response.statusCode === 200) {
        Loader(false);
        CulqiInstance.close();
        await Culqi3DS.initAuthentication(tokenId);
      } else if (response.statusCode === 201) {
        Loader(false);
        console.log("Card creado: ", response.data);

        createLocalCard(response.data, false);
      } else {
        Loader(false);
        console.log("Error al crear la tarjeta: ", response.data);
      }


    } else if (CulqiInstance?.error) {
      Loader(false);
      console.error(`Error: ${CulqiInstance.error}`);
      CulqiInstance.close();
    } else {
      Loader(false);
      console.error('No se generó el token correctamente.');
      CulqiInstance.close();
    }
  },
  handleCulqiCheckout: async (CulqiInstance, configParams, saveCard) => {
    if (CulqiInstance?.token) {
      CulqiInstance.close();
      Loader(true);
      const tokenId = CulqiInstance.token.id;
      const email = CulqiInstance.token.email;

      const service = new Service(configParams.baseURL);

      const bodyCharge = {
        amount: configParams.amount,
        currency_code: configParams.currency,
        email,
        source_id: tokenId,
        installments: configParams.installments
      };

      if (saveCard){
        let bodyCard = {
          token_id: tokenId,
          customer_id: configParams.customer_code
        };
        
        const responseCard = await service.createCard(bodyCard, configParams.secretKey);
        
        if (responseCard.statusCode === 201) {
          console.log("Card creado: ", responseCard.data); 
          createLocalCard(responseCard.data, saveCard);
        } else if(responseCard.statusCode !== 200 || responseCard.statusCode !== 201) {
          Loader(false);
          console.log("Error al crear la tarjeta: ", responseCard.data);
          alert("Error al crear la tarjeta: ");
          return;
        } 
      }

      const response = await service.generateCharge(bodyCharge, configParams.secretKey);

      culqi3DSConfig(true, configParams.email, bodyCharge, configParams);

      if (response.statusCode === 200) {
        Loader(false);
        await Culqi3DS.initAuthentication(tokenId);
      } else if (response.statusCode === 201) {
        Loader(false);
        clearCart();
        window.location.href = '/payment?paymentStatus=success&paymentCode=' + response.data.id;
      } else {
        Loader(false);
        console.log("Error al generar un cargo: ", response.data.merchant_message);
        alert("Error al generar un cargo: ", response.data.merchant_message);
        CulqiInstance.close();
        return;
      }

    } else if (CulqiInstance?.error) {
      Loader(false);
      console.error(`Error: ${CulqiInstance.error}`);
      CulqiInstance.close();
    } else {
      Loader(false);
      console.error('No se generó el token correctamente.');
      CulqiInstance.close();
    }
  },
  payCard: async (configParams) => {
    try {
      Loader(true);
      const service = new Service(configParams.baseURL);

      const bodyCharge = {
        amount: configParams.amount,
        currency_code: configParams.currency,
        email: configParams.email,
        source_id: configParams.sourceId,
        installments: 0,
      };

      console.log("bodyCharge", bodyCharge);

      const response = await service.generateCharge(bodyCharge, configParams.secretKey);

      culqi3DSConfig(true, configParams.email, bodyCharge, configParams);

      if (response.statusCode === 200) {
        console.log("init 3ds: " + configParams.token_id);
        await Culqi3DS.initAuthentication(configParams.token_id);
      } else if(response.statusCode === 201) {
        clearCart();
        Loader(false);
        window.location.href = '/payment?paymentStatus=success&paymentCode=' + response.data.id;
      }
        console.log("error: ", response);
        Loader(false);
    } catch (error) {
      Loader(false);
      console.error("Error al procesar el pago:", error);
      alert("Hubo un problema al procesar el pago. Por favor, inténtalo nuevamente.");
    }
  },
  payCheckout: async (configParams, saveCard) => {
    checkout.openCheckout(configParams, saveCard);
  }
};

function createLocalCard(card, saveCard) {
  axios.post('/api/card', card)
    .then(response => {
      if(!saveCard) window.location.reload();
    })
    .catch(error => console.error(error));
}

async function createLocalCustomer(customer) {
  axios.post('/auth/register', customer)
    .then()
    .catch(error => console.error(error));
}

async function clearCart() {
  axios.post('/api/cart/clear', {
      action: 'clear'
    })
    .then(response => {
      updateCartView(response.data);
    })
    .catch(error => console.error(error));
}

function updateCartView(cart) {
  const cartItems = document.getElementById('cart-items');
  const cartTotal = document.getElementById('cart-total');
  if (!cart.items || cart.items.length === 0) {
    cartItems.innerHTML = '<li>No hay productos en el carrito</li>';
  } else {
    cartItems.innerHTML = cart.items.map(item =>
      `<li class="flex justify-between items-center">
                      <span>${item.name} (x${item.quantity})</span>
                      <span>S/ ${item.total.toFixed(2)}</span>
                  </li>`
    ).join('');
  }
  cartTotal.textContent = `S/ ${cart.total.toFixed(2)}`;
}

export const customer = {
  createCustomer: async (customerData, configParams) => {
    try {
      Loader(true);
      const service = new Service(configParams.baseURL);

      const bodyCustomer = {
        first_name: customerData.first_name,
        last_name: customerData.last_name,
        email: customerData.email,
        address: customerData.address,
        address_city: customerData.address_city,
        country_code: customerData.country_code,
        phone_number: customerData.phone_number
      };

      const response = await service.createCustomer(bodyCustomer, configParams.secretKey);

      Loader(false);
      
      if (response.statusCode === 201) {
        const customer = {
          password: customerData.password,
          first_name: customerData.first_name,
          last_name: customerData.last_name,
          email: customerData.email,
          address: customerData.address,
          address_city: customerData.address_city,
          country_code: customerData.country_code,
          phone_number: customerData.phone_number,
          customer_code: response.data.id,
          customer_email: customerData.email
        };

        await createLocalCustomer(customer);
      }

      return response;
    } catch (error) {
      Loader(false);
      console.error(error);
      return null;
    }
  },
  updateCustomer: async (customerData) => {
    try {
      const response = await axios.put('/api/customer', customerData);
      return response.data;
    } catch (error) {
      console.error(error);
      return null;
    }
  },
}