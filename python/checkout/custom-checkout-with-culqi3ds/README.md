# DEMO - Culqi Python + Checkout V4 + Culqi 3DS


La demo integra Culqi Python, Custom Checkout, Culqi 3DS y es compatible con la v2.0 del Culqi API, con esta demo podrás generar tokens, cargos, clientes, cards.

## Requisitos

* Python 2.7+
* Afiliate [aquí](https://afiliate.culqi.com/).
* Si vas a realizar pruebas obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro), si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Recuerda que para obtener tus llaves debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Recuerda que las credenciales son enviadas al correo que registraste en el proceso de afiliación.

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

- public_key = "`TU LLAVE PK DE INTEGRACIÓN`"
- private_key = "`TU LLAVE SK DE INTEGRACIÓN`"
- rsa_id = "`TU ID DE TU LLAVE PÚBLICA RSA`"
- rsa_public_key = "`TU LLAVE PÚBLICA RSA`"

## Configuración frontend

Para configurar los datos del cargo, pk del comercio,rsa_id y rsa_public_key y datos del cliente se tiene que modificar en el archivo `static/js/config/index.js`.

```js
export default Object.freeze({
    TOTAL_AMOUNT: monto de pago,
    CURRENCY: tipo de moneda,
    PUBLIC_KEY: llave publica del comercio (pk_test_xxxxx),
    RSA_ID: Id de la llave RSA,
    RSA_PUBLIC_KEY: Llave pública RSA que sirve para encriptar el payload de los servicios del checkout,
    COUNTRY_CODE: iso code del país(Ejemplo PE)
});
```

## Inicializar la demo

Ejecutar el siguiente comando:

```bash
py index.py
```

## Probar la demo

Para poder visualizar el frontend de la demo ingresar a la siguiente URL:

- Para probar cargos: `http://localhost:5100`

## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)