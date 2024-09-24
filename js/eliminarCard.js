function deletCard(cardId) {
  $.ajax({
    type: 'POST',
    url: 'http://localhost/culqi-recurrencia-v4/culqi-php-develop/examples/09-delete-card.php',
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
