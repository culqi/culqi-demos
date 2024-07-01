using culqi.net;
using culqi_demos.Configuration;
using culqi_demos.Models;
using Microsoft.AspNetCore.Mvc;

namespace culqi_demos.Controllers
{
	[Route("api/[controller]")]
	[ApiController]
	public class ChargeController : ControllerBase
	{
		private readonly Security _security;
		private readonly bool _isEncrypt;
		private readonly ILogger<ChargeController> _logger;

		public ChargeController(ILogger<ChargeController> logger, ConfigurationCulqi configurationCulqi)
		{
			_logger = logger;
			_security = configurationCulqi.GetSecurity();
			_isEncrypt = configurationCulqi.IsEncryptEnabled();
		}

		[HttpPost]
		public ActionResult<ResponseCulqi> Post([FromBody] ChargeRequest request)
		{
			var chargeParams = BuildChargeParams(request);
			var chargeResponse = CreateCharge(chargeParams);

			return Ok(chargeResponse);
		}

		private Dictionary<string, object> BuildChargeParams(ChargeRequest request)
		{
			var chargeParams = new Dictionary<string, object>
			{
				{ "amount", request.Amount },
				{ "currency_code", request.CurrencyCode },
				{ "email", request.Email },
				{ "source_id", request.SourceId }
			};

			if (request.Authentication3DS != null)
			{
				chargeParams["authentication_3DS"] = new Dictionary<string, object>
				{
					{ "eci", request.Authentication3DS.Eci },
					{ "xid", request.Authentication3DS.Xid },
					{ "cavv", request.Authentication3DS.Cavv },
					{ "protocolVersion", request.Authentication3DS.ProtocolVersion },
					{ "directoryServerTransactionId", request.Authentication3DS.DirectoryServerTransactionId }
				};
			}

			if (request.AntifraudDetailsChargeRequest != null)
			{
				chargeParams["antifraud_details"] = new Dictionary<string, object>
				{
					{ "first_name", request.AntifraudDetailsChargeRequest.FirstName },
					{ "last_name", request.AntifraudDetailsChargeRequest.LastName },
					{ "device_id", request.AntifraudDetailsChargeRequest.DeviceId },
					{ "phone_number", request.AntifraudDetailsChargeRequest.PhoneNumber }
				};
			}

			return chargeParams;
		}

		private ResponseCulqi CreateCharge(Dictionary<string, object> chargeParams)
		{
			var chargeService = new Charge(_security);
			return !_isEncrypt
				? chargeService.Create(chargeParams, _security.rsa_id, _security.rsa_key)
				: chargeService.Create(chargeParams);
		}
	}
}

