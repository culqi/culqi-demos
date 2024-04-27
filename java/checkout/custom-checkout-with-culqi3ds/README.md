# DEMO - Culqi Java + Custom Checkout + Culqi 3DS

La demo integra Culqi Java, Custom Checkout, Culqi 3DS y es compatible con la v2.0 del Culqi API, con esta demo podrás generar tokens, cargos, clientes, cards.

## Requisitos

* Java 1.8+
* Afiliate [aquí](https://afiliate.culqi.com/).
* Si vas a realizar pruebas obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro), si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Recuerda que para obtener tus llaves debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Recuerda que las credenciales son enviadas al correo que registraste en el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.

## Instalación

Agregar la siguientes configuraciones al archivo pom.xml del proyecto

```xml
<repositories>
	<repository>
		<id>jitpack.io</id>
		<url>https://jitpack.io</url>
	</repository>
</repositories>
```

```xml
<dependency>
	<groupId>com.github.culqi</groupId>
	<artifactId>culqi-java</artifactId>
	<version>2.0.2</version>
</dependency>
```

## Configuración backend

Primero se tiene que modificar los valores del archivo `application.properties` que se encuentra en `src/resource/`. A continuación un ejemplo.

```
app.culqi_api.public-api.url: Url base de la api CULQI (https://api.culqi.com)
app.culqi.public-key: Llave pública del comercio (pk_test_xxxxxxxxx)
app.culqi.secret-key: Llave secreta del comercio (sk_test_xxxxxxxxx)
app.culqi.rsa-id: Id de la llave RSA
app.culqi.rsa-public-key: Llave pública RSA que sirve para encriptar el payload de los servicios
```
## Configuración frontend

Para configurar los datos del cargo, pk del comercio, rsa_id, rsa_public_key y datos del cliente se tiene que modificar en el archivo `src/resources/public/js/config/index.js`.

```js
export default Object.freeze({
    TOTAL_AMOUNT: monto de pago,
    CURRENCY: tipo de moneda,
    PUBLIC_KEY: llave publica del comercio (pk_test_xxxxx),
    RSA_ID: Id de la llave RSA,
    RSA_PUBLIC_KEY: Llave pública RSA que sirve para encriptar el payload de los servicios del checkout,
    COUNTRY_CODE: iso code del país(Ejemplo PE)
});

export const customerInfo = {
    firstName: "Dennis",
    lastName: "Demos",
    address: "Coop. Villa el Sol",
    phone: "900000001",
}
```

## Inicializar la demo
Abrir la terminal (Bash/CMD) y ubicarse dentro del proyecto para ejecutar los siguientes comandos.

```bash
mvn clean package
mvn spring-boot:run
```

## Probar la demo

Para poder visualizar el frontend de la demo ingresar a la siguiente URL:

- Para probar cargos: `http://localhost:8080`
- Para probar creación de cards: `http://localhost:8080/index_card.html`


## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)
