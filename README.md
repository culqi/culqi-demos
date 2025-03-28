# 📦 Culqi Checkout WebView Example (Swift)

Este proyecto es un ejemplo de cómo integrar **Culqi Checkout (JS Custom)** dentro de una aplicación **iOS nativa en Swift** utilizando `WKWebView`. Este ejemplo carga un archivo HTML local directamente desde el bundle de la app y renderiza una experiencia de pago con múltiples métodos compatibles con Culqi.

La demo integra Culqi Checkout Custom, Culqi 3DS y es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

---

## 🚀 Características

- Renderiza un archivo HTML local con `WKWebView`.
- Carga el script de Culqi Checkout JS Custom.
- Configura múltiples métodos de pago (`tarjeta`, `yape`, `billetera`, `bancaMovil`, `agente`, `cuotealo`).
- Habilita JavaScript en `WKWebViewConfiguration`.
- Compatible con iOS 13 en adelante.

---

## ¿HTML embebido o por enlace?

Culqi Checkout JS Custom puede ser integrado de dos formas:

1. **HTML embebido**: Carga el script de Culqi Checkout JS Custom directamente en un HTML embebido.
2. **Por enlace**: Carga el script de Culqi Checkout JS Custom a través de un enlace.
 
---

## Requisitos

* Xcode 15 o superior.
* Swift 5.
* Dispositivo iOS o simulador con iOS 13+.
* Afiliate [aquí](https://afiliate.culqi.com/).

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.c

## Instalación

1. Clona el repositorio o descarga el proyecto.
2. Abre `CulqiCheckout.xcodeproj` en Xcode.
3. Asegúrate de incluir el archivo `custom-checkout.html` en tu bundle.
4. Modifica la llave pública en `MainViewController.swift`:

---

## Configuración del proyecto

se debe modificar el public_key 

```
Llave pública del comercio (pk_test_xxxxxxxxx); 
```

## Prueba de la demo

Ejecuta la aplicación en un simulador o dispositivo físico desde Xcode:

```bash
Cmd + R
```

## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos) para encontrar una variedad de ejemplos en diferentes lenguajes.
