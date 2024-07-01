using System.Text.Json.Serialization;

namespace culqi_demos.Models
{
	public class CustomerRequest
	{
		[JsonPropertyName("first_name")]
		public string FirstName { get; set; }

		[JsonPropertyName("last_name")]
		public string LastName { get; set; }

		[JsonPropertyName("email")]
		public string Email { get; set; }

		[JsonPropertyName("address")]
		public string Address { get; set; }

		[JsonPropertyName("address_city")]
		public string AddressCity { get; set; }

		[JsonPropertyName("country_code")]
		public string CountryCode { get; set; }

		[JsonPropertyName("phone_number")]
		public string PhoneNumber { get; set; }
	}
}
