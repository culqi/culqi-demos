using System.Text.Json.Serialization;

namespace culqi_demos.Models
{
    public class ChargeRequest
    {
		[JsonPropertyName("amount")]
		public int Amount { get; set; }

		[JsonPropertyName("currency_code")]
		public string CurrencyCode { get; set; }

		[JsonPropertyName("email")]
		public string Email { get; set; }

		[JsonPropertyName("source_id")]
		public string SourceId { get; set; }

		[JsonPropertyName("authentication_3DS")]
		public Authentication3DS? Authentication3DS { get; set; }

		[JsonPropertyName("antifraud_details")]
		public AntifraudDetailsChargeRequest? AntifraudDetailsChargeRequest { get; set; }
    }
}
