# 📦 Culqi Checkout WebView Example (Flutter)

Este proyecto es un ejemplo de cómo integrar **Culqi Checkout (JS Custom)** dentro de una aplicación **Flutter** utilizando el paquete [`webview_flutter`](https://pub.dev/packages/webview_flutter). Este ejemplo carga un HTML embebido directamente como un `String` y renderiza una experiencia de pago con múltiples métodos compatibles con Culqi.

La demo integra Culqi Flutter, Custom Checkout, Culqi 3DS. Es compatible con la versión 2.0 de la API de Culqi. Con esta demostración, podrás generar tokens, cargos, clientes y tarjetas.

##### Se recomienda que la integración con el checkout sea a través de una ruta https para que así pueda contar con todos los controles de seguridad

---

## 🚀 Características

- Renderiza un HTML local embebido con WebView.
- Carga el script de Culqi Checkout JS Custom.
- Configura múltiples métodos de pago (`tarjeta`, `yape`, `billetera`, `bancaMovil`, `agente`, `cuotealo`).
- Usa `WebViewController` con JavaScript habilitado (`unrestricted`).
- Compatible con Android.

---

## ¿HTML embebido o por enlace?

Culqi Checkout JS Custom puede ser integrado de dos formas:

1. **HTML embebido**: Carga el script de Culqi Checkout JS Custom directamente en un HTML embebido.
2. **Por enlace**: Carga el script de Culqi Checkout JS Custom a través de un enlace.
 
---

## Requisitos

* Flutter 3.8
* Android Studio 2023.1.1 o superior.
* Afiliate [aquí](https://afiliate.culqi.com/).

* Si vas a realizar pruebas, obtén tus llaves desde [aquí](https://integ-panel.culqi.com/#/registro).
* si vas a realizar transacciones reales obtén tus llaves desde [aquí](https://panel.culqi.com/#/registro) (1).

> Para obtener tus llaves, debes ingresar a tu CulqiPanel > Desarrollo > ***API Keys***.

![alt tag](http://i.imgur.com/NhE6mS9.png)

> Las credenciales son enviadas al correo electrónico que registraste durante el proceso de afiliación.

* Para encriptar el payload debes generar un id y llave RSA ingresando a CulqiPanel > Desarrollo > RSA Keys.c

## Instalación

Para la instalación de flutter.

```bash
flutter pub get
```
Esto instalará todas las dependencias necesarias para el proyecto.

---

## Configuración del proyecto

Todos los cambios se deben realizar en el archivo 

``` 
lib/main.dart
```

se debe modificar el public_key 

```
Culqi.publicKey = "pk_test_xxxxxxxxx";
Llave pública del comercio (pk_test_xxxxxxxxx); 
```

## Prueba de la demo

Para visualizar el frontend de la demo, debes ejecutar el main.dart en un emulador o dispositivo físico. Asegúrate de tener un emulador de Android o un dispositivo físico conectado a tu computadora.

```bash
flutter run
```

## Documentación

- [Referencia de Documentación](https://docs.culqi.com/)
- [Referencia de API](https://apidocs.culqi.com/)

---

> **Explora más demos en otros lenguajes de programación:**
>
> - Visita nuestro repositorio [culqi-demos](https://github.com/culqi/culqi-demos) para encontrar una variedad de ejemplos en diferentes lenguajes.
