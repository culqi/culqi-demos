import config  from "../config/index.js"

$("#response-panel").hide();
$('#crearCustomer').on('click', function (e) {
  var address = $("#address").val();
  var address_c = $('#address_c').val()
  var country = $('#country').val()
  var email = $('#email').val()
  var f_name = $('#f_name').val()
  var l_name = $('#l_name').val()
  var phone = $('#phone').val()

  $.ajax({
    type: 'POST',
    url: config.URL_BASE+'/ajax/customer.php',
    data: { address, address_c, country, email, f_name, l_name, phone },
    datatype: 'json',
    success: function (data) {
      console.log(data);
      var result = "";
      if (data.constructor == String) {
        result = JSON.parse(data);
      }
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
    $('#response-panel').show();
    $('#response').html(message);
  }
});
