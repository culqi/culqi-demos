import { checkoutConfig } from "../js/config/index.js";
$("#response-panel4").hide();
$('#crearSuscripcion').on('click', function (e) {
  var idPlan = $("#idPlan").val();
  var idCard = $('#idCard').val();
  console.log("id Plan "+idPlan, "Id Card"+idCard)
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
      resultdiv4(error)
    }
  });
    function resultdiv4(message){
    $('#response-panel4').show();
    $('#response4').html(message);
  }
});
