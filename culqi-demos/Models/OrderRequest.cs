using System.Text.Json.Serialization;

namespace culqi_demos.Models
{
    public class OrderRequest
    {
        [JsonPropertyName("amount")]
        public int Amount { get; set; }

        [JsonPropertyName("currency_code")]
        public string CurrencyCode { get; set; }

        [JsonPropertyName("description")]
        public string Description { get; set; }

        [JsonPropertyName("order_number")]
        public string OrderNumber { get; set; }

        [JsonPropertyName("client_details")]
        public ClientDetailOrderRequest ClientDetails { get; set; }

        [JsonPropertyName("expiration_date")]
        public int ExpirationDate { get; set; }
    }
}
