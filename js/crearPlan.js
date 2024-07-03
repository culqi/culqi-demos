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
  var  pay_info= $('#pay_info').val()

 
  $.ajax({
    type: 'POST',
    url: 'http://localhost/culqi-recurrencia-v4/culqi-php-develop/examples/03-create-plan.php',
    data: { name , short_name , description, currency , amount , interval_count , 
              initial_cycles, image, interval_unit_time , pay_info },
    datatype: 'json',
    success: function(data) {
      var result3 = "";
      if(data.constructor == String){
          result3 = JSON.parse(data);
      }alert
      if(data.constructor == Object){
          result3 = JSON.parse(JSON.stringify(data));
      }
      if(result3.id != null){
      resultdiv3('Se creo el objeto Plan con el siguiente ID: ' + result3.id);
      }
      if(result3.object === 'error'){
          resultdiv3(result3);
          alert(result3.merchant_message);
      }
    },
    error: function(error) {
      resultdiv3(error)
    }
  });


  function resultdiv3(message){
    $('#response-panel3').show();
    $('#response3').html(message);
  }
});

 /*$.ajax({
    type: 'POST',
    url: 'http://localhost/culqi-recurrencia-v4/culqi-php-develop/examples/03-create-plan.php',
    data: { 
      name: name,
      short_name: short_name,
      description: description,
      image: image,
      currency: currency,
      amount: amount,
      interval_count: interval_count,
      initial_cycles: initial_cycles,
      interval_unit_time: interval_unit_time,
      pay_info: pay_info
    },
    dataType: 'json',
    success: function(data) {
      var result3 = "";
      if (typeof data === 'string') {
        result3 = JSON.parse(data);
      } else if (typeof data === 'object') {
        result3 = data;
      }
      if (result3.object === 'plan') {
        resultdiv3('Se creó el objeto Plan con el siguiente ID: ' + result3.id);
      }
      if (result3.object === 'error') {
        resultdiv3(result3);
      }
    },
    error: function(error) {
      resultdiv3(error);
    }
  });/**
   * 
   * @param {FUNcionaaaaaaaa} message 
   */
