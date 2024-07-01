using culqi_demos.Configuration;

var builder = WebApplication.CreateBuilder(args);

// Configurar la sección CulqiSettings desde appsettings.json
builder.Configuration.GetSection("CulqiSettings").Bind(new CulqiSettings());

// Registrar ConfigurationCulqi como servicio singleton
builder.Services.Configure<CulqiSettings>(builder.Configuration.GetSection("CulqiSettings"));
builder.Services.AddSingleton<ConfigurationCulqi>();

builder.Services.AddControllers();

builder.Services.AddLogging();

// Add services to the container.
builder.Services.AddRazorPages();

var app = builder.Build();

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Error");
    // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
    app.UseHsts();
}

app.UseHttpsRedirection();

app.UseStaticFiles();

app.UseRouting();

app.UseAuthorization();

app.UseEndpoints(endpoints =>
{
    endpoints.MapControllers();
});

app.MapRazorPages();

app.Run();
