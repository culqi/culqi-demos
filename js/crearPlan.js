import { checkoutConfig } from "../js/config/index.js";
import { PlanV } from "../js/utils/helpers.js";

$("#response-panel3").hide();
$('#crearPlan').on('click', function (e) {
  var name = $("#name_plan").val();
  var short_name = $('#short_name').val();
  var description = $('#description').val();
  var image = $('#image').val();
  var currency = $('#moneda_plan').val();
  var amount = $('#monto_plan').val();
  var interval_count = $('#interval_count').val();
  var initial_cycles = $('#ciclo_inicial').val();
  var interval_unit_time = $('#interval_unit_time').val();
  var  pay_info= $('#pay_info').val();
  var BASE_URL = `${checkoutConfig.URL_BASE}`;

   // Llamar a la función de validación con los parámetros
   const validationResponse = PlanV(name, short_name, description, currency, amount, interval_count, initial_cycles, interval_unit_time, pay_info);

   // Si la validación falla, mostrar el mensaje y detener la ejecución
   if (validationResponse.error) {
     resultdiv3(validationResponse.error);
     return; // Detener la ejecución si hay un error
   }
 
   $.ajax({
    type: 'POST',
    url: BASE_URL+"/ajax/plan.php",
    data: { name , short_name , description, currency , amount , interval_count , 
              initial_cycles, image, interval_unit_time , pay_info },
    datatype: 'json',
    success: function(data) {
      var result3 = "";
      if(data.constructor == String){
          result3 = JSON.parse(data);
      }
      if(data.constructor == Object){
          result3 = JSON.parse(JSON.stringify(data));
      }
      if (result3.id != null) {
        $("#idPlan").val(result3.id); // Intentar asignar el ID al input
        resultdiv3('Se creó el objeto Plan con el siguiente ID: ' + result3.id);
      }
      if(result3.object === 'error'){
          resultdiv3(result3);
          alert(result3.merchant_message);
      }
    },
    error: function(error) {
      if (error.status === 400 && error.responseJSON.error) {
        resultdiv3(error.responseJSON.error);
        alert("Error: " + error.responseJSON.error);
      }
    }
  });

  function resultdiv3(message){
    $('#response-panel3').show();
    $('#response3').html(message);
  }
});