using System;
using System.Collections.Generic;
using System.Linq;
using System.Text.Json;
using System.Threading.Tasks;
using System.Web.Http;
using culqi.net;
using Newtonsoft.Json.Linq;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace Demo.Controllers
{

    public class GenericController : ApiController
    {
        Security security = null;

        public Security securityKeys()
        {

            security = new Security();
            security.public_key = "INSERTE_SU_LLAVE_PUBLICA";
            security.secret_key = "INSERTE_SU_LLAVE_PRIVADA";
            security.rsa_id = "INSERTE_SU_RSA_ID";
            security.rsa_key = "INSERTE_SU_LLAVE_RSA";

            return security;
        }

    }
}
