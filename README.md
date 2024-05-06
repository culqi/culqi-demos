# DEMO - Culqi Java + Custom Checkout + Culqi 3DS

La demo integra Culqi Java, Custom Checkout, Culqi 3DS y es compatible con la v2.0 del Culqi API, con esta demo podrás generar tokens, cargos, clientes, cards.

## Requisitos

* Java 1.8 o superior
* Afiliate [aquí](https://afiliate.culqi.com/).
* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* Si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://mipanel.culqi.com).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.

## Instalación

Agregar la siguientes configuraciones al archivo `pom.xml` del proyecto

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

En el archivo `application.properties` que se encuentra en `src/resource/` coloca tus llaves:

```properties
app.culqi.public-key = <<LLAVE PÚBLICA>> # Llave pública del comercio (pk_test_xxxxxxxxx)
app.culqi.secret-key = <<LLAVE PRIVADA>> # Llave secreta del comercio (sk_test_xxxxxxxxx)
app.culqi.rsa-id = <<RSA ID>> # Id de la llave RSA
app.culqi.rsa-public-key = <<LLAVE PúBLICA RSA>> # Llave pública RSA que sirve para encriptar el payload de los servicios
```
## Configuración frontend

Para configurar los datos del cargo, la llave pública del comercio, el ID de la llave RSA, la llave pública RSA y los datos del cliente, debes modificar el archivo `src/resources/public/js/config/index.js`.

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

Abrir la terminal (Bash/CMD) y ubicarse dentro del proyecto para ejecutar los siguientes comandos.

```bash
mvn clean package
mvn spring-boot:run
```

## Prueba de la demo

Para visualizar el frontend de la demo, ingresa a la siguiente URL:

- Para probar cargos:`http://localhost:8080`

## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos/?tab=readme-ov-file#lenguajes-de-programación) para encontrar una variedad de ejemplos en diferentes lenguajes.
