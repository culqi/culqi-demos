import { culqiCheckoutConfig, culqi3dsConfig } from "./utils/config";

// Se declara de manera global con fines de demostración y uso en la demo, no recomendable
const handledContent = async () => {
  // Función para generar la orde

  const data = JSON.parse(Android.sendParamsCustomCheckoutFromAndroid());

  // Inicialización de Culqi
  culqiInstance = await culqiCheckoutConfig(data);

  // Abriendo el checkout
  culqiInstance.open();

  // llamando Culqi 3DS
  culqi3dsConfig(pk);

  const deviceId = Promise.resolve(Culqi3DS.generateDevice());

  if (!deviceId) {
    console.log("Ocurrio un error al generar el deviceID");
  }
  let tokenId = null;
  let email = null;

  const culqiResponse = {
    tokenId: null,
    metadata: null,
    tokenEmail: ""
  };

  const createCharge = async (data, parameters3DS = null) => {
    const installments = culqiResponse.metadata.installments;
    const data_fraud = {
      first_name: data.first_name,
      last_name: data.last_name,
      phone_number: data.phone_number,
      device_finger_print_id: deviceId
    };

    const dataRequest = {
      amount: data.amount,
      currency_code: data.currency_code,
      email: culqiResponse.tokenEmail,
      source_id: culqiResponse.tokenId,
      installments: installments,
      antifraud_details: data_fraud
    };

    const headers = {
      Authorization: `Bearer ${data.secretkey}`
    };

    if (!parameters3DS || parameters3DS === "") {
      data.authentication_3DS = parameters3DS;
    }
    console.log("dataRequest: ", dataRequest);
    return await generateChargeImpl({ data, headers });
  };

  // Function to handle 3DS parameters
  const handle3DSParameters = async (parameters3DS) => {
    let result;
    const response = await createCharge(data, parameters3DS);

    if (data.constructor == String) {
      result = JSON.parse(response);
    }

    if (data.constructor == Object) {
      result = JSON.parse(JSON.stringify(response));
    }
    const objResponse = result.data.object;
    const statusCode = result.statusCode;

    console.log("Status code: ", statusCode);

    if (statusCode === 201) {
      if (objResponse === "charge") {
        window.AndroidInterfaceMessage.onCulqiMenssage();
        alert("OPERACIÓN REALIZADA EXITOSAMENTE CON 3DS");
      }
      if (objResponse === "error") {
        console.log("Ocurrio un Error al procesar 3DS");
        window.AndroidInterfaceMessageError.onCulqiMenssageError();
        Culqi.close();
      }
      Culqi3DS.reset();
    } else {
      Culqi.close();
      Culqi3DS.reset();
    }
  };

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

  const validationInit3DS = ({ tokenId }) => {
    Culqi3DS.settings = {
      charge: {
        totalAmount: data.amount,
        returnUrl: data.appurl
      },
      card: {
        email: culqiResponse.tokenEmail
      }
    };
    Culqi3DS.initAuthentication(tokenId);
  };

  // Función para manejar la respuesta y mostrar el mensaje correspondiente
  const handleResponse = (statusCode, objResponse) => {
    let message = "";
    switch (statusCode) {
      case 200:
        if (objResponse.action_code === "REVIEW") {
          validationInit3DS({ tokenId: culqiResponse.tokenId });
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

    alert(message);
  };

  // Function to handle Culqi token
  const handleCulqiAction = async () => {
    if (!culqiInstance.token) {
      console.log("Error al crear el token: ", culqiInstance.error);
      alert(culqiInstance.error.user_message || "no se creó el token");
      return;
    }
    culqiResponse.tokenId = culqiInstance.token.id;
    culqiResponse.tokenEmail = culqiInstance.token.email;
    culqiResponse.metadata.installments =
      Culqi.token.metadata && Culqi.token.metadata.installments
        ? Culqi.token.metadata.installments
        : 0;

    console.log("Se creó el token: ", culqiInstance.token.id);

    culqiInstance.close();

    response = await generateChargeImpl({
      deviceId,
      email,
      tokenId
    });

    objResponse = response.data;
    statusCode = response.statusCode;

    handleResponse(statusCode, objResponse);
  };

  culqiInstance.culqi = handleCulqiAction;

  // Función para abrir el formulario de Culqi
  const openCulqiForm = (e) => {
    culqiInstance.open();
    e.preventDefault();
  };

  const btnOpenCheckout = document.getElementById("openCheckout");

  // Event listeners
  if (btnOpenCheckout) {
    btnOpenCheckout.addEventListener("click", openCulqiForm);
  }
};

document.addEventListener("DOMContentLoaded", handledContent);
