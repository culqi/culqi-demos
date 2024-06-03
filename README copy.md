# DEMO - Culqi Kotlin + Checkout V4 + Culqi 3DS

La demo integra Culqi Kotlin, Checkout V4 , Culqi 3DS y es compatible con la v2.0 del Culqi API, con esta demo podrás generar cargos y ordenes.

## Requisitos

* WebHosting
* Kotlin 1.9.0 +
* Backend para generar cargos y órdenes.
* Afiliate [aquí](https://afiliate.culqi.com/).
* Si vas a realizar pruebas obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro), si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Recuerda que para obtener tus llaves debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Recuerda que las credenciales son enviadas al correo que registraste en el proceso de afiliación.

## Configuración

Dentro de la carpeta **assets** encontraras un archivo con el nombre checkoutv4.html donde modificaremos las siguientes lineas:

```html
 Culqi3DS.publicKey = "pk_test_90667d0a57d45c48";
 Culqi.publicKey = 'pk_test_90667d0a57d45c48';
```

En dichas lineas estamos asignando nuestra llave pública(pk), tanto a la configuración del checkoutv4 asi como a la del Culqi 3DS, luego modificaremos la siguiente lineas para poder realizar cargos y ordenes

> Importante: No debes colocar tu llave privada(sk) dentro de tu proyecto front.

```javacript
"Authorization": "Bearer sk_test_1573b0e8079863ff"
```

Luego debemos cargar el checkoutv4.html y el archivo jquery.min.js a nuestro webhosting.
Subido los archivos deberemos tener una ruta parecida a la siguiente:

https://{tudominio}/checkoutv4.html

Luego, en el archivo MainActivity.kt colocamos dicha ruta en la siguiente parte de código.


```kotlin
browser.loadUrl("https://{tudominio}/checkoutv4.html")
```

Tambien remplazamos esa url en el archivo checkoutv4.html, esto es necesario para una correcta configuración de Culqi 3DS.

```javascript
returnUrl: "https://{tudominio}/checkoutv4.html"
```


## Inicializar la demo

Para inicializar la demo en AndroidStudio primero debemos seleccionar el emulador o celular donde se levantará la aplicación y pulsar el botón run.


## Probar la demo

Para poder visualizar la demo debemos generar un apk desde el menu Build/Build Bundle(s)/APK(s) de AndroidStudio, luego proceder a instalarlo en algún emulador o dispositivo celular.


## Importante para producción

No debes configurar tu llave privada(sk) dentro del proyecto, para efectos de pruebas en está demo se colocó la sk en el archivo checkoutv4.html, pero tu sk debe estar protegido.
Para ello debes desarrollar un backend para el proyecto, el cual hará uso de tu sk y consumirá los servicio de [cargos](https://apidocs.culqi.com/#tag/Cargos/operation/crear-cargo) y [órdenes](https://apidocs.culqi.com/#tag/Ordenes/operation/crear-orden) de Culqi, posteriomente este bakend debe ser consumido desde tu aplicación android.
