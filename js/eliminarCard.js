import { checkoutConfig } from "../js/config/index.js";
import { getListCards } from "../js/listCards.js";

export function deletCard(cardId) {
  $.ajax({
    type: 'POST',
    url: `${checkoutConfig.URL_BASE}`+"/ajax/deleteCard.php",
    data: { cardId: cardId },
    datatype: 'json',
    success: function (data) {
      var result = "";
      if (data) {
        result = data.merchant_message || "Tarjeta eliminada";
        alert(result);
        getListCards()
      }
    },
    error: function (error) {
      console.log("error: ", error);
    }
  });
};
