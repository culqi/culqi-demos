import { checkoutConfig } from "../js/config/index.js";
$("#response-panel1").hide();
$('#crearCustomer').on('click', function (e) {
  var address = $("#address").val();
  var address_c = $('#address_c').val()
  var country = $('#country').val()
  var email = $('#email').val()
  var f_name = $('#f_name').val()
  var l_name = $('#l_name').val()
  var phone = $('#phone').val()
  var BASE_URL = `${checkoutConfig.URL_BASE}`;
  console.log(BASE_URL)

  $.ajax({
    type: 'POST',
    url: BASE_URL+"/ajax/createCustomer.php",
    data: { address, address_c, country, email, f_name, l_name, phone },
    datatype: 'json',
    success: function (data) {
      var result = "";
      if (data.constructor == String) {
        result = JSON.parse(data);
      } alert
      if (data.constructor == Object) {
        result = JSON.parse(JSON.stringify(data));
      }
      if (result.object === 'customer') {
        resultdiv('Se creo el objeto Customer con el siguiente ID: ' + result.id);
      }
      if (result.object === 'error') {
        resultdiv(result);
        alert(result.merchant_message);
      }
    },
    error: function (error) {
      resultdiv(error)
    }
  });
  function resultdiv(message) {
    $('#response-panel1').show();
    $('#response1').html(message);
  }
});
