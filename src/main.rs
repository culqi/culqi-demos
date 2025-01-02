use LibCulqi::culqi::{card::Card, charge::Charge, customer::Customer, order::Order};
use structs::{charge::BodyCharge, customer::BodyCustomer, order::BodyOrder};
use tracing::{Level, info};
use tracing_subscriber;
use warp::{Filter, http::header::CONTENT_TYPE};

mod structs;
use structs::card::BodyCard;
mod client;
mod header;
use client::config;
use header::charge;
// use header::header_rsa; // Descomentar si se desea encriptar el servicio a llamar
use warp::{self, reject::Rejection, reply::Reply};

#[tokio::main]
async fn main() {
    tracing_subscriber::fmt()
        .with_max_level(Level::DEBUG)
        .init();
    
    let cors = warp::cors()
        .allow_any_origin()
        .allow_header(CONTENT_TYPE,)
        .allow_methods(vec!["GET", "POST"],);

    info!("Iniciando servidor en http://localhost:3030/index.html ...");

    // Ruta específica para el archivo "index.html"
    let hello = warp::path!("index.html")
        .and(warp::fs::file("./static/index.html"))
        .and_then(handle_file);

    let index_card = warp::path!("index-card.html")
        .and(warp::fs::file("./static/index-card.html"))
        .and_then(index_card);

    // Ruta para servir todo el contenido de la carpeta "static"
    let static_files = warp::path("static").and(warp::fs::dir("./static/"));

    // Ruta POST
    let post_data = warp::post()
        .and(warp::path!("generateOrder"))
        .and(warp::body::json())
        .and_then(generate_order);

    // Ruta POST
    let generate_charge = warp::post()
        .and(warp::path!("generateCharge"))
        .and(warp::body::json())
        .and_then(generate_charge);

    // Ruta POST
    let create_customer = warp::post()
        .and(warp::path!("createCustomer"))
        .and(warp::body::json())
        .and_then(create_customer);

    let create_card = warp::post()
        .and(warp::path!("createCard"))
        .and(warp::body::json())
        .and_then(create_card);

    let routes = hello
        .or(static_files)
        .or(post_data)
        .or(generate_charge)
        .or(create_customer)
        .or(index_card)
        .or(create_card)
        .with(cors,);

    warp::serve(routes).run(([127, 0, 0, 1], 3030)).await;
}

async fn handle_file(file: warp::fs::File) -> Result<impl Reply, Rejection> {
    Ok(warp::reply::with_header(file, CONTENT_TYPE, "text/html"))
}

async fn index_card(file: warp::fs::File) -> Result<impl Reply, Rejection> {
    Ok(warp::reply::with_header(file, CONTENT_TYPE, "text/html"))
}

async fn create_card(input: BodyCard) -> Result<impl Reply, Rejection> {
    println!("Input create card: -->");
    return Card::create(&config::create_client(), &input, None).await;
}

async fn create_customer(input: BodyCustomer) -> Result<impl Reply, Rejection> {
    println!("Input create customer -->");
    return Customer::create(&config::create_client(), &input, None).await;
}
async fn generate_charge(input: BodyCharge) -> Result<impl Reply, Rejection> {
    println!("Input create charge: -->");
    return Charge::create(
        &config::create_client_encrypt(),
        &input,
        Some(charge::get_header_charge_recurrent()),
    )
    .await;
}

async fn generate_order(input: BodyOrder) -> Result<impl Reply, Rejection> {
    return Order::create(
        &config::create_client_encrypt(),
        &input,
        // Some(header_rsa::get_header_encrypt(),),
        None,
    )
    .await;
}
