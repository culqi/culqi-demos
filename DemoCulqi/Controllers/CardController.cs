using culqi.net;
using Newtonsoft.Json.Linq;
using RestSharp;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Text.Json;
using System.Web.Http;
// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace Demo.Controllers
{
    
    //[Route("api/[controller]")]
    public class CardController : ApiController
    {
        Security security = null;
        string encrypt = "0";
        // GET: api/values
        [HttpGet]
        public IEnumerable<string> Get()
        {
            return new string[] { "value1", "value2" };
        }


        // POST api/values
        [HttpPost]
        public HttpResponseMessage Post([FromBody] dynamic json)
        {
            security = new Security();
            security.public_key = "pk_test_e94078b9b248675d";
            security.secret_key = "sk_test_c2267b5b262745f0";
            security.rsa_id = "de35e120-e297-4b96-97ef-10a43423ddec";
            security.rsa_key = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDswQycch0x/7GZ0oFojkWCYv+gr5CyfBKXc3Izq+btIEMCrkDrIsz4Lnl5E3FSD7/htFn1oE84SaDKl5DgbNoev3pMC7MDDgdCFrHODOp7aXwjG8NaiCbiymyBglXyEN28hLvgHpvZmAn6KFo0lMGuKnz8HiuTfpBl6HpD6+02SQIDAQAB";



            string customer_id = json.customer_id;
            string token_id = json.token_id;

            string propertyName = "authentication_3DS";
            JObject jsonObject = JObject.Parse(Convert.ToString(json));
            bool propertyExists = jsonObject.ContainsKey(propertyName);

            if (!propertyExists)
            {
                Dictionary<string, object> map = new Dictionary<string, object>
        {
            {"customer_id", customer_id},
            {"token_id", token_id}
        };

                HttpResponseMessage json_object = new Card(security).Create(map);
                return json_object;
            }
            else
            {
                string eci = json.authentication_3DS?.eci ?? "";
                string xid = json.authentication_3DS?.xid ?? "";
                string cavv = json.authentication_3DS?.cavv ?? "";
                string protocolVersion = json.authentication_3DS?.protocolVersion ?? "";
                string directoryServerTransactionId = json.authentication_3DS?.directoryServerTransactionId ?? "";

                Dictionary<string, object> authentication_3DS = new Dictionary<string, object>
        {
            {"eci", eci},
            {"xid", xid},
            {"cavv", cavv},
            {"protocolVersion", protocolVersion},
            {"directoryServerTransactionId", directoryServerTransactionId}
        };

                Dictionary<string, object> map = new Dictionary<string, object>
        {
            {"customer_id", customer_id},
            {"token_id", token_id},
            {"authentication_3DS", authentication_3DS},
        };

                if (encrypt == "1")
                {
                    HttpResponseMessage json_object = new Card(security).Create(map, security.rsa_id, security.rsa_key);
                    return json_object;
                }
                else
                {
                    HttpResponseMessage json_object = new Card(security).Create(map);
                    return json_object;
                }
            }
        }



    }
}

