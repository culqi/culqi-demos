# DEMO - Culqi RUST + Checkout V4 + Culqi 3DS

La demo integra Culqi RUST, Custom Checkout, Culqi 3DS y es compatible con la v2.0 del Culqi API, con esta demo podrás generar tokens, cargos, clientes y tarjetas.

## Requisitos

- Rust 1.60.0+
- Afiliate [aquí](https://afiliate.culqi.com/).
- Si vas a realizar pruebas obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro), si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://mipanel.culqi.com/#/registro).

> Recuerda que para obtener tus llaves debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Recuerda que las credenciales son enviadas al correo que registraste en el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA  ingresando a CulqiPanel > Desarrollo  > RSA Keys.

## Instalación

Ejecuta los siguientes comandos:

```bash
cargo build
```

## Configuración backend

En el archivo **src/main.rs** configura tus llaves:

```rust
let SKEY: &str = "Llave pública del comercio (pk_test_xxxxxxxxx)";
let PKEY: &str = "Llave secreta del comercio (sk_test_xxxxxxxxx)";
let RSAID: &str = "Id de la llave RSA";
let CULQI_RSA_KEY: &str = "Llave pública RSA que sirve para encriptar el payload de los servicios";
```
Nota: Cambiar los valores de las variables en cada método según corresponda.


## Configuración frontend
Para configurar los datos del cargo, pk del comercio, rsa_id, rsa_public_key y datos del cliente se tiene que modificar en el archivo `static/js/config/index.js`.

```js
export default Object.freeze({
  TOTAL_AMOUNT: 600,
  CURRENCY: "PEN",
  PUBLIC_KEY: "Llave pública del comercio (pk_test_xxxxxxxxx)",
  COUNTRY_CODE: "PE",
  RSA_ID: "Id de la llave RSA",
  RSA_PUBLIC_KEY: 'Llave pública RSA que sirve para encriptar el payload de los servicios',
});
```

## Inicializar la demo
Ejecutar el siguiente comando:

```bash
cargo run
```

## Probar la demo

Para poder visualizar el frontend de la demo ingresar a la siguiente URL:

- Para probar cargos: http://localhost:3030/index.html
- Para probar creación de cards: http://localhost:3030/index_card.html

## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos) para encontrar una variedad de ejemplos en diferentes lenguajes.