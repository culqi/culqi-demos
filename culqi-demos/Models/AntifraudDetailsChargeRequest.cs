using System.Text.Json.Serialization;

namespace culqi_demos.Models
{
	public class AntifraudDetailsChargeRequest
	{
		[JsonPropertyName("first_name")]
		public string FirstName { get; set; }

		[JsonPropertyName("last_name")]
		public string LastName { get; set; }

		[JsonPropertyName("phone_number")]
		public string PhoneNumber { get; set; }

		[JsonPropertyName("device_finger_print_id")]
		public string DeviceId { get; set; }
	}
}