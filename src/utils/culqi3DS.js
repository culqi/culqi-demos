import ScriptService from "./script";

const baseUrl3DS = import.meta.env.VITE_APP_CULQI_CULQI_3DS_URL;

export default class Culqi3DSService extends ScriptService {
  #Culqi3DS = null;

  device = null;

  #codigoComercio = null;

  constructor(codigoComercio) {
    super("culqi-3ds-lib", "Culqi3DS", baseUrl3DS);
    this.#codigoComercio = codigoComercio;
    if (typeof window !== "undefined") {
      this.#initCulqi3DS();
    }
  }

  async #initCulqi3DS() {
    await this.appendScript();
    this.#Culqi3DS = window.Culqi3DS;
    this.#Culqi3DS.publicKey = this.#codigoComercio;
  }

  open() {
    return new Promise((resolve, reject) => {
      let c = 0;
      const Culqi3DSInitial = setInterval(async () => {
        c++;
        if (c > 10) {
          clearInterval(Culqi3DSInitial);
          console.error("Superó el límite de verificaciones");
          reject();
        }
        if (this.#Culqi3DS?._publicKey) {
          clearInterval(Culqi3DSInitial);
          this.#Culqi3DS.options = {
            showModal: true,
            showLoading: true,
            showIcon: true,
            closeModalAction: () => window.location.reload()
          };
          this.device = await this.#Culqi3DS?.generateDevice();
          resolve();
        }
      }, 1000);
    });
  }

  destroy() {
    document.getElementById("culqi-lib")?.remove();
    this.#Culqi3DS = null;
  }

  async getDevice() {
    return this.device;
  }
  getPk() {
    return this.#Culqi3DS?._publicKey;
  }

  async validationInit3DS({ token, statusCode, email, amount, url }) {
    // if (statusCode === 200) {
    this.#Culqi3DS.settings = {
      charge: {
        totalAmount: amount,
        returnUrl: url
      },
      card: {
        email
      }
    };
    await this.#Culqi3DS?.initAuthentication(token);
    // return CULQI3DS_RESULT.INIT_AUTH;
    // }
    // if (statusCode === 201) {
    //   this.#Culqi3DS?.reset();
    //   return CULQI3DS_RESULT.SUCCES_WITH_3DS;
    // }
    // return CULQI3DS_RESULT.ERROR;
  }

  reset() {
    this.#Culqi3DS?.reset();
  }
}
