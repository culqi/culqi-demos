$("#response-panel2").hide();
Culqi.publicKey = 'pk_test_753a58aa78e4f7e2'; //Ingresa la llave pública de tu comercio
// Culqi.container = "check";
Culqi.options({
  installments: false,
  style: {
    maincolor: '#FEE522',
    buttonText: 'Guardar'
  }
});
Culqi.settings({
  title: 'Guardar Tarjeta',
  currency: 'PEN',
  description: 'Si guardas tu tarjeta podras comprar las veces que quieras',
  amount: ''
});

$('#crearCard').on('click', function (e) {
  Culqi.open();
  e.preventDefault();
});
function culqi() {
  if (Culqi.token) {
    console.log(Culqi.token.id)
    var idCustomer = $('#idCustomer').val()
    $.ajax({
      type: 'POST',
      url: 'http://localhost/culqi-recurrencia-v4/culqi-php-develop/examples/07-create-card.php',
      data: { token: Culqi.token.id, idCustomer },
      datatype: 'json',
      success: function (data) {
        var result2 = "";
        if (data.constructor == String) {
          result2 = JSON.parse(data);
        }
        if (data.constructor == Object) {
          result2 = JSON.parse(JSON.stringify(data));
        }
        if (result2.object === 'card') {
          Culqi.close();
          resultdiv2('Se guardo la tarjeta de forma exitosa, ID: ' + result2.id);
          getListCards(result2.id);
        }
        if (result2.object === 'error') {
          resultdiv2(result2.user_message);
          alert(result2.merchant_message);
        }
      },
      error: function (error) {
        resultdiv2(error)
      }
    });
  } else {
    $('#response-panel2').show();
    $('#response2').html(Culqi.error.merchant_message);
  }
};


function resultdiv2(message) {
  $('#response-panel2').show();
  $('#response2').html(message);
}
