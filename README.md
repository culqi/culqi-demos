# DEMO - Culqi Go + Custom Checkout + Culqi 3DS

Esta demostración integra Culqi Go, Custom Checkout y Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

## Requisitos

* Go 1.9 o superior
* Afiliate [aquí](https://afiliate.culqi.com/).

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

## Configuración backend

Primero, debes modificar los valores del archivo `config/config.go`, que se encuentra en la raíz del proyecto. Aquí te dejo un ejemplo:

```Go
const (
	Publickey    = "<<LLAVE PÚBLICA>>" // Llave pública del comercio
	Secretkey    = "<<LLAVE SECRETA>>" // Llave secreta del comercio
	rsaID        = "<<LLAVE PÚBLICA RSA ID>>" // Id de la llave RSA
	rsaPublicKey = "<<LLAVE PÚBLICA RSA>>" // Llave pública RSA que sirve para encriptar el payload de los servicios
	Port          = ":3000"
	Encrypt       = "0" // 1 = activar encriptación
	encryptionFmt = `{
		"rsa_public_key": "%s",
		"rsa_id":  "%s"
	}`
)
```
## Configuración frontend

Para configurar los datos del cargo, la llave pública del comercio, el ID de la llave RSA, la llave pública RSA y los datos del cliente, debes modificar el archivo `src/js/config/index.js`.

```js
export default Object.freeze({
    TOTAL_AMOUNT: 600, // monto de pago,
    CURRENCY: "PEN",// tipo de moneda,
    PUBLIC_KEY: "<<LLAVE PÚBLICA>>", // llave publica del comercio (pk_test_xxxxx),
    RSA_ID: "<<LLAVE PÚBLICA RSA ID>>", //Id de la llave RSA,
    RSA_PUBLIC_KEY: "<<LLAVE PÚBLICA RSA>>", // Llave pública RSA que sirve para encriptar el payload de los servicios del checkout,
    COUNTRY_CODE: "PE", // iso code del país
});

export const customerInfo = {
    firstName: "Dennis",
    lastName: "Demo",
    address: "Av. siempre viva",
    phone: "999999999",
}
```

## Inicialización de la demo

Ejecuta los siguientes comandos:

```go
go mod init
go mod tidy
go run main.go
```

## Prueba de la demo

Para visualizar el frontend de la demo, ingresa a la siguiente URL:

- Para probar cargos: `http://localhost:3000`


## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos/?tab=readme-ov-file#lenguajes-de-programación) para encontrar una variedad de ejemplos en diferentes lenguajes.