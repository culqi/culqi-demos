using culqi.net;
using culqi_demos.Configuration;
using culqi_demos.Models;
using Microsoft.AspNetCore.Mvc;

namespace culqi_demos.Controllers
{
	[Route("api/[controller]")]
	[ApiController]
	public class CustomerController : ControllerBase
	{
		private readonly Security _security;
		private readonly ILogger<CustomerController> _logger;

		public CustomerController(ILogger<CustomerController> logger, ConfigurationCulqi configurationCulqi)
		{
			_logger = logger;
			_security = configurationCulqi.GetSecurity();
		}

		[HttpPost]
		public ActionResult<ResponseCulqi> Post([FromBody] CustomerRequest request)
		{
			var customerParams = BuildCustomerParams(request);
			var customerResponse = CreateCustomer(customerParams);
			return Ok(customerResponse);
		}

		private Dictionary<string, object> BuildCustomerParams(CustomerRequest request)
		{
			var customerParams = new Dictionary<string, object>
			{
				{ "address", request.Address },
				{ "address_city", request.AddressCity },
				{ "country_code", request.CountryCode },
				{ "email", request.Email },
				{ "first_name", request.FirstName },
				{ "last_name", request.LastName },
				{ "phone_number", request.PhoneNumber }
			};

			return customerParams;
		}

		private ResponseCulqi CreateCustomer(Dictionary<string, object> customerParams)
		{
			return new Customer(_security).Create(customerParams);

		}
	}
}
