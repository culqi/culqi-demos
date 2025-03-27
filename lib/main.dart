import 'dart:io';

import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'package:webview_flutter_android/webview_flutter_android.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
      debugShowCheckedModeBanner: false,
      home: WebViewExample(),
    );
  }
}

class WebViewExample extends StatefulWidget {
  const WebViewExample({super.key});

  @override
  State<WebViewExample> createState() => _WebViewExampleState();
}

class _WebViewExampleState extends State<WebViewExample> {
  late final WebViewController _controller;

  @override
  void initState() {
    super.initState();

    _controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..loadHtmlString(_rawHtml);

    // Recomendado !
    // Si quieres usar una URL externa cambia la linea en la 36 por esta:
    // ..loadRequest(Uri.parse("https://a4157b60183d48c939fe451bfb1197c8.loophole.site/test/index-js-v4-qa.html"));

    // Si quieres usar un html local cambia la linea en la 36 por esta:
    // ..loadHtmlString(_rawHtml);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Culqi Checkout HTML')),
      body: WebViewWidget(controller: _controller),
    );
  }
}

// HTML embebido como string
const String _rawHtml = '''
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="https://culqi.com/assets/images/brand/brand.svg"
      type="image/x-icon"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Pruebas | Culqi JS V4</title>
  </head>
  <body>
    <div
      class="flex place-content-center items-center h-screen bg-blue-200 border-2 border-solid border-orange-500"
    >
      <button
        id="btnOpenCheckout"
        class="bg-purple-500 rounded-lg px-6 py-4 text-white font-semibold text-lg"
      >
        Open Checkout
      </button>
    </div>
    <script id="v4" src="https://checkout.culqi.com/js/v4"></script>
    <script>
      Culqi.publicKey = "pk_live_6b3914664db6a6be";

      Culqi.settings({
        currency: "PEN",
        amount: 19000,
        title: "Culqi test Qa",
        order: "ord_test_lZrefsAIp9UNJbYB",
      });

      Culqi.options({
        paymentMethods: {
          tarjeta: true,
          yape: true,
          billetera: true,
          bancaMovil: true,
          agente: true,
          cuotealo: true,
        },
        style: {
          bannerColor: "#141414",
          buttonBackground: "#D20808",
          menuColor: "#D20808",
          linksColor: "#D20808",
          buttonText: "",
          buttonTextColor: "#ffffff",
          priceColor: "#D20808",
          logo: "https://media1.tenor.com/m/uCBhZENaMOoAAAAd/hamster-cute.gif",
        },
      });

      const btnOpenCheckout = document.getElementById("btnOpenCheckout");

      const openCheckout = (event) => {
        event.preventDefault();
        Culqi.open();
      };

      btnOpenCheckout.addEventListener("click", openCheckout);

      const culqi = () => {
        if (Culqi.token) {
          const token = Culqi.token.id;
          console.log(`Se ha creado el objeto Token: \${token}.`);
          return;
        }

        if (Culqi.order) {
          const order = Culqi.order.id;
          console.log(`Se ha creado el objeto Order: \${order}.`);
          if (order.cuotealo) {
            console.log(`Se ha creado el link cuotéalo: \${order.cuotealo}.`);
          }
          if (order.qr) {
            console.log(`Se ha creado el link QR: \${order.qr}.`);
          }
          return;
        }

        if (Culqi.error && Culqi.error.merchant_message) {
          console.log(`Culqi Error : \${Culqi.error.merchant_message}.`);
        }
      };
    </script>
  </body>
</html>
''';
