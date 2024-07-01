using System.Text.Json.Serialization;

namespace culqi_demos.Models
{
	public class CardRequest
	{
		[JsonPropertyName("customer_id")]
		public string CustomerId { get; set; }

		[JsonPropertyName("token_id")]
		public string TokenId { get; set; }

		[JsonPropertyName("device_finger_print_id")]
		public string DeviceId { get; set; }

		[JsonPropertyName("authentication_3DS")]
		public Authentication3DS? Authentication3DS { get; set; }
	}
}
