import ScriptService from "./script";

const baseUrlCheckout = import.meta.env.VITE_APP_CULQI_CHECKOUT_URL;

export default class culqiCustomCheckout extends ScriptService {
  #Culqi = null;
  #codigoComercio = null;
  #config = null;

  constructor(codigoComercio, config) {
    super("culqi-lib", "CulqiCheckout", baseUrlCheckout);
    this.#codigoComercio = codigoComercio;
    this.#config = config;
    if (
      typeof window !== "undefined" &&
      this.#config?.options?.paymentMethods
    ) {
      this.#initCulqi();
    }
  }

  async #initCulqi() {
    await this.appendScript();
    // this.#Culqi = new window.CulqiCheckout(this.#codigoComercio, this.#config);
    if (!this.#Culqi) {
      this.#Culqi = new window.CulqiCheckout(
        this.#codigoComercio,
        this.#config
      );
    }
  }

  open() {
    return new Promise(async (resolve, reject) => {
      let c = 0;
      const checkoutCulqiOpen = setInterval(async () => {
        c++;
        if (c > 10) {
          clearInterval(checkoutCulqiOpen);
          console.error("Superó el límite de verificaciones");
          reject();
        }
        if (this.#Culqi?.getSettings()) {
          clearInterval(checkoutCulqiOpen);
          this.#Culqi?.open();
          resolve();
        }
      }, 1000);
    });
  }

  destroy() {
    document.getElementById("culqi-lib")?.remove();
    this.#Culqi = null;
  }

  getSettings() {
    return this.#Culqi?.getSettings() || null;
  }

  getToken() {
    return this.#Culqi?.token || null;
  }

  getOrder() {
    return this.#Culqi?.order || null;
  }

  getError() {
    return this.#Culqi?.error || null;
  }

  set culqiFunction(fun) {
    this.#Culqi.culqi = fun;
  }

  set closeCheckoutFunction(fun) {
    this.#Culqi.closeCheckout = fun;
  }

  get isOpen() {
    return this.#Culqi.isOpen;
  }

  close() {
    this.#Culqi?.close();
    // this.destroy();
  }
}
