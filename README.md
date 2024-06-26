# DEMO - Culqi Android + Custom Checkout + Culqi 3DS

La demo integra Culqi Android, Custom Checkout, Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos.

## Requisitos

* WebHosting
* Android 4.0 +
* Backend para generar cargos y órdenes.

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Recuerda que las credenciales son enviadas al correo que registraste en el proceso de afiliación.

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.c

## Configuración

Para configurar los datos del cargo, pk del comercio y datos del cliente se tiene que modificar en el archivo `/app/src/main/assets/custom-checkout.html`.


```js
const publicKey = "<<LLAVE PÚBLICA>>";
const secretKey = "<<LLAVE PRIVADA>>";
```


> Importante: No debes colocar tu llave privada(sk) dentro de tu proyecto front.

Luego debemos cargar el custom-checkout.html y los archivos `*js` a nuestro webhosting.
Subido los archivos deberemos tener una ruta parecida a la siguiente:

https://{tudominio}/custom-checkout.html

Luego en el archivo MainActivity colocamos esa ruta en la siguiente parte de código


```java
browser.loadUrl("https://{tudominio}/custom-checkout.html")
```

Tambien remplazamos esa url en el archivo custom-checkout.html, esto es necesario para una correcta configuración de Culqi 3DS.

```javascript
returnUrl: "https://{tudominio}/custom-checkout.html"
```


## Inicializar la demo

Para inicializar la demo en AndroidStudio primero debemos seleccionar el emulador o celular donde se levantará la aplicación y pulsar el botón run.


## Prueba de la demo

Para poder visualizar la demo debemos generar un apk desde el menu Build/Build Bundle(s)/APK(s) de AndroidStudio, luego proceder a instalarlo en algún emulador o dispositivo celular.

## Importante para producción

No debes configurar tu llave privada(sk) dentro del proyecto, para efectos de pruebas en está demo se colocó la sk en el archivo custom-checkout.html, pero tu sk debe estar protegido.
Para ello debes desarrollar un backend para el proyecto, el cual hará uso de tu sk y consumirá los servicio de [cargos](https://apidocs.culqi.com/#tag/Cargos/operation/crear-cargo) y [órdenes](https://apidocs.culqi.com/#tag/Ordenes/operation/crear-orden) de Culqi, posteriomente este bakend debe ser consumido desde tu aplicación android.

## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos/?tab=readme-ov-file#lenguajes-de-programación) para encontrar una variedad de ejemplos en diferentes lenguajes.