# DEMO - Culqi PHP + Checkout V4 + Culqi 3DS

La demo integra Culqi PHP, Checkout V4 , Culqi 3DS y es compatible con la v2.0 del Culqi API, con esta demo podrás generar tokens, cargos, clientes, cards.

## Requisitos

* PHP 7.0+
* Afiliate [aquí](https://afiliate.culqi.com/).
* Si vas a realizar pruebas obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro), si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Recuerda que para obtener tus llaves debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Recuerda que las credenciales son enviadas al correo que registraste en el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.

## Instalación

Para la instalación de la librería de Culqi se debe ejecutar el siguiente comando en la raiz del proyecto.

```bash
composer require culqi/culqi-php
```

Esto generará una carpeta **vendor** donde se encuentra la librería **culqi-php**.

## Configuración backend

Primero se tiene que modificar los valores del archivo `settings.php` que se encuentra en la raíz del proyecto. A continuación un ejemplo.
Puedes activar la encriptación o desactivarla.

```
define('PUBLIC_KEY', 'Llave pública del comercio (pk_test_xxxxxxxxx)');
define('SECRET_KEY', "Llave secreta del comercio (sk_test_xxxxxxxxx)");
define('RSA_ID', 'Id de la llave RSA');
define('RSA_PUBLIC_KEY', 'Llave pública RSA que sirve para encriptar el payload de los servicios');
```
## Configuración frontend

Para configurar los datos del cargo, pk del comercio y datos del cliente se tiene que modificar en el archivo `/js/config/index.js`.
Puedes activar la encriptación o desactivarla.

```js
export default Object.freeze({
    TOTAL_AMOUNT: monto de pago,
    CURRENCY: tipo de moneda,
    PUBLIC_KEY: llave publica del comercio (pk_test_xxxxx),
    RSA_ID: Id de la llave RSA,
    RSA_PUBLIC_KEY: Llave pública RSA que sirve para encriptar el payload de los servicios del checkout,
    COUNTRY_CODE: iso code del país(Ejemplo PE)
    ACTIVE_ENCRYPT: true (true = encyptación activada , false = encyptación inactivada)
});

export const customerInfo = {
    firstName: "Fernando",
    lastName: "Chullo",
    address: "Coop. Villa el Sol",
    phone: "945737476",
}
```

## Inicializar la demo
El proyecto se debe levantar con un servidor local(Ejemplo Xampp)

## Probar la demo

Para poder visualizar el frontend de la demo ingresar a la siguiente URL:

- Para probar cargos: `http://localhost/culqi-php-demo-checkoutv4-culqi3ds`
- Para probar creación de cards: `http://localhost/culqi-php-demo-checkoutv4-culqi3ds/index_card.php`


## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)
