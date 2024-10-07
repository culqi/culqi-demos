# DEMO - Culqi PHP + Custom Checkout + Culqi 3DS

La demo integra Culqi PHP, Custom Checkout, Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

## Requisitos

* PHP 7.4 o superior
* Afiliate [aquí](https://afiliate.culqi.com/).

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.c

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
    TOTAL_AMOUNT: 600, // monto de pago,
    CURRENCY: "PEN",// tipo de moneda,
    PUBLIC_KEY: "<<LLAVE PÚBLICA>>", // llave publica del comercio (pk_test_xxxxx),
    RSA_ID: "<<LLAVE PÚBLICA RSA ID>>", //Id de la llave RSA,
    RSA_PUBLIC_KEY: "<<LLAVE PÚBLICA RSA>>", // Llave pública RSA que sirve para encriptar el payload de los servicios del checkout,
    COUNTRY_CODE: "PE", // iso code del país
    ACTIVE_ENCRYPT: true (true = encyptación activada , false = encyptación inactivada)
});
```

## Inicialización de la demo
El proyecto se debe levantar con un servidor local(Ejemplo Xampp)

## Prueba de la demo

Para visualizar el frontend de la demo, ingresa a la siguiente URL:

- Para probar cargos: `http://localhost/culqi-demos`


## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos) para encontrar una variedad de ejemplos en diferentes lenguajes.
