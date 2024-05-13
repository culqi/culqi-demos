# DEMO - Culqi Python + Checkout V4 + Culqi 3DS


La demo integra Culqi Python, Custom Checkout, Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

## Requisitos

* Python 2.7 o superior
* Afiliate [aquí](https://afiliate.culqi.com/).

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.

## Instalación

Ejecuta los siguientes comandos:

```bash
py -m pip install culqi-python-oficial
py -m pip install flask
py -m pip install flask_restful
py -m pip install pycryptodome
py -m pip install flask_cors
```

## Configuración backend

En el archivo **index.py** coloca tus llaves:

``` py
public_key = "<<LLAVE PÚBLICA>>"
private_key = "<<LLAVE PRIVADA>>"
rsa_id = "<<RSA ID>>"
rsa_public_key = ("<<LLAVE PúBLICA RSA>>")
```

## Configuración frontend

Para configurar los datos del cargo, la llave pública del comercio, el ID de la llave RSA, la llave pública RSA y los datos del cliente, debes modificar el archivo `static/js/config/index.js`.

```js
export default Object.freeze({
    TOTAL_AMOUNT: 600, // monto de pago,
    CURRENCY: "PEN",// tipo de moneda,
    PUBLIC_KEY: "<<LLAVE PÚBLICA>>", // llave publica del comercio (pk_test_xxxxx),
    RSA_ID: "<<LLAVE PÚBLICA RSA ID>>", //Id de la llave RSA,
    RSA_PUBLIC_KEY: "<<LLAVE PÚBLICA RSA>>", // Llave pública RSA que sirve para encriptar el payload de los servicios del checkout,
    COUNTRY_CODE: "PE", // iso code del país
});
```

## Inicialización de la demo

Ejecuta el siguiente comando:

```bash
py index.py
```

## Prueba de la demo

Para visualizar el frontend de la demo, ingresa a la siguiente URL:

- Para probar cargos: `http://localhost:5100`

## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos/?tab=readme-ov-file#lenguajes-de-programación) para encontrar una variedad de ejemplos en diferentes lenguajes.
