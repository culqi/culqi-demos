using System.Net;
using culqi.net;
using Microsoft.Extensions.Options;

namespace culqi_demos.Configuration
{

	public class ConfigurationCulqi
	{
		private readonly CulqiSettings _culqiSettings;

		public ConfigurationCulqi(IOptions<CulqiSettings> culqiSettings)
		{
			_culqiSettings = culqiSettings.Value;
		}
		public Security GetSecurity()
		{
			return new Security
			{
				public_key = _culqiSettings.PublicKey,
				secret_key = _culqiSettings.SecretKey,
				rsa_id = _culqiSettings.RsaId,
				rsa_key = _culqiSettings.RsaKey
			};

		}
		public bool IsEncryptEnabled()
		{
			return _culqiSettings.Encrypt;
		}

		public CulqiSettings GetCredentials()
		{
			return new CulqiSettings
			{
				PublicKey = _culqiSettings.PublicKey,
				SecretKey = _culqiSettings.SecretKey,
				RsaId = _culqiSettings.RsaId,
				RsaKey = _culqiSettings.RsaKey,
				Encrypt = _culqiSettings.Encrypt
			};
		}
	}

}