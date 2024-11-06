import { checkoutConfig } from "../js/config/index.js";
import { CustomerV } from "../js/utils/helpers.js";

$("#response-panel1").hide();
$('#crearCustomer').on('click', function (e) {
  var address = $("#address").val().replace(/\s+/g, '');
  var address_c = $('#address_c').val().replace(/\s+/g, '');
  var country = $('#country').val()
  var email = $('#email').val()
  var f_name = $('#f_name').val().replace(/\s+/g, '');
  var l_name = $('#l_name').val().replace(/\s+/g, '');
  var phone = $('#phone').val().replace(/\s+/g, '');
  var BASE_URL = `${checkoutConfig.URL_BASE}`;

  const validationResult = CustomerV(f_name, l_name, email, phone, address, address_c, country);
  if (validationResult.error) {
      resultdiv(validationResult.error);
      return; 
  }

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
        $('#idCustomer').val(result.id);
        resultdiv('Se creo el objeto Customer con el siguiente ID: ' + result.id);
      }
      if (result.object === 'error') {
        resultdiv(error) 
  
      }
    },
    error: function (error) {
      var e= JSON.parse(error.responseJSON);
      if (e.merchant_message.includes("Invalid value. It must be")) {
        resultdiv("Error de código de país");
      }else {
        resultdiv(e.merchant_message); 
      }
    }
  });
  function resultdiv(message) {
    $('#response-panel1').show();
    $('#response1').html(message);
  }
});

