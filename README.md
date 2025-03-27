# 📦 Culqi Checkout WebView Example (Flutter)

Este proyecto es un ejemplo de cómo integrar **Culqi Checkout (JS v4)** dentro de una aplicación **Flutter** utilizando el paquete [`webview_flutter`](https://pub.dev/packages/webview_flutter). Este ejemplo carga un HTML embebido directamente como un `String` y renderiza una experiencia de pago con múltiples métodos compatibles con Culqi.

---

## 🚀 Características

- Renderiza un HTML local embebido con WebView.
- Carga el script de Culqi Checkout JS v4.
- Configura múltiples métodos de pago (`tarjeta`, `yape`, `billetera`, `bancaMovil`, `agente`, `cuotealo`).
- Usa `WebViewController` con JavaScript habilitado (`unrestricted`).
- Compatible con Android.

---

## ¿HTML embebido o por enlace?

Culqi Checkout JS v4 puede ser integrado de dos formas:

1. **HTML embebido**: Carga el script de Culqi Checkout JS v4 directamente en un HTML embebido.
2. **Por enlace**: Carga el script de Culqi Checkout JS v4 a través de un enlace.
