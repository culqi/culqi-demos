import { checkoutConfig } from "./index.js";

Culqi3DS.options = {
  showModal: true,
  showLoading: true,
  showIcon: true,
  closeModalAction: () => window.location.reload(true)
  
};

Culqi3DS.publicKey = checkoutConfig.PUBLIC_KEY;
