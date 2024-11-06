import { checkoutConfig } from "../js/config/index.js";
import { SuscripcionV } from "../js/utils/helpers.js";

$("#response-panel4").hide();
$('#crearSuscripcion').on('click', function (e) {
  var idPlan = $("#idPlan").val().replace(/\s+/g, '');
  var idCard = $('#idCard').val().replace(/\s+/g, '');
  var BASE_URL = `${checkoutConfig.URL_BASE}`;

  var data = { idPlan, idCard };
  if (!SuscripcionV(data)) {
    return;
  }

  $.ajax({
    type: 'POST',
    url: BASE_URL+"/ajax/createSubscription.php",
    data: { idPlan , idCard },
    datatype: 'json',
    success: function(data) {
      var result4 = "";
      if(data.constructor == String){
          result4= JSON.parse(data);
      }
      if(data.constructor == Object){
          result4 = JSON.parse(JSON.stringify(data));
      }
      if(result4.id != null){
       resultdiv4('Se creo el objeto Suscripción con el siguiente ID: ' + result4.id);
      }
      if(result4.object === 'error'){
          resultdiv4(result4);
      }
    },
    error: function(error) {
      console.log(error.responseJSON);
      var e= JSON.parse(error.responseJSON);
      resultdiv4(e.merchant_message)
    }
  });
    function resultdiv4(message){
    $('#response-panel4').show();
    $('#response4').html(message);
  }
});
