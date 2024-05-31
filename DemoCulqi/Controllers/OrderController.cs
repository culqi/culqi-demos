using culqi.net;
using DemoCulqi.Controllers;
using RestSharp;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Net.Http.Formatting;
using System.Text;
using System.Text.Json;
using System.Web.Http;
using System.Web.Http.Results;
using Demo.Controllers;


// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace Demo.Controllers
{
   //[Route("api/[controller]")]
    public class OrderController : ApiController
    {
        Security security = null;
        GenericController gc = new GenericController();
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
            string description = json.description;
            string order_number = json.order_number;


            DateTimeOffset fechaActual = DateTimeOffset.Now;   
            DateTimeOffset fechaMasUnDia = fechaActual.AddDays(1);           
            long epoch = fechaMasUnDia.ToUnixTimeSeconds();

            Dictionary<string, object> client_details = new Dictionary<string, object>
                {
                    {"first_name","Jordan"},
                    {"last_name", "Diaz Diaz"},                    
                    {"email", "jordandiaz2016@gmail.com"},
                    {"phone_number", "921484773"}
                }; 
          
            Dictionary<string, object> map = new Dictionary<string, object>
                {
                    {"amount",amount},
                    {"currency_code", currency_code},                    
                    {"description", description},
                    {"order_number", order_number},
                    {"client_details", client_details},
                    {"expiration_date", epoch}
                };

            HttpResponseMessage json_object = new Order(security).Create(map);
            return json_object;

        }
      

    }
}

