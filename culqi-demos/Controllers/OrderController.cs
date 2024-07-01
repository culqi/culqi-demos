using culqi.net;
using culqi_demos.Configuration;
using culqi_demos.Models;
using Microsoft.AspNetCore.Mvc;

namespace culqi_demos.Controllers
{
	[Route("api/[controller]")]
	[ApiController]
	public class OrderController : ControllerBase
	{
		private Security _security;
		private readonly bool _isEncrypt;
		private readonly ILogger<OrderController> _logger;

		public OrderController(ILogger<OrderController> logger, ConfigurationCulqi configurationCulqi)
		{
			_logger = logger;
			_security = configurationCulqi.GetSecurity();
			_isEncrypt = configurationCulqi.IsEncryptEnabled();
		}

		[HttpPost]
		public ActionResult<ResponseCulqi> Post([FromBody] OrderRequest request)
		{
			var orderParams = BuildOrderParams(request);
			var orderResponse = CreateOrder(orderParams);

			return Ok(orderResponse);
		}

		private Dictionary<string, object> BuildOrderParams(OrderRequest request)
		{
			DateTimeOffset fechaActual = DateTimeOffset.Now;
			DateTimeOffset fechaMasUnDia = fechaActual.AddDays(1);
			long epoch = fechaMasUnDia.ToUnixTimeSeconds();

			var orderParams = new Dictionary<string, object>
			{
				{"amount",request.Amount},
				{"currency_code", request.CurrencyCode},
				{"description", request.Description},
				{"order_number", request.OrderNumber},
				{"expiration_date", epoch}
			};

			orderParams["client_details"] = new Dictionary<string, object>
			{
				{"first_name", request.ClientDetails.FirstName},
				{"last_name", request.ClientDetails.LastName},
				{"email",  request.ClientDetails.Email},
				{"phone_number", request.ClientDetails.PhoneNumber},
			};

			return orderParams;
		}

		private ResponseCulqi CreateOrder(Dictionary<string, object> orderParams)
		{
			var orderService = new Order(_security);
			return !_isEncrypt
				? orderService.Create(orderParams, _security.rsa_id, _security.rsa_key)
				: orderService.Create(orderParams);
		}
	}
}
