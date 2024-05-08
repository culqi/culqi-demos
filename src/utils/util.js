/**
 * @typedef {Object} IAuthentication3DS
 * @property {string} eci
 * @property {string} xid
 * @property {string} cavv
 * @property {string} protocolVersion
 * @property {string} directoryServerTransactionId
 */

/**
 * @param {function(IAuthentication3DS):void} successCb - Callback function for successful message.
 * @param {function(any):void} errorCb - Callback function for error in message.
 * @returns {function():void} - Function to remove the event listener.
 */
export const getMessage = (successCb, errorCb) => {
  /**
   * @param {MessageEvent} event - The message event.
   */
  const messageHandler = async (event) => {
    if (event.origin !== window.location.origin) {
      return;
    }

    const { parameters3DS, error } = event.data;

    if (parameters3DS) {
      successCb(parameters3DS);
    }

    if (error) {
      errorCb(error);
    }
  };

  window.addEventListener("message", messageHandler);

  return () => {
    window.removeEventListener("message", messageHandler);
  };
};
