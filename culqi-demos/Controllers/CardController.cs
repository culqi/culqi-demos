using culqi.net;
using culqi_demos.Configuration;
using culqi_demos.Models;
using Microsoft.AspNetCore.Mvc;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace culqi_demos.Controllers
{
	[Route("api/[controller]")]
	[ApiController]
	public class CardController : ControllerBase
	{
		private readonly Security _security;
		private readonly bool _isEncrypt;
		private readonly ILogger<CardController> _logger;

		public CardController(ILogger<CardController> logger, ConfigurationCulqi configurationCulqi)
		{
			_logger = logger;
			_security = configurationCulqi.GetSecurity();
			_isEncrypt = configurationCulqi.IsEncryptEnabled();
		}

		[HttpPost]
		public ActionResult<ResponseCulqi> Post([FromBody] CardRequest request)
		{
			var cardParams = BuildCardParams(request);
			var cardResponse = CreateCard(cardParams);

			return Ok(cardResponse);
		}

		private Dictionary<string, object> BuildCardParams(CardRequest request)
		{
			var cardParams = new Dictionary<string, object>
			{
				{ "customer_id", request.CustomerId },
				{ "token_id", request.TokenId },
				{ "device_id", request.DeviceId },
			};

			if (request.Authentication3DS != null)
			{
				cardParams["authentication_3DS"] = new Dictionary<string, object>
				{
					{ "eci", request.Authentication3DS.Eci },
					{ "xid", request.Authentication3DS.Xid },
					{ "cavv", request.Authentication3DS.Cavv },
					{ "protocolVersion", request.Authentication3DS.ProtocolVersion },
					{ "directoryServerTransactionId", request.Authentication3DS.DirectoryServerTransactionId }
				};
			}

			return cardParams;
		}

		private ResponseCulqi CreateCard(Dictionary<string, object> cardParams)
		{
			var cardService = new Card(_security);
			return !_isEncrypt
				? cardService.Create(cardParams, _security.rsa_id, _security.rsa_key)
				: cardService.Create(cardParams);
		}
	}
}
