import config, { customerInfo } from "./config/index.js";
import culqiConfig from "./config/checkout.js";
import "./config/culqi3ds.js";
import {
  generateChargeImpl,
  createCustomerImpl,
  createCardImpl,
  generateOrderImpl,
} from "./services/impl/index.js";
import * as selectors from "./helpers/selectors.js";

const spinerHtml = ``;

let jsonParams = {
  installments: paymenType === "cargo" ? true : false,
  orderId: paymenType === "cargo" ? await generarOrder() : '',
  buttonTex: paymenType === "cargo" ? '' : 'Guardar Tarjeta',
  amount : paymenType === "cargo" ? config.TOTAL_AMOUNT : '0'
}

const charge = "cargo";

async function generarOrder(){
  const { statusCode, data } = await generateOrderImpl();
  if (statusCode === 201) {
      return data.id;
  } else {
    console.log('No se pudo obtener la orden');
  }
  return '';
}

const culqiInstance = culqiConfig(jsonParams);

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

    if (paymenType === charge) {
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
    }
    Culqi3DS.reset();
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
          validationInit3DS({statusCode, email, tokenId });
          break;
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
    
    if (paymenType === charge) {
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
        totalAmount: config.TOTAL_AMOUNT,
        returnUrl: config.URL_BASE,
      },
      card: {
        email: email,
      },
    };
    Culqi3DS.initAuthentication(tokenId);
};

async function createCustomer() {
  const dataCustomer = await createCustomerImpl({
    ...customerInfo,
  });

  $("#response_customer").text(dataCustomer.data.id);
  console.log(dataCustomer);
}

$("#loadCustomerExampleData").click(function () {
  selectors.customersNameElement.value = customerInfo.firstName;
  selectors.customersLastNameElement.value = customerInfo.lastName;
  selectors.customersEmailElement.value = customerInfo.email;
  selectors.customersAddressElement.value = customerInfo.address;
  selectors.customersPhoneElement.value = customerInfo.phone;
  selectors.customersAddressCityElement.value = customerInfo.address_c;
});

$("#crearCustomer").click(function () {
  customerInfo.firstName = selectors.customersNameElement.value;
  customerInfo.lastName = selectors.customersLastNameElement.value;
  customerInfo.email = selectors.customersEmailElement.value;
  customerInfo.address = selectors.customersAddressElement.value;
  customerInfo.phone = selectors.customersPhoneElement.value;
  customerInfo.address_c = selectors.customersAddressCityElement.value;
  createCustomer();
});

$("#crearCard").click(function () {
  culqiInstance.open();
});
