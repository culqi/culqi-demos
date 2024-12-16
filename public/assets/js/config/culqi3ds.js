import { checkoutConfig } from "./index.js";

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

Culqi3DS.publicKey = checkoutConfig.PUBLIC_KEY;
