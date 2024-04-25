import { checkoutConfig } from "./config/index.js";
import { culqiConfig } from "./config/checkout.js";
import "./config/culqi3ds.js";
import {
  generateCardImpl,
  generateOrderImpl,
  generateChargeImpl
} from "./services/impl/index.js";

let jsonParams = {
  installments: paymenType === "cargo" ? true : false,
  orderId: paymenType === "cargo" ? await generarOrder() : "",
  buttonTex: paymenType === "cargo" ? "" : "Guardar Tarjeta",
  amount: paymenType === "cargo" ? checkoutConfig.TOTAL_AMOUNT : ""
};

async function generarOrder() {
  const { statusCode, data } = await generateOrderImpl();
  if (statusCode === 201) {
    console.log("Order", data);
    return data.id;
  } else {
    console.log("No se pudo obtener la orden");
  }
  return "";
}

const Culqi = culqiConfig(jsonParams);

const deviceId = await Culqi3DS.generateDevice();

if (!deviceId) {
  console.log("Ocurrio un error al generar el deviceID");
}
let tokenId, email, customerId;

window.addEventListener(
  "message",
  async function (event) {
    if (event.origin === window.location.origin) {
      const { parameters3DS, error } = event.data;

      if (parameters3DS) {
        let statusCode = null;
        let objResponse = null;
        if (paymenType === "cargo") {
          const responseCharge = await generateChargeImpl({
            tokenId,
            deviceId,
            email,
            parameters3DS
          });
          objResponse = responseCharge.data.object;
          statusCode = responseCharge.statusCode;

          if (statusCode === 201) {
            resultdivCard("CARGO CREADO CON ÉXITO");
            Culqi3DS.reset();
          } else {
            resultdivCard("CARGO FALLIDA");
            Culqi3DS.reset();
          }
        } else {
          const responseCard = await generateCardImpl({
            customerId,
            deviceId,
            email,
            tokenId,
            parameters3DS
          });
          objResponse = responseCard.data.object;
          statusCode = responseCard.statusCode;

          if (statusCode === 201) {
            resultdivCard("TARJETA CREADA CON ÉXITO");
            Culqi3DS.reset();
          } else {
            resultdivCard("CREACIÓN DE TARJETA FALLIDA");
            Culqi3DS.reset();
          }
        }
      }

      if (error) {
        resultdiv("Error, revisa la consola");
        console.log("Ocurrió un error: ", error);
      }
    }
  },
  false
);

Culqi.culqi = async () => {
  if (Culqi.token) {
    Culqi.close();
    tokenId = Culqi.token.id;
    email = Culqi.token.email;
    if (paymenType === "cargo") {
      const { statusCode, data } = await generateChargeImpl({
        tokenId,
        deviceId,
        email
      });
      console.log(data);
      console.log(statusCode);
      if (statusCode === 200) {
        if (data.action_code === "REVIEW") {
          validationInit3DS({ statusCode, email, tokenId });
        }
      } else if (statusCode === 201) {
        resultdivCard("CARGO EXITOSO - SIN 3DS");
        Culqi3DS.reset();
      } else {
        resultdivCard("CARGO FALLIDO");
        Culqi3DS.reset();
      }
    } else {
      customerId = $("#idCustomer").val();

      const { statusCode, data } = await generateCardImpl({
        customerId,
        deviceId,
        email,
        tokenId
      });
      if (statusCode === 200) {
        if (data.action_code === "REVIEW") {
          validationInit3DS({ email, statusCode, tokenId });
        }
      } else if (statusCode === 201) {
        resultdiv("TARJETA EXITOSA - SIN 3DS");
        Culqi3DS.reset();
      } else {
        resultdiv("TARJETA FALLIDA");
        Culqi3DS.reset();
      }
    }
  } else {
    alert(Culqi.error.user_message);
    $("#response-panel").show();
    $("#response").html(Culqi.error.merchant_message);
    $("body").waitMe("hide");
  }
};

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

$("#response-panel").hide();

function resultdivCard(message) {
  $("#response-panel").show();
  $("#response_card").html(message);
  // $('body').waitMe('hide');
}

const btn_pagar = document.getElementById("crearCharge");
btn_pagar.addEventListener("click", function (e) {
  // Abre el formulario con la configuración en Culqi.settings y CulqiOptions
  Culqi.open();
  e.preventDefault();
});
