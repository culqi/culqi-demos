//integracion

// `credentials` se está obteniendo desde _Layout.cshtml, solo para uso de la Demo
export const checkoutConfig = Object.freeze({
    TOTAL_AMOUNT: 600,
    CURRENCY: "PEN",
    PUBLIC_KEY: credentials.publicKey,
    COUNTRY_CODE: "PE",
    RSA_ID: credentials.rsaId,
    RSA_PUBLIC_KEY: credentials.rsaKey,
    ACTIVE_ENCRYPT: credentials.isEncrypt,
    URL_BASE: "https://localhost:7288/api"
});

export const customerInfo = {
    firstName: "Dennis",
    lastName: "Demo",
    address: "Av siempre viva",
    addressCity: "Lima",
    phone: "999999999",
    email: "review1" + Math.floor(Math.random() * 100) + "@culqi.com"
};
