import React, { useState, useEffect, useRef } from "react";
import culqiCustomCheckout from "../utils/culqiCustomCheckout";
import Culqi3DSService from "../utils/culqi3DS";
import { culqiConfig } from "../config/culqiConfig";
import { getMessage } from "../utils/util";
import { customerInfo } from "../config";

import { createCustomer, createCard } from "../services/culqi-services";

import InputComp from "../components/InputComp";
import ButtonComp from "../components/ButtonComp";

const publicKey = import.meta.env.VITE_APP_CULQI_PUBLICKEY;

const WithCard = () => {
  const [CulqiCheckout, setCulqiCheckout] = useState(null);

  const Culqi3DS = useRef(null);

  const [removeMessageListener, setRemoveMessageListener] = useState(() => {});

  const isFirstRunOrderService = useRef(true); // Variable de referencia para rastrear la primera ejecución

  const decive3DS = useRef(null);
  const orderId = useRef(null);
  const tokenId = useRef(null);
  const tokenEmail = useRef(null);

  const [cardMessage, setCardMessage] = useState(null);

  const [customerMessage, setCustomerMessage] = useState(null);

  const [customerId, setCustomerId] = useState("");

  const [customer, setCustomer] = useState({
    firstName: "",
    lastName: "",
    address: "",
    addressCity: "",
    countryCode: "",
    email: "",
    phone: ""
  });

  const handleSuccess3DSParameters = async (parameters3DS) => {
    const { data, status } = await createCharge({
      deviceId: decive3DS,
      email: tokenEmail,
      tokenId: tokenId,
      parameters3DS
    });

    if (status === 201 && data.object === "charge") {
      setChargeMessage("OPERACIÓN REALIZADA EXITOSAMENTE CON 3DS");
    }
    Culqi3DS.current.reset();
  };

  const handleResponse = (token, email, statusCode, objResponse) => {
    console.log("handleResponse - customer: ", customer);
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
    setCardMessage(message);
  };

  const addOnChangeCustomerID = async (name, value) => {
    await setCustomerId(value);
  };

  const addOnChange = async (name, value) => {
    await setCustomer((prevCustomer) => ({
      ...prevCustomer,
      [name]: Object.values(value)
    }));
  };

  // Function to handle Culqi token
  const handleCulqiToken = async () => {
    const token = CulqiCheckout.getToken();
    const error = CulqiCheckout.getError();
    if (error) {
      console.log("ERROR - ERROR: ", error);
      alert(error.user_message);
      return;
    }
    if (!token) {
      return;
    }
    tokenId.current = token.id;
    tokenEmail.current = token.email;

    CulqiCheckout.close();
    const { data, status } = await createCard({
      customerId: customerId,
      tokenId: token.id,
      deviceId: decive3DS.current
    });
    handleResponse(token.id, token.email, status, data);
  };

  const handleSetData = async () => {
    const data = customerInfo(Math.floor(Math.random() * 1000));
    for (const item in data) {
      const value = data[item];
      await setCustomer((prevCustomer) => ({
        ...prevCustomer,
        [item]: [value]
      }));
    }
  };

  const handleCreateCustomer = async () => {
    const payload = {};
    for (const item in customer) {
      payload[item] = customer[item].toString();
    }
    const { data, status } = await createCustomer(payload);
    if (status == 201) {
      setCustomerMessage("SE CREÓ EL CUSTOMER CORRECTAMENTE");
      setCustomerId(data.id);
    } else {
      alert(`ERROR: customer: \n ${JSON.stringify(data)}`);
    }
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
            decive3DS.current = device;
          })
          .catch((err) => {
            console.log("error 3DS:: ", err);
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
    const handleCulqiCheckout = async () => {
      const config = await culqiConfig({
        installments: false,
        orderId: "",
        buttonTex: "Guardar Tarjeta",
        amount: 0
      });
      setCulqiCheckout(new culqiCustomCheckout(publicKey, config));
    };

    handleCulqiCheckout();
  }, []);

  const openCheckout = async () => {
    CulqiCheckout.open()
      .then(async () => {
        CulqiCheckout.culqiFunction = handleCulqiToken;
        CulqiCheckout.closeCheckoutFunction = () => {
          console.log("cerrando...");
        };
      })
      .catch((err) => {
        console.log("falló al abrir checkout");
      });
  };
  return (
    <div
      className="flex flex-col items-center w-full place-content-center"
      id="with-card"
      data-mode-content="with-card"
    >
      <p className="text-lg font-semibold">(Tarjetas + 3DS)</p>
      <div className="grid grid-cols-2 gap-10 place-content-end">
        <div className="card-body">
          <div className="flex flex-col mt-10">
            <h2 className="mb-6 font-bold text-purple-900">
              Registrar Cliente
            </h2>
            <div className="w-full max-w-lg">
              <div className="flex flex-wrap mb-6 -mx-3">
                <InputComp
                  placeholder="Jane"
                  input="firstName"
                  label="First name"
                  spanDouble={true}
                  data={customer.firstName}
                  values={addOnChange}
                />

                <InputComp
                  placeholder="Doe"
                  input="lastName"
                  label="Last name"
                  spanDouble={true}
                  data={customer.lastName}
                  values={addOnChange}
                />
              </div>

              <div className="flex flex-wrap mb-6 -mx-3">
                <InputComp
                  placeholder="Av. siempre viva"
                  input="address"
                  label="address"
                  data={customer.address}
                  values={addOnChange}
                />
              </div>

              <div className="flex flex-wrap mb-6 -mx-3">
                <InputComp
                  placeholder="Lima"
                  input="addressCity"
                  label="address city"
                  spanDouble={true}
                  data={customer.addressCity}
                  values={addOnChange}
                />
                <InputComp
                  placeholder="PE / US"
                  input="countryCode"
                  label="country code"
                  spanDouble={true}
                  data={customer.countryCode}
                  values={addOnChange}
                />
              </div>

              <div className="flex flex-wrap mb-6 -mx-3">
                <InputComp
                  placeholder="demo@demo.com"
                  input="email"
                  label="Email"
                  data={customer.email}
                  values={addOnChange}
                />
              </div>

              <div className="flex flex-wrap mb-6 -mx-3">
                <InputComp
                  placeholder="99999999"
                  input="phone"
                  types="tel"
                  label="Phone number"
                  data={customer.phone}
                  values={addOnChange}
                />
              </div>

              <div className="flex items-center justify-between">
                <div className="md:w-1/3">
                  <ButtonComp
                    onClickButton={handleSetData}
                    text="Setear datos"
                  />
                </div>
                <div className="md:w-2/3">
                  <ButtonComp
                    onClickButton={handleCreateCustomer}
                    text="Crear Cliente"
                  />
                </div>
              </div>
            </div>
            <div className="flex w-ful mt-10 min-w-[200px] justify-start">
              <span className="mr-10">Respuesta:</span>
              <p>{customerMessage}</p>
            </div>
          </div>
        </div>
        <div className="card-body">
          <div className="flex flex-col mt-10">
            <h2 className="mb-6 font-bold text-purple-900">Guardar Tarjeta</h2>
            <div className="w-full max-w-lg">
              <div className="flex flex-wrap mb-6 -mx-3">
                <InputComp
                  placeholder="cli_test_xxxxxxxx"
                  input="customerId"
                  types="tel"
                  label="Client Id"
                  data={customerId}
                  values={addOnChangeCustomerID}
                />

                <p className="ml-3 italic text-gray-600 text-md">
                  Si tienes un clientID puedes evitar registrar un cliente e
                  ingresar uno ya creado previamente.
                </p>
              </div>
              <div className="flex items-center justify-between">
                <ButtonComp onClickButton={openCheckout} text="Crear Tarjeta" />
              </div>
            </div>
            <div className="flex w-ful mt-10 min-w-[200px] justify-start">
              <span className="mr-10">Respuesta:</span>
              <p>{cardMessage}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default WithCard;
