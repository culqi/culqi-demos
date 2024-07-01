using System.Net;
using culqi_demos.Configuration;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace culqi_demos.Pages
{
    public class IndexModel : PageModel
    {
        private readonly ILogger<IndexModel> _logger;
		private readonly CulqiSettings _culqiCretendials;

		public IndexModel(ILogger<IndexModel> logger, ConfigurationCulqi configurationCulqi)
		{
			_logger = logger;
			_culqiCretendials = configurationCulqi.GetCredentials();
		}

		public void OnGet()
        {
			var credentials = _culqiCretendials;
			ViewData["CulqiCredentials"] = credentials;
		}
    }
}
