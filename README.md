# DEMO - Culqi ReactJS + Custom Checkout + Culqi 3DS

La demo integra Culqi ReactJS, Custom Checkout, Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

## Requisitos

* React 17.0 o superior
* Afiliate [aquí](https://afiliate.culqi.com/).

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.c

## Instalación

Ejecuta el siguiente comando:

```bash
npm install
```

Esto generará una carpeta **vendor** donde se encuentra la librería **culqi-php**.

## Configuración frontend

Primero se tiene que modificar los valores del archivo `.env` que se encuentra en la raíz del proyecto.
A continuación un ejemplo.

> Puedes activar la encriptación o desactivarla.

```toml
VITE_APP_CULQI_API_URL=https://api.culqi.com/v2
VITE_APP_CULQI_CHECKOUT_URL=https://js.culqi.com/checkout-js
VITE_APP_CULQI_CULQI_3DS_URL=https://3ds.culqi.com

VITE_APP_CULQI_CURRENCY=PEN

VITE_APP_CULQI_PUBLICKEY=<<LLAVE PUBLICA>>
VITE_APP_CULQI_SECRETKEY=<<LLAVE PRIVADA>>
VITE_APP_CULQI_RSA_ID=<<LLAVE PÚBLICA RSA ID>>
VITE_APP_CULQI_RSA_PUBLICKEY=<<LLAVE PÚBLICA RSA>>

```

## Inicialización de la demo
Ejecuta el siguiente comando:

```bash
npm run dev
```

## Prueba de la demo

Para visualizar el frontend de la demo, ingresa a la siguiente URL:

- Para probar cargos: `http://localhost/5173`


## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos/?tab=readme-ov-file#lenguajes-de-programación) para encontrar una variedad de ejemplos en diferentes lenguajes.