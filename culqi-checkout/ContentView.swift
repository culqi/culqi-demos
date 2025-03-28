import SwiftUI
import WebKit

struct ContentView: View {
    var body: some View {
        CulqiWebView()
            .edgesIgnoringSafeArea(.all)
    }
}

struct CulqiWebView: UIViewRepresentable {
    func makeUIView(context: Context) -> WKWebView {
        let config = WKWebViewConfiguration()
        config.preferences.setValue(true, forKey: "developerExtrasEnabled")

        let webView = WKWebView(frame: .zero, configuration: config)
        
        // Opción para cargar una URL externa en lugar del HTML incrustado
        // Descomenta la siguiente línea para cargar la página desde una URL en lugar de código HTML
        // if let url = URL(string: "https://a4157b60183d48c939fe451bfb1197c8.loophole.site/test/jose-demo.html") {
        //     let request = URLRequest(url: url)
        //     webView.load(request)
        //     return webView
        // }
        
        let html = """
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
                     <title>Document</title>
                   </head>

                   <body>
                     <form>
                       <div>
                         <label>
                           <span>Correo Electrónico</span>
                           <input
                             type="text"
                             size="50"
                             data-culqi="card[email]"
                             id="card[email]"
                           />
                         </label>
                       </div>
                       <div>
                         <label>
                           <span>Número de tarjeta</span>
                           <input
                             type="text"
                             size="20"
                             data-culqi="card[number]"
                             id="card[number]"
                           />
                         </label>
                       </div>
                       <div>
                         <label>
                           <span>CVV</span>
                           <input type="text" size="4" data-culqi="card[cvv]" id="card[cvv]" />
                         </label>
                       </div>
                       <div>
                         <label>
                           <span>Fecha expiración (MM/YYYY)</span>
                           <input size="2" data-culqi="card[exp_month]" id="card[exp_month]" />
                           <span>/</span>
                           <input size="4" data-culqi="card[exp_year]" id="card[exp_year]" />
                         </label>
                       </div>
                     </form>
                     <button id="btn_pagar">Pagar</button>
                     <script id="v4" src="https://checkout.culqi.com/js/v4"></script>
                     <!-- <script id="v4" src="https://qa-checkout.culqi.xyz/js/v3"></script> -->
                     <!-- <script id="v4" src="https://qa-checkout.culqi.xyz/js/v4"></script> -->
                     <script>
                       // Culqi.publicKey = "pk_live_6b3914664db6a6be";
                       Culqi.publicKey = "pk_live_4c35581270858bba";
                       Culqi.init();

                       Culqi.settings({
                         currency: "PEN",
                         amount: "190000",
                         // title: 'lorum ipsum dolor sit amet lorem ipsum dolor sit ameta lorem ipsum dolor sit amet',
                         title: "hola",
                         order: "ord_live_eLZrNBwoEbZTzEC8",
                         culqiclient: "prestashop",
                         culqiclientversion: "1.1.0",
                         culqipluginversion: "v4",
                         xculqirsaid: "3f861a72-bd4e-4143-b60c-e09c44116345",
                         rsapublickey:
                           "-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCvLlYlphO6rXtd6mMrB727yybkdx1l6NOQc/4lf07jZ/lou1D4TX+emeNOgDr5zh8Mc+Yn24fquNVqWHkD4CGlqeE+PwA9xpbyZkQ3z08eCCAXIlHEFf3vAmulQ7ER4EU8NLXklmivx4rR1QTpWFEWWbCnmjJqKN+EJ5eo4kd14wIDAQAB-----END PUBLIC KEY-----",
                         excludencryptoperations: [],
                       });
                       //127.0.0.1:5502/test/index-andrea-sotil.html
                       http: Culqi.options({
                         paymentMethods: {
                           tarjeta: true,
                           yape: true,
                           billetera: true,
                           bancaMovil: true,
                           agente: true,
                           cuotealo: true,
                         },
                         style: {
                           bannerColor: "#141414", // hexadecimal
                           buttonBackground: "#D20808", // hexadecimal
                           menuColor: "#D20808", // hexadecimal
                           linksColor: "#D20808", // hexadecimal
                           buttonText: "", // hexadecimal
                           buttonTextColor: "#ffffff", // hexadecimal
                           priceColor: "#D20808",

                           // logo: 'https://static.culqi.com/v4/v4-checkout/brand.svg',
                           logo: "https://media1.tenor.com/m/uCBhZENaMOoAAAAd/hamster-cute.gif",
                         },
                       });

                       const btn_pagar = document.getElementById("btn_pagar");
                       console.log("hola");

                       btn_pagar.addEventListener("click", function (e) {
                         // Crea el objeto Token con el Culqi JS
                         Culqi.open();
                         e.preventDefault();
                       });
                       function culqi() {
                         if (Culqi.token) {
                           // Objeto Token creado exitosamente!
                           let token = Culqi.token.id;
                           alert("Se ha creado un token:" + token);
                         } else {
                           // Hubo algún problema!
                           alert(Culqi.error.user_message);
                         }
                       }
                     </script>
                   </body>
                 </html>
        """
        
        webView.loadHTMLString(html, baseURL: nil)
        return webView
    }

    func updateUIView(_ webView: WKWebView, context: Context) {}
}

#Preview {
    ContentView()
}
