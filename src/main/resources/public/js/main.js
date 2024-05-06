import { checkoutConfig, customerInfo } from "./config/index.js";
import { culqiConfig } from "./config/checkout.js";
import "./config/culqi3ds.js";
import {
  generateChargeImpl,
  createCustomerImpl,
  createCardImpl,
  generateOrderImpl
} from "./services/impl/index.js";
import * as selectors from "./utils/selectors.js";

let culqiInstance = null;

const spinerHtml = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>`;

const handledContentLoad = async () => {
  // Función para generar la orde
  const generateOrder = async () => {
    const { statusCode, data } = await generateOrderImpl();
    if (statusCode === 201) {
      console.log("Order: ", data);
      return data.id;
    } else {
      console.log("No se pudo obtener la orden");
    }
    return "";
  };

  const charge = "only-charge";

  // Configuración inicial de Culqi
  const initializeCulqi = async () => {
    console.log("paymentType: ", paymentType);
    let jsonParams = {
      installments: paymentType === charge,
      orderId: paymentType === charge ? await generateOrder() : "",
      buttonTex: paymentType === charge ? "" : "Guardar Tarjeta",
      amount: paymentType === charge ? checkoutConfig.TOTAL_AMOUNT : "0"
    };
    return await culqiConfig(jsonParams);
  };
  // Inicialización de Culqi
  culqiInstance = await initializeCulqi();

  const deviceId = await Culqi3DS.generateDevice();

  if (!deviceId) {
    console.log("Ocurrio un error al generar el deviceID");
  }
  let tokenId,
    email,
    customerId = null;

  // Function to handle 3DS parameters
  async function handle3DSParameters(parameters3DS) {
    let statusCode = null;
    let objResponse = null;
    let response = null;

    if (paymentType === charge) {
      response = await generateChargeImpl({
        deviceId,
        email,
        tokenId,
        parameters3DS
      });
    } else {
      response = await createCardImpl({
        customerId,
        tokenId,
        deviceId,
        parameters3DS
      });
    }

    objResponse = response.data.object;
    statusCode = response.statusCode;

    console.log("Status code: ", statusCode);

    if (statusCode === 201) {
      if (objResponse === "charge" || objResponse === "card") {
        selectors.cardResponseList.forEach((el) => {
          el.innerHTML = "OPERACIÓN REALIZADA EXITOSAMENTE";
        });
      }
      Culqi3DS.reset();
    } else {
      Culqi3DS.reset();
    }
  }

  // Event listener for message event
  window.addEventListener(
    "message",
    async function (event) {
      if (event.origin !== window.location.origin) {
        return;
      }

      const { parameters3DS, error } = event.data;

      if (parameters3DS) {
        await handle3DSParameters(parameters3DS);
      }

      if (error) {
        console.log("Ocurrio un error", error);
      }
    },
    false
  );

  // Función para manejar la respuesta y mostrar el mensaje correspondiente
  const handleResponse = (statusCode, objResponse) => {
    let message = "";
    switch (statusCode) {
      case 200:
        if (objResponse.action_code === "REVIEW") {
          validationInit3DS({ email, statusCode, tokenId });
          return;
        }
        message = "ERROR AL REALIZAR LA OPERACIÓN";
        break;
      case 201:
        message = "OPERACIÓN EXITOSA - SIN 3DS";
        Culqi3DS.reset();
        break;
      default:
        message = "OPERACIÓN FALLIDA - SIN 3DS";
        Culqi3DS.reset();
        break;
    }

    selectors.cardResponseList.forEach((el) => {
      el.innerHTML = message;
    });
  };

  // Function to handle Culqi token
  const handleCulqiToken = async () => {
    if (!culqiInstance.token) {
      console.log(culqiInstance.error);
      alert(culqiInstance.error.user_message);
      return;
    }

    culqiInstance.close();
    tokenId = culqiInstance.token.id;
    email = culqiInstance.token.email;

    let statusCode = null;
    let objResponse = null;
    let response = null;

    selectors.cardResponseList.forEach((el) => {
      el.innerHTML = spinerHtml;
    });

    if (paymentType === charge) {
      response = await generateChargeImpl({
        deviceId,
        email,
        tokenId
      });
    } else {
      customerId = selectors.customerCustomFormElement.value;
      response = await createCardImpl({
        customerId,
        tokenId,
        deviceId
      });
    }

    objResponse = response.data;
    statusCode = response.statusCode;

    handleResponse(statusCode, objResponse);
  };

  culqiInstance.culqi = handleCulqiToken;

  const validationInit3DS = ({ statusCode, email, tokenId }) => {
    Culqi3DS.settings = {
      charge: {
        totalAmount: checkoutConfig.TOTAL_AMOUNT,
        returnUrl: checkoutConfig.URL_BASE
      },
      card: {
        email: email
      }
    };
    Culqi3DS.initAuthentication(tokenId);
  };

  const createCustomer = async () => {
    selectors.customerResponse.innerHTML = spinerHtml;
    const dataCustomer = await createCustomerImpl({
      ...customerInfo
    });

    selectors.customerCustomFormElement.value = dataCustomer.data.id;

    selectors.customerResponse.innerHTML = dataCustomer.data.id;
  };

  const loadCustomerExampleData = () => {
    Object.keys(customerInfo).forEach((key) => {
      const selectorOption =
        selectors[
          `customers${key.charAt(0).toUpperCase() + key.slice(1)}Element`
        ];
      if (selectorOption) {
        selectorOption.value = customerInfo[key];
      }
    });
  };

  // Función para actualizar los datos del cliente
  const updateCustomerInfo = () => {
    Object.keys(customerInfo).forEach((key) => {
      const selectorOption =
        selectors[
          `customers${key.charAt(0).toUpperCase() + key.slice(1)}Element`
        ];
      if (selectorOption) {
        customerInfo[key] = selectorOption.value;
      }
    });
  };

  // Función para abrir el formulario de Culqi
  const openCulqiForm = (e) => {
    culqiInstance.open();
    e.preventDefault();
  };

  const btnLoadCustomer = document.getElementById("loadCustomerExampleData");
  const btnCreateCustomer = document.getElementById("createCustomer");
  const btnBuy = document.getElementById("crearCharge");
  const btnCard = document.getElementById("createCard");

  // Event listeners
  if (btnLoadCustomer) {
    btnLoadCustomer.addEventListener("click", loadCustomerExampleData);
  }

  if (btnCreateCustomer) {
    btnCreateCustomer.addEventListener("click", () => {
      updateCustomerInfo();
      createCustomer();
    });
  }

  if (btnBuy) {
    btnBuy.addEventListener("click", openCulqiForm);
  }
  if (btnCard) {
    btnCard.addEventListener("click", openCulqiForm);
  }
  return culqiInstance;
};

document.addEventListener("DOMContentLoaded", async () => {
  await handledContentLoad();

  const reset = document.getElementById("reset");
  reset.addEventListener("click", async () => {
    window.location.reload();
  });
});
