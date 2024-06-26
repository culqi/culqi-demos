package culqi.com.culqiDemos;

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
    //WebView browser;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }

    public void loadPage(View view) {
        WebView browser = new WebView(this);
        browser.getSettings().setJavaScriptEnabled(true);
        browser.setWebChromeClient(new WebChromeClient() {
        });
        browser.loadUrl("file:///android_asset/custom-checkout.html");
        setContentView(browser);
        WebSettings ws = browser.getSettings();
        ws.setAllowFileAccessFromFileURLs(true);
        ws.setAllowUniversalAccessFromFileURLs(true);
        ws.setJavaScriptEnabled(true);
        ws.setDomStorageEnabled(true);
        browser.addJavascriptInterface(new JavaScriptInterface(this, browser), "Android");

        browser.addJavascriptInterface(new MainActivity.JavaScriptInterface2(), "AndroidInterface");
        browser.addJavascriptInterface(new MainActivity.JavaScriptInterface3((Context) this), "AndroidInterfaceMessage");
        browser.addJavascriptInterface(new MainActivity.JavaScriptInterface4((Context) this), "AndroidInterfaceMessageError");
        browser.evaluateJavascript("Culqi.close();", (ValueCallback) (new ValueCallback() {
            // $FF: synthetic method
            // $FF: bridge method
            public void onReceiveValue(Object var1) {
                this.onReceiveValue((String) var1);
            }

            public final void onReceiveValue(String value) {
                if (value != null && Intrinsics.areEqual(value, "\"Culqi close ejecutado\"")) {
                    MainActivity.this.runOnUiThread((Runnable) (new Runnable() {
                        public final void run() {
                            browser.loadUrl("javascript:AndroidInterface.onCulqiClose()");
                        }
                    }));
                }

            }
        }));
        browser.evaluateJavascript("console.log(\"Llamado Exitoso\");", (ValueCallback) (new ValueCallback() {
            // $FF: synthetic method
            // $FF: bridge method
            public void onReceiveValue(Object var1) {
                this.onReceiveValue((String) var1);
            }

            public final void onReceiveValue(String value) {
                if (value != null && Intrinsics.areEqual(value, "\"Culqi close ejecutado\"")) {
                    MainActivity.this.runOnUiThread((Runnable) (new Runnable() {
                        public final void run() {
                            browser.loadUrl("javascript:AndroidInterfaceMessage.onCulqiMenssage()");
                        }
                    }));
                }

            }
        }));
        browser.evaluateJavascript("console.log(\"Llamado con error\");", (ValueCallback) (new ValueCallback() {
            // $FF: synthetic method
            // $FF: bridge method
            public void onReceiveValue(Object var1) {
                this.onReceiveValue((String) var1);
            }

            public final void onReceiveValue(String value) {
                if (value != null && Intrinsics.areEqual(value, "\"Culqi close ejecutado\"")) {
                    MainActivity.this.runOnUiThread((Runnable) (new Runnable() {
                        public final void run() {
                            browser.loadUrl("javascript:AndroidInterfaceMessageError.onCulqiMenssageError()");
                        }
                    }));
                }

            }
        }));
    }

    public final class JavaScriptInterface2 {
        @JavascriptInterface
        public final void onCulqiClose() {
            MainActivity.this.runOnUiThread((Runnable) (new Runnable() {
                public final void run() {
                    Intent intent = MainActivity.this.getIntent();
                    MainActivity.this.finish();
                    MainActivity.this.overridePendingTransition(17432576, 17432577);
                    MainActivity.this.startActivity(intent);
                    MainActivity.this.overridePendingTransition(17432576, 17432577);
                }
            }));
        }
    }

    public final class JavaScriptInterface3 {
        @NotNull
        private Context mContext;

        @JavascriptInterface
        public final void onCulqiMenssage() {
            MainActivity.this.runOnUiThread((Runnable) (new Runnable() {
                public final void run() {
                    // Toast.makeText(JavaScriptInterface3.this.getMContext(), (CharSequence)"Cargo Realizado Correctamente", 0).show();
                    Intent intent = MainActivity.this.getIntent();
                    MainActivity.this.finish();
                    MainActivity.this.overridePendingTransition(17432576, 17432577);
                    MainActivity.this.startActivity(intent);
                    MainActivity.this.overridePendingTransition(17432576, 17432577);
                }
            }));
        }

        @NotNull
        public final Context getMContext() {
            return this.mContext;
        }

        public final void setMContext(@NotNull Context var1) {
            Intrinsics.checkNotNullParameter(var1, "<set-?>");
            this.mContext = var1;
        }

        public JavaScriptInterface3(@NotNull Context mContext) {
            Intrinsics.checkNotNullParameter(mContext, "mContext");
            //super();
            this.mContext = mContext;
        }
    }

    public final class JavaScriptInterface4 {
        @NotNull
        private Context mContext;

        @JavascriptInterface
        public final void onCulqiMenssageError() {
            MainActivity.this.runOnUiThread((Runnable) (new Runnable() {
                public final void run() {
                    //Toast.makeText(JavaScriptInterface4.this.getMContext(), (CharSequence)"Error al Realizar Cargo", 0).show();
                    Intent intent = MainActivity.this.getIntent();
                    MainActivity.this.finish();
                    MainActivity.this.overridePendingTransition(17432576, 17432577);
                    MainActivity.this.startActivity(intent);
                    MainActivity.this.overridePendingTransition(17432576, 17432577);
                }
            }));
        }

        @NotNull
        public final Context getMContext() {
            return this.mContext;
        }

        public final void setMContext(@NotNull Context var1) {
            Intrinsics.checkNotNullParameter(var1, "<set-?>");
            this.mContext = var1;
        }

        public JavaScriptInterface4(@NotNull Context mContext) {
            Intrinsics.checkNotNullParameter(mContext, "mContext");
            //super();
            this.mContext = mContext;
        }
    }

    public class JavaScriptInterface {
        Context mContext;
        WebView mWebView;

        JavaScriptInterface(Context c, WebView browser) {
            mContext = c;
            mWebView = browser;
        }

        @JavascriptInterface
        public String sendParamsCheckoutv4FromAndroid() throws JSONException {
            SendDataToCheckout sdc = new SendDataToCheckout();
            sdc.setTitle("Tienda Android");
            sdc.setAmount("10000");//100.00
            sdc.setOrderId("ord_test_bYPt8MUjbla9SVm6");
            sdc.setPhone_number("956944598");
            sdc.setCurrency_code("PEN");
            sdc.setFirst_name("Fernando");
            sdc.setLast_name("Peres Diaz");
/*
            String response = getOrder();
            JSONObject jsonResponse = new JSONObject(response);
            String orderId = jsonResponse.get("id").toString();
            //String orderId = jsonResponse.getString("id");
            Log.d("orderId", orderId);
*/
            Gson gson = new Gson();
            String json = gson.toJson(sdc);
            return json;
        }

        public String getOrder() throws JSONException {

            Long tsLong = System.currentTimeMillis() / 1000;
            String ts = tsLong.toString();

            long epoch = System.currentTimeMillis() / 1000 + 86400;

            JSONObject clientDetails = new JSONObject();
            clientDetails.put("first_name", "Luis");
            clientDetails.put("last_name", "Quispe");
            clientDetails.put("email", "prueba01@gmail.com");
            clientDetails.put("phone_number", "940221463");

            JSONObject jsonOrder = new JSONObject();
            jsonOrder.put("amount", 10000);
            jsonOrder.put("currency_code", "PEN");
            jsonOrder.put("description", "Venta de prueba");
            jsonOrder.put("order_number", "pedido-" + ts.toString());
            jsonOrder.put("client_details", clientDetails);
            jsonOrder.put("expiration_date", epoch);
            jsonOrder.put("confirm", false);

            try {

                String jsonParam = jsonOrder.toString(2);

                URL url = new URL("https://api.culqi.com/v2/orders");
                HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                conn.setRequestMethod("POST");
                conn.setRequestProperty("Content-Type", "application/json;charset=UTF-8");
                conn.setRequestProperty("Accept", "application/json");
                conn.setRequestProperty("Authorization", "Bearer sk_test_1573b0e8079863ff");
                conn.setDoOutput(true);
                conn.setDoInput(true);

                Log.i("JSON", jsonParam.toString());
                DataOutputStream os = new DataOutputStream(conn.getOutputStream());
                //os.writeBytes(URLEncoder.encode(jsonParam.toString(), "UTF-8"));
                os.writeBytes(jsonParam.toString());

                os.flush();
                os.close();
                InputStream is = null;

                if (conn.getResponseCode() == HttpURLConnection.HTTP_OK) {
                    is = conn.getInputStream();// is is inputstream
                } else {
                    is = conn.getErrorStream();
                }

                try {
                    BufferedReader reader = new BufferedReader(new InputStreamReader(
                            is, "UTF-8"), 8);
                    StringBuilder sb = new StringBuilder();
                    String line = null;
                    while ((line = reader.readLine()) != null) {
                        sb.append(line + "\n");
                    }
                    is.close();
                    String response = sb.toString();
                    //HERE YOU HAVE THE VALUE FROM THE SERVER
                    Log.d("Your Data", response);
                    return response;

                } catch (Exception e) {
                    Log.e("Buffer Error", "Error converting result " + e.toString());
                }


                conn.disconnect();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return null;
        }
    }
}