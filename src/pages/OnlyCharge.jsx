import React, { useState, useEffect, useRef } from "react";
import culqiCustomCheckout from "../utils/culqiCustomCheckout";
import { culqiConfig } from "../config/culqiConfig";
import { createCharge, createOrder } from "../services/culqi-services";
import Culqi3DSService from "../utils/culqi3DS";
import { getMessage } from "../utils/util";
import { checkoutConfig } from "../config";

const publicKey = import.meta.env.VITE_APP_CULQI_PUBLICKEY;

const OnlyCharge = () => {
  const CulqiCheckout = useRef(null);
  const Culqi3DS = useRef(null);

  const [decive3DS, setDevice3DS] = useState(null);

  const [removeMessageListener, setRemoveMessageListener] = useState(() => {});

  const [orderId, setOrderId] = useState("");

  const isFirstRunOrderService = useRef(true); // Variable de referencia para rastrear la primera ejecución

  const [tokenId, setTokenId] = useState(null);
  const [tokenEmail, setTokenEmail] = useState(null);

  const [chargeMessage, setChargeMessage] = useState(null);

  const [amount, setAmount] = useState(900);

  // Function to handle 3DS parameters
  const handleSuccess3DSParameters = async (parameters3DS) => {
    console.log("tokenId: ", tokenId);
    console.log("tokenEmail: ", tokenEmail);
    console.log("decive3DS: ", decive3DS);
    const { data, status } = await createCharge({
      deviceId: decive3DS,
      email: tokenEmail,
      tokenId: tokenId,
      parameters3DS
    });

    if (status === 201) {
      if (data === "charge") {
        setChargeMessage("OPERACIÓN REALIZADA EXITOSAMENTE");
      }
    }
    Culqi3DS.current.reset();
  };

  const handleResponse = (token, email, statusCode, objResponse) => {
    console.log("handleResponse - tokenId: ", tokenId);
    let message = "";
    switch (statusCode) {
      case 200:
        if (objResponse.action_code === "REVIEW") {
          Culqi3DS.current.validationInit3DS({
            token,
            statusCode,
            email,
            amount,
            url: checkoutConfig.URL_BASE
          });
          return;
        }
        message = "ERROR AL REALIZAR LA OPERACIÓN";
        break;
      case 201:
        message = "OPERACIÓN EXITOSA - SIN 3DS";
        Culqi3DS.current.reset();
        break;
      default:
        message = "OPERACIÓN FALLIDA - SIN 3DS";
        Culqi3DS.current.reset();
        break;
    }
    setChargeMessage(message);
  };

  useEffect(() => {
    console.log("useEffect - tokenId: ", tokenId);
  }, [tokenId]);

  useEffect(() => {
    console.log("useEffect - decive3DS: ", decive3DS);
  }, [decive3DS]);

  // Function to handle Culqi token
  const handleCulqiToken = async () => {
    const token = CulqiCheckout.current.getToken();
    const error = CulqiCheckout.current.getError();
    if (error) {
      console.log("ERROR - ERROR: ", error);
      alert(error.user_message);
      return;
    }
    if (!token) {
      return;
    }
    console.log("Denn ~> handleCulqiToken ~> token:", token);
    setTokenId(token.id);
    setTokenEmail(token.email);

    CulqiCheckout.current.close();
    const { data, status } = await createCharge({
      deviceId: decive3DS,
      email: token.email,
      tokenId: token.id
    });
    handleResponse(token.id, token.email, status, data);
  };

  useEffect(() => {
    const handleCulqi3DS = () => {
      Culqi3DS.current = new Culqi3DSService(publicKey);

      if (Culqi3DS) {
        Culqi3DS.current
          .open()
          .then(async () => {
            console.log("3DS GENERADO");
            const device = await Culqi3DS.current.getDevice();
            setDevice3DS(device);
          })
          .catch((err) => {
            console.log("errrorr 3DS:: ", err);
          });
      }
    };
    handleCulqi3DS();
  }, [Culqi3DS !== null]);

  useEffect(() => {
    const removeMessageListener = getMessage(
      handleSuccess3DSParameters,
      (err) => {
        console.log("ERROR 3DS CARGO:: ", err);
      }
    );

    setRemoveMessageListener(() => removeMessageListener);

    return () => {
      if (removeMessageListener) {
        removeMessageListener();
      }
    };
  }, []);

  useEffect(() => {
    const generateOrder = async () => {
      isFirstRunOrderService.current = false; // Marca que ya no es la primera ejecución
      const { data, status } = await createOrder();
      if (status === 201) {
        setOrderId(data.id);
      } else {
        isFirstRunOrderService.current = true;
      }
    };

    const handleCulqiCheckout = async () => {
      if (isFirstRunOrderService.current) {
        await generateOrder();
      }
    };

    handleCulqiCheckout();
  }, [orderId]);

  const openCheckout = async () => {
    const config = await culqiConfig({
      installments: true,
      orderId,
      buttonTex: "",
      amount
    });

    CulqiCheckout.current = new culqiCustomCheckout(publicKey, config);
    CulqiCheckout.current
      .open()
      .then(async () => {
        CulqiCheckout.current.culqiFunction = handleCulqiToken;
        CulqiCheckout.current.closeCheckoutFunction = () => {};
      })
      .catch((err) => {
        console.log("falló al abrir checkout");
      });
  };

  return (
    <div
      id="only-charge"
      data-mode-content="only-charge"
      className="flex flex-col items-center w-full place-content-center"
    >
      <p className="text-lg font-semibold">(Cargo + 3DS)</p>

      <div className="flex flex-col mt-10">
        <button
          onClick={openCheckout}
          className="px-5 py-2 text-sm font-semibold leading-5 text-white bg-purple-500 rounded-full hover:bg-purple-700"
          id="crearCharge"
        >
          Crear Cargo
        </button>
        <div className="flex w-ful mt-10 min-w-[200px] justify-start">
          <span className="mr-10">Respuesta: {chargeMessage} </span>
          <p id="cardResponse"></p>
        </div>
      </div>
    </div>
  );
};

export default OnlyCharge;
