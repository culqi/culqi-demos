using System.Text.Json.Serialization;

namespace culqi_demos.Models
{
  public class ClientDetailOrderRequest
    {
      [JsonPropertyName("first_name")]
      public string FirstName { get; set; }

      [JsonPropertyName("last_name")]
      public string LastName { get; set; }

      [JsonPropertyName("email")]
      public string Email { get; set; }

      [JsonPropertyName("phone_number")]
      public string PhoneNumber { get; set; }
    }
}
