$("#response-panel2").hide();
publicKey = 'pk_test_753a58aa78e4f7e2'; //Ingresa la llave pública de tu comercio

paymentMethods={// las opciones se ordenan según se configuren
  tarjeta: true,
  yape: true,
  billetera: true,
  bancaMovil: true,
  agente: true,
  cuotealo: true,	
}

options ={
  lang: 'auto',
  installments: true, // Habilitar o deshabilitar el campo de cuotas
  modal: true,
  container: "#culqi-container", // Opcional - Div donde quieres cargar el checkout
  paymentMethods: paymentMethods,
  paymentMethodsSort: Object.keys(paymentMethods), // las opciones se ordenan según se configuren en paymentMethods
};

appearance = {
  theme: "default",
  hiddenCulqiLogo: false,
  hiddenBannerContent: false,
  hiddenBanner: false,
  hiddenToolBarAmount: false,
  menuType: "sidebar", // sidebar / sliderTop / select
  buttonCardPayText: "Pagar tal monto", // 
  logo: null, // 'http://www.childrensociety.ms/wp-content/uploads/2019/11/MCS-Logo-2019-no-text.jpg',
  
  defaultStyle: {
      bannerColor: "black", // hexadecimal
      buttonBackground: "#8b5cf6", // hexadecimal
      menuColor: "pink", // hexadecimal
      linksColor: "green", // hexadecimal
      buttonTextColor: "#white", // hexadecimal
      priceColor: "red",
    },
};

settings = {
  title: 'Culqi  store 2',
  currency: 'PEN', // Este parámetro es requerido para realizar pagos yape
  amount: 0, // Este parámetro es requerido para realizar pagos yape(80.00)
};

const client = {
  email: '',
};

config = {
  settings,
  client,
  options,
  appearance,
};



const handleCulqiAction = () => {
  if (Culqi.token) {
    const token = Culqi.token.id;
    console.log('Se ha creado un Token: ', token);
    createCard(token);
  } else {
    console.log('Errorrr : ', Culqi.error);
  }
}


Culqi = new CulqiCheckout(publicKey, config);

Culqi.culqi = handleCulqiAction;

function createCard(token) {
  console.log('Test');
    if (token) {
    var idCustomer = $('#idCustomer').val()
    $.ajax({
      type: 'POST',
      url: 'http://localhost/culqi-recurrencia-v4/culqi-php-develop/examples/07-create-card.php',
      data: { token: token, idCustomer },
      datatype: 'json',
      success: function (data) {
        var result2 = "";
        if (data.constructor == String) {
          result2 = JSON.parse(data);
          console.log('Botón crear tarjeta '); 
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
  }
};

$('#crearCard').on('click', function (e) {
  Culqi.open();
  console.log('Botón crear tarjeta clickeado'); 
  e.preventDefault();
  console.log(Culqi.culqi);
});



function resultdiv2(message) {
  $('#response-panel2').show();
  $('#response2').html(message);
}
