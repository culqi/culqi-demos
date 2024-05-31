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
            security.public_key = "pk_test_e94078b9b248675d";
            security.secret_key = "sk_test_c2267b5b262745f0";
            security.rsa_id = "de35e120-e297-4b96-97ef-10a43423ddec";
            security.rsa_key = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDswQycch0x/7GZ0oFojkWCYv+gr5CyfBKXc3Izq+btIEMCrkDrIsz4Lnl5E3FSD7/htFn1oE84SaDKl5DgbNoev3pMC7MDDgdCFrHODOp7aXwjG8NaiCbiymyBglXyEN28hLvgHpvZmAn6KFo0lMGuKnz8HiuTfpBl6HpD6+02SQIDAQAB";

            return security;
        }

    }
}
