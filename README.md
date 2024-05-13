# DEMO - Culqi Angular + Custom Checkout + Culqi 3DS

La demo integra Culqi Angular, Custom Checkout, Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

## Requisitos

* Angular 16.0 o superior
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

Primero se tiene que modificar los valores del archivo `src/app/env/dev.env.ts`. A continuación un ejemplo.
Puedes activar la encriptación o desactivarla.

```typescript
export const secretKey = '<<LLAVE PRIVADA>>';
export const publicKey = '<<LLAVE PÚBLICA>>';

export const rsaId = '<<LLAVE PÚBLICA RSA ID>>';
export const rsaPublickKey = '<<LLAVE PÚBLICA RSA>>';

export const encrypt = false;
```

## Inicialización de la demo
Ejecuta el siguiente comando:

```bash
npm start
```

## Prueba de la demo

Para visualizar el frontend de la demo, ingresa a la siguiente URL:

- Para probar cargos: `http://localhost/4200`


## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos/?tab=readme-ov-file#lenguajes-de-programación) para encontrar una variedad de ejemplos en diferentes lenguajes.