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
using Demo.Controllers;


// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace Demo.Controllers
{
    
    //[Route("api/[controller]")]
    public class ChargeController : ApiController
    {
        Security security = null;
        GenericController gc = new GenericController();
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
            security = gc.securityKeys();

            Int32 amount = json.amount;
            string currency_code = json.currency_code;
            string email = json.email;
            string source_id = json.source_id;
            string propertyName = "authentication_3DS"; // Nombre de la propiedad a validar

            JObject jsonObject = JObject.Parse(Convert.ToString(json));
            bool propertyExists = jsonObject.ContainsKey(propertyName);

            if (!propertyExists)
            {
                Dictionary<string, object> map = new Dictionary<string, object>
        {
            {"amount", amount},
            {"currency_code", currency_code},
            {"email", email},
            {"source_id", source_id}
        };

                if (encrypt == "1")
                {
                    HttpResponseMessage json_object = new Charge(security).Create(map, security.rsa_id, security.rsa_key);
                    return json_object;
                }
                else
                {
                    HttpResponseMessage json_object = new Charge(security).Create(map);
                    return json_object;
                }
            }
            else
            {
                string eci = json.authentication_3DS.eci ?? "";
                string xid = json.authentication_3DS.xid ?? "";
                string cavv = json.authentication_3DS.cavv ?? "";
                string protocolVersion = json.authentication_3DS.protocolVersion ?? "";
                string directoryServerTransactionId = json.authentication_3DS.directoryServerTransactionId ?? "";

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
            {"amount", amount},
            {"currency_code", currency_code},
            {"email", email},
            {"source_id", source_id},
            {"authentication_3DS", authentication_3DS},
        };

                if (encrypt == "1")
                {
                    HttpResponseMessage json_object = new Charge(security).Create(map, security.rsa_id, security.rsa_key);
                    return json_object;
                }
                else
                {
                    HttpResponseMessage json_object = new Charge(security).Create(map);
                    return json_object;
                }
            }

        }
        

    }
}

