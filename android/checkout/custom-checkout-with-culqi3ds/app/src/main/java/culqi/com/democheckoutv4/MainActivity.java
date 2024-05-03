package culqi.com.democheckoutv4;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.JavascriptInterface;
import android.webkit.ValueCallback;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;

import com.google.gson.Gson;

import org.jetbrains.annotations.NotNull;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;

import kotlin.jvm.internal.Intrinsics;

public class MainActivity extends AppCompatActivity {

    private WebView browser;

    private static final String APP_URL = "file:///android_asset/custom_checkout.html";
    private static final String PUBLIC_KEY = "pk_test_xxxxxxxx";
    private static final String SECRET_KEY = "sk_test_xxxxxxxx";
    private static final String CULQI_API = "https://api.culqi.com/v2";

    //WebView browser;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        setupWebView();
        /*
        WebView webView=findViewById(R.id.webView);
        webView.getSettings().setJavaScriptEnabled(true);
        webView.loadUrl(APP_URL);
        */
    }

    private void setupWebView() {
        browser = new WebView(this);
        WebSettings webSettings = browser.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setDomStorageEnabled(true);

        browser.setWebChromeClient(new WebChromeClient());
        browser.setWebViewClient(new WebViewClient() {
            public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
                Toast.makeText(MainActivity.this, "Error al cargar la página: " + error.getDescription(), Toast.LENGTH_LONG).show();
            }
        });

        browser.addJavascriptInterface(new CulqiInterface(this, browser), "Android");
        browser.addJavascriptInterface(new JavaScriptInterface(this, browser), "Android");

        browser.addJavascriptInterface(new JavaScriptInterface2(), "AndroidInterface");
        browser.addJavascriptInterface(new JavaScriptInterface3(this), "AndroidInterfaceMessage");
        browser.addJavascriptInterface(new JavaScriptInterface4(this), "AndroidInterfaceMessageError");
    }

    private void loadPage() {
        browser.loadUrl(APP_URL);
        setContentView(browser);

        evaluateJavascript("Culqi.close();", "javascript:Android.onCulqiClose()");
        evaluateJavascript("console.log(\"Llamado Exitoso\");", "javascript:Android.onCulqiMessage()");
        evaluateJavascript("console.log(\"Llamado con error\");", "javascript:Android.onCulqiMessageError()");
    }

    private void evaluateJavascript(String script, String callback) {
        browser.evaluateJavascript(script, (ValueCallback<String>) value -> {
            if (value != null && value.equals("\"Culqi close ejecutado\"")) {
                browser.loadUrl(callback);
            }
        });
    }

    public final class CulqiInterface {
        private Context mContext;
        private WebView mWebView;

        public CulqiInterface(Context context, WebView webView) {
            this.mContext = context;
            this.mWebView = webView;
        }

        @JavascriptInterface
        public final void onCulqiClose() {
            runOnUiThread(this::restartActivity);
        }

        @JavascriptInterface
        public final void onCulqiMessage() {
            runOnUiThread(this::restartActivity);
        }

        @JavascriptInterface
        public final void onCulqiMessageError() {
            runOnUiThread(this::restartActivity);
        }

        private void restartActivity() {
            Intent intent = new Intent(mContext, MainActivity.class);
            mContext.startActivity(intent);
            ((Activity) mContext).overridePendingTransition(17432576, 17432577);
        }

        @JavascriptInterface
        public String sendParamsCustomCheckoutFromAndroid() throws JSONException {
            SendDataToCheckout sdc = new SendDataToCheckout();
            sdc.setTitle("Tienda Android");
            sdc.setPublickey(PUBLIC_KEY);
            sdc.setSecretkey(SECRET_KEY);
            sdc.setAppurl(APP_URL);
            sdc.setCulqiApi(CULQI_API);
            sdc.setAmount("10000"); //100.00
            sdc.setOrderId("ord_test_xxxxxxxxx");
            sdc.setPhone_number("999999999");
            sdc.setCurrency_code("PEN");
            sdc.setFirst_name("Dennis");
            sdc.setLast_name("Demo");
            Gson gson = new Gson();
            String json = gson.toJson(sdc);
            return json;
        }

       @JavascriptInterface
        public String getOrder() throws JSONException {
            Long tsLong = System.currentTimeMillis()/1000;
            String ts = tsLong.toString();

            long epoch = System.currentTimeMillis()/1000 +86400;

            JSONObject clientDetails = new JSONObject();
            try {
                clientDetails.put("first_name", "Dennis");
                clientDetails.put("last_name", "Demo");
                clientDetails.put("email", "demo01@demo.com");
                clientDetails.put("phone_number", "999999999");

                JSONObject jsonOrder = new JSONObject();
                jsonOrder.put("amount", 10000);
                jsonOrder.put("currency_code", "PEN");
                jsonOrder.put("description", "Venta de prueba");
                jsonOrder.put("order_number", "order-"+ts);
                jsonOrder.put("client_details", clientDetails);
                jsonOrder.put("expiration_date", epoch);
                jsonOrder.put("confirm", false);

                String jsonParam = jsonOrder.toString(2);

                URL url = new URL(CULQI_API + "/orders");
                HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                conn.setRequestMethod("POST");
                conn.setRequestProperty("Content-Type", "application/json;charset=UTF-8");
                conn.setRequestProperty("Accept", "application/json");
                conn.setRequestProperty("Authorization", "Bearer " + SECRET_KEY);
                conn.setDoOutput(true);
                conn.setDoInput(true);

                DataOutputStream os = new DataOutputStream(conn.getOutputStream());
                os.writeBytes(jsonParam);

                os.flush();
                os.close();

                InputStream is = conn.getResponseCode() == HttpURLConnection.HTTP_OK ? conn.getInputStream() : conn.getErrorStream();

                BufferedReader reader = new BufferedReader(new InputStreamReader(is, "UTF-8"));
                StringBuilder sb = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    sb.append(line).append("\n");
                }
                is.close();
                String response = sb.toString();
                conn.disconnect();
                return response;
            } catch (JSONException | IOException e) {
                e.printStackTrace();
                return null;
            }
        }
    }
}