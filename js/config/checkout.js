import config from "./index.js";

const culqiConfig = (jsonParams) => {

	const settings = {
		title: "Culqi 3DS TEST",
		order: jsonParams.orderId,
		currency: config.CURRENCY,
		// description: "Polo/remera Culqi lover",
		amount: jsonParams.amount,
	};

	const paymentMethods = {
		tarjeta: true,
		bancaMovil: true,
		agente: true,
		billetera: true,
		cuotealo: true,
		yape: true,
	};

	const options = {
		lang: "auto",
		installments: jsonParams.installments,
		modal: true,
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
			//logo: 'https://culqi.com/LogoCulqi.png',
			bannerColor: "", // hexadecimal
			buttonBackground: "", // hexadecimal
			menuColor: "", // hexadecimal
			linksColor: "", // hexadecimal
			// buttonText: jsonParams.buttonTex, // texto que tomará el botón
			buttonTextColor: "", // hexadecimal
			priceColor: "", // hexadecimal
		},
	};

	const culqiConfig = {
		settings,
		// client,
		options,
		appearance,
	};

	const publicKey = config.PUBLIC_KEY;

	const Culqi = new CulqiCheckout(publicKey, culqiConfig);
	console.log(`Culqi instantiated`);
	return Culqi;
}

export default culqiConfig;