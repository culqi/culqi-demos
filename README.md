# DEMO - Culqi Net/NetCore + Custom Checkout + Culqi 3DS

Esta demostración integra Culqi Net/NetCore, Custom Checkout y Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

## Requisitos

* Net 6.0+
* Visual Studio 2022
* culqinet.dll (se genera a partir de la librería culqi-net)
* Afiliate [aquí](https://afiliate.culqi.com/).

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

## Preconfiguración / Instalación de Librerías

Para que la demo funcione, debes instalar el archivo **CulqiNet.dll** generado desde la librería [Culqi-Net](https://github.com/culqi/culqi-net). La demo ya incluye esta DLL en su ruta principal.

Si deseas actualizar a la última versión de la librería Culqi-Net, puedes descargarla desde los tags en:
https://github.com/culqi/culqi-net/tags

https://github.com/culqi/culqi-net/tags

## Configuración backend

Primero, debes modificar los valores del archivo `appsettings.Development.json`, ubicado en la raíz del proyecto. Aquí tienes un ejemplo:

```json
{
  "CulqiSettings": {
      "Encrypt": false,
      "PublicKey": "<<LLAVE PÚBLICA>>",
      "SecretKey": "<<LLAVE SECRETA>>",
      "RsaId": "<<LLAVE PÚBLICA RSA ID>>",
      "RsaKey": "<<LLAVE PÚBLICA RSA>>"
  },
}
```
## Configuración frontend

Para el uso de la demo, se están obteniendo los credentials a través de ViewBag en `_Layout.cshtml`.

```js
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
    address: "Av. siempre viva",
    phone: "999999999",
}
```

## Inicialización de la demo

Ejecutar la demo desde Visual Studio 2022 o +.

## Prueba de la demo

Para visualizar el frontend de la demo, ingresa a la siguiente URL:

- Para probar cargos: `https://localhost:7288`


## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos/?tab=readme-ov-file#lenguajes-de-programación) para encontrar una variedad de ejemplos en diferentes lenguajes.