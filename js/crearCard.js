import { checkoutConfig } from "../js/config/index.js";
import { getListCards } from "../js/listCards.js";

$("#response-panel2").hide();

const paymentMethods={
  tarjeta: true,
  yape: true,
  billetera: true,
  bancaMovil: true,
  agente: true,
  cuotealo: true,	
}

const options ={
  lang: 'auto',
  installments: true, // Habilitar o deshabilitar el campo de cuotas
  modal: true,
  container: "#culqi-container", // Opcional - Div donde quieres cargar el checkout
  paymentMethods: paymentMethods,
  paymentMethodsSort: Object.keys(paymentMethods), // las opciones se ordenan según se configuren en paymentMethods
};

const appearance = {
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

const settings = {
  title: 'Culqi  store 2',
  currency: 'PEN', // Este parámetro es requerido para realizar pagos yape
  amount: 0, // Este parámetro es requerido para realizar pagos yape(80.00)
};

const client = {
  email: '',
};

const config = {
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
const publicKey = `${checkoutConfig.PUBLIC_KEY}`; //Ingresa la llave pública de tu comercio

const Culqi = new CulqiCheckout(publicKey, config);

Culqi.culqi = handleCulqiAction;

function createCard(token) {
    if (token) {
    var idCustomer = $('#idCustomer').val()
    //
    var BASE_URL = `${checkoutConfig.URL_BASE}`;
    console.log(BASE_URL)

    $.ajax({
      type: 'POST',
      url: BASE_URL+"/ajax/createCard.php",
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
  console.log(Culqi.token);
});



function resultdiv2(message) {
  $('#response-panel2').show();
  $('#response2').html(message);
}
