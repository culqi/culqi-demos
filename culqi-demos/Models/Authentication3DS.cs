using System.Text.Json.Serialization;

namespace culqi_demos.Models
{
	public class Authentication3DS
	{
		[JsonPropertyName("eci")]
		public string Eci { get; set; }

		[JsonPropertyName("xid")]
		public string Xid { get; set; }

		[JsonPropertyName("cavv")]
		public string Cavv { get; set; }

		[JsonPropertyName("protocolVersion")]
		public string ProtocolVersion { get; set; }

		[JsonPropertyName("directoryServerTransactionId")]
		public string DirectoryServerTransactionId { get; set; }
	}
}
