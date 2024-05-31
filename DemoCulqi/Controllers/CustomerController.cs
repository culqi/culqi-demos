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
using System.Diagnostics;


// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace Demo.Controllers
{
   
   ///[Route("api/[controller]")]
    public class CustomerController : ApiController
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

            string address = json.address;
            string address_city = json.address_city;
            string country_code = json.country_code;
            string email = json.email;
            string first_name = json.first_name;
            string last_name = json.last_name;
            string phone_number = json.phone_number;


            Dictionary<string, object> map = new Dictionary<string, object>
    {
        {"address", address},
        {"address_city", address_city},
        {"country_code", country_code},
        {"email", email},
        {"first_name", first_name},
        {"last_name", last_name},
        {"phone_number", phone_number}
    };
            
            HttpResponseMessage json_object = new Customer(security).Create(map);
            return json_object;
        }


      

    }
}

