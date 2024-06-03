package culqi.com.democheckoutv4

import android.annotation.SuppressLint
import android.app.Activity
import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.view.View
import android.webkit.JavascriptInterface
import android.webkit.ValueCallback
import android.webkit.WebChromeClient
import android.webkit.WebView
import android.webkit.WebViewClient
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.google.gson.Gson
import com.google.gson.annotations.SerializedName
import org.json.JSONException
import org.json.JSONObject
import java.io.BufferedReader
import java.io.DataOutputStream
import java.io.IOException
import java.io.InputStreamReader
import java.net.HttpURLConnection
import java.net.URL


class MainActivity : AppCompatActivity() {

    private lateinit var browser: WebView

    //private val APP_URL = "http://0.0.0.0:8000/custom-checkout.html"
    private val APP_URL = "file:///android_asset/custom-checkout.html"

    private val PUBLIC_KEY = "pk_test_90667d0a57d45c48"
    private val SECRET_KEY = "sk_test_1573b0e8079863ff"
    private val CULQI_API = "https://api.culqi.com/v2"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        setupWebView()
        /*
        WebView webView=findViewById(R.id.webView);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.loadUrl("file:///android_asset/checkoutv4.html");
        */
    }

    fun loadPage(view: View?) {
        browser.loadUrl(APP_URL);
        setContentView(browser);

        evaluateJavascript("Culqi.close();", "javascript:Android.onCulqiClose()");
        evaluateJavascript("console.log(\"Llamado Exitoso\");", "javascript:Android.onCulqiMessage()");
        evaluateJavascript("console.log(\"Llamado con error\");", "javascript:Android.onCulqiMessageError()");
    }

    private fun evaluateJavascript(script: String?, callback: String?) {
        browser.evaluateJavascript(script!!, ValueCallback { value: String? ->
            if (value != null && value == "\"Culqi close ejecutado\"") {
                browser.loadUrl(callback!!)
            }
        })
    }
    @SuppressLint("SetJavaScriptEnabled")
    private fun setupWebView() {
        browser = WebView(this)
        browser.settings.javaScriptEnabled = true
        browser.settings.domStorageEnabled = true
        browser.settings.allowContentAccess = true
        browser.settings.allowFileAccessFromFileURLs = true

        browser.setWebChromeClient(WebChromeClient());
        browser.setWebViewClient(WebViewClient())
        // val ci = CulqiInterface(this, browser)
        browser.addJavascriptInterface(CulqiInterface(this, browser), "Android")
        //browser.addJavascriptInterface(JavaScriptInterface(this, browser), "Android")
        //browser.addJavascriptInterface(JavaScriptInterface2(), "AndroidInterface")
        //browser.addJavascriptInterface(JavaScriptInterface3(this), "AndroidInterfaceMessage")
        //browser.addJavascriptInterface(JavaScriptInterface4(this), "AndroidInterfaceMessageError")
    }

    data class GetDataOrder(
        @SerializedName("amount") val amount: Double,
        @SerializedName("id") val id: String,
    )

    inner class CulqiInterface {
        private var mContext: Context
        private var mWebView: WebView
        constructor(context: Context, webView: WebView) {
            this.mContext = context
            this.mWebView = webView
        }
        @JavascriptInterface
        fun onCulqiClose() {
            runOnUiThread(this::restartActivity);
        }
        @JavascriptInterface
        fun onCulqiMessage() {
            // runOnUiThread(this::restartActivity);
            runOnUiThread {
                Toast.makeText(mContext, "Cargo Realizado Correctamente", Toast.LENGTH_SHORT).show()
                val intent = intent
                finish()
                this.restartActivity()
                // overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out)
                // startActivity(intent)
                // overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out)
            }
        }
        @JavascriptInterface
        fun onCulqiMessageError() {
            //runOnUiThread(this::restartActivity);
            runOnUiThread {
                Toast.makeText(mContext, "Error al Realizar Cargo", Toast.LENGTH_SHORT).show()
                this.restartActivity()
                // val intent = intent
                // finish()
                // overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out)
                // startActivity(intent)
                // overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out)
            }
        }
        private fun restartActivity() {
            val intent = Intent(mContext, MainActivity::class.java)
            mContext.startActivity(intent)
            (mContext as Activity).overridePendingTransition(17432576, 17432577)
        }
        @JavascriptInterface
        fun sendParamsCustomCheckoutFromAndroid() : String{
            val sdc = SendDataToCheckout();
            val ord = getOrder();
            val gson = Gson();

            val jsonOrd = gson.fromJson(ord, GetDataOrder::class.java);

            sdc.title = "Tienda Android";
            sdc.setPublickey(PUBLIC_KEY);
            sdc.setSecretkey(SECRET_KEY);
            sdc.setAppurl(APP_URL);
            sdc.culqiApi = CULQI_API;
            sdc.amount = jsonOrd.amount.toString();
            sdc.orderId = jsonOrd.id;
            sdc.setPhone_number("999999999");
            sdc.setCurrency_code("PEN");
            sdc.setFirst_name("Dennis");
            sdc.setLast_name("Demo");

            val json = gson.toJson(sdc);
            return json;
        }
        private fun getOrder(): String? {
            val tsLong = System.currentTimeMillis() / 1000
            val ts = tsLong.toString()

            val epoch = System.currentTimeMillis() / 1000 + 86400

            val clientDetails = JSONObject()
            try {
                clientDetails.put("first_name", "Dennis")
                clientDetails.put("last_name", "Demo")
                clientDetails.put("email", "demo01@demo.com")
                clientDetails.put("phone_number", "999999999")

                val jsonOrder = JSONObject()
                jsonOrder.put("amount", 10000)
                jsonOrder.put("currency_code", "PEN")
                jsonOrder.put("description", "Venta de prueba")
                jsonOrder.put("order_number", "order-$ts")
                jsonOrder.put("client_details", clientDetails)
                jsonOrder.put("expiration_date", epoch)
                jsonOrder.put("confirm", false)

                val jsonParam = jsonOrder.toString(2)

                val url = URL("$CULQI_API/orders")
                val conn = url.openConnection() as HttpURLConnection
                conn.requestMethod = "POST"
                conn.setRequestProperty("Content-Type", "application/json;charset=UTF-8")
                conn.setRequestProperty("Accept", "application/json")
                conn.setRequestProperty("Authorization", "Bearer $SECRET_KEY")
                conn.doOutput = true
                conn.doInput = true

                val os = DataOutputStream(conn.outputStream)
                os.writeBytes(jsonParam)

                os.flush()
                os.close()

                val `is` =
                    if (conn.responseCode == HttpURLConnection.HTTP_CREATED) conn.inputStream else conn.errorStream

                val reader = BufferedReader(InputStreamReader(`is`, "UTF-8"))
                val sb = java.lang.StringBuilder()
                var line: String?
                while ((reader.readLine().also { line = it }) != null) {
                    sb.append(line).append("\n")
                }
                `is`.close()
                val response = sb.toString()
                conn.disconnect()
                return response
            } catch (e: JSONException) {
                e.printStackTrace()
                return null
            } catch (e: IOException) {
                e.printStackTrace()
                return null
            }
        }
    }
}