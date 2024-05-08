export default class ScriptService {
  #scriptId = null;
  #nameFunction = null;
  #scriptSrc = null;

  constructor(scriptId, nameFunction, scriptSrc) {
    this.#scriptId = scriptId;
    this.#nameFunction = nameFunction;
    this.#scriptSrc = scriptSrc;
  }

  appendScript() {
    return new Promise((resolve, reject) => {
      if (!document.getElementById(this.#scriptId)) {
        const script = document.createElement("script");
        script.setAttribute("src", this.#scriptSrc);
        script.setAttribute("id", this.#scriptId);
        document.body.appendChild(script);
      }
      this.#checkScript(resolve, reject);
    });
  }

  #checkScript(resolve, reject) {
    let c = 0;
    const checkScript = setInterval(() => {
      c++;
      if (c > 10) {
        clearInterval(checkScript);
        reject(new Error("Superó el límite de verificaciones"));
      }
      if (window[this.#nameFunction]) {
        clearInterval(checkScript);
        resolve();
      }
    }, 1000);
  }

  destroy() {
    document.getElementById(this.#scriptId)?.remove();
    window[this.#scriptId] = null;
  }
}
