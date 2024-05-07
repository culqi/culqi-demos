use warp::{Filter};
use warp::http::header::CONTENT_TYPE;
use serde::{Deserialize, Serialize};
use tracing::{info, Level};
use tracing_subscriber;
use LibCulqi::create;
use warp::reject::Reject;
use warp::{self, http::StatusCode, reject::Rejection, reply::Reply};


#[derive(Deserialize)]
struct Data {
    field: String,
}

#[derive(Serialize)]
struct Response {
    message: String,
}

#[tokio::main]
async fn main() {
    tracing_subscriber::fmt()
        .with_max_level(Level::DEBUG)
        .init();

    info!("Iniciando servidor en 127.0.0.1:3030...");

    // Ruta específica para el archivo "index.html"
    let hello = warp::path!("index.html")
        .and(warp::fs::file("./static/index.html"))
        .and_then(handle_file);

    let index_card = warp::path!("index-card.html")
        .and(warp::fs::file("./static/index-card.html"))
        .and_then(index_card);

    // Ruta para servir todo el contenido de la carpeta "static"
    let static_files = warp::path("static")
        .and(warp::fs::dir("./static/"));

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

    let routes = hello.or(static_files).or(post_data).or(generate_charge).or(create_customer).or(index_card).or(create_card);

    warp::serve(routes)
        .run(([127, 0, 0, 1], 3030))
        .await;
}

async fn handle_file(file: warp::fs::File) -> Result<impl Reply, Rejection> {
    Ok(warp::reply::with_header(file, CONTENT_TYPE, "text/html"))
}

async fn index_card(file: warp::fs::File) -> Result<impl Reply, Rejection> {
    Ok(warp::reply::with_header(file, CONTENT_TYPE, "text/html"))
}

// Define una estructura para el JSON de entrada
#[derive(Debug, Deserialize, Serialize)]
struct ClientDetails {
    first_name: String,
    last_name: String,
    email: String,
    phone_number: String,
}

#[derive(Debug, Deserialize, Serialize)]
struct InputData {
    amount: i32,
    currency_code: String,
    description: String,
    order_number: String,
    client_details: ClientDetails,
    expiration_date: i64,
}
#[derive(Serialize, Deserialize, Debug)]
struct AntiFraudDetails {
    #[serde(skip_serializing_if = "Option::is_none")]
    first_name: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    last_name: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    email: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    phone_number: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    device_finger_print_id: Option<String>,
}

#[derive(Serialize, Deserialize, Debug)]
struct Authentication3DS {
    #[serde(skip_serializing_if = "Option::is_none")]
    eci: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    xid: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    cavv: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    protocolVersion: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    directoryServerTransactionId: Option<String>,
}

#[derive(Serialize, Deserialize, Debug)]
struct BodyCharge {
    #[serde(skip_serializing_if = "Option::is_none")]
    amount: Option<i32>,
    #[serde(skip_serializing_if = "Option::is_none")]
    currency_code: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    email: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    source_id: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    antifraud_details: Option<AntiFraudDetails>,
    #[serde(skip_serializing_if = "Option::is_none")]
    authentication_3DS: Option<Authentication3DS>,
}

#[derive(Serialize, Deserialize, Debug)]
struct BodyCustomer {
    first_name: String,
    last_name: String,
    email: String,
    address: String,
    address_city: String,
    country_code: String,
    phone_number: String,
}


#[derive(Serialize, Deserialize, Debug)]
struct BodyCard {
    #[serde(skip_serializing_if = "Option::is_none")]
    customer_id: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    token_id: Option<String>,
    #[serde(skip_serializing_if = "Option::is_none")]
    authentication_3DS: Option<Authentication3DS>,
}
// Tipo de error personalizado que implementa Reject

#[derive(Debug)]
enum CustomRejection {
    SerializationError(serde_json::Error),
    ReqwestError(reqwest::Error),
}

impl Reject for CustomRejection {}

async fn create_card(input: BodyCard) -> Result<impl Reply, Rejection> {
    let pk = "pk_test_90667d0a57d45c48";
    let sk = "sk_test_1573b0e8079863ff";
    // Convertir el input a JSON y manejar errores de serialización
    let body = match serde_json::to_string(&input) {
        Ok(json_str) => json_str,
        Err(e) => return Ok(warp::reply::with_status(warp::reply::html(format!("Serialization error: {}", e)), StatusCode::BAD_REQUEST)),
    };
    
    match create(&body, "cards", pk, sk).await {
        Ok((response_text, status_code)) => {
            println!("Status Code: {}", status_code);
            println!("Response Text: {}", response_text);

            // Crear una respuesta con el contenido de response_text y configurar el código de estado a 201
            match status_code {
                201 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::CREATED)),
                200 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::OK)),
                400 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::BAD_REQUEST)),
                _ => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::INTERNAL_SERVER_ERROR)),
            }
            
        }
        Err(reqwest_err) => {
            println!("Reqwest Error: {:?}", reqwest_err);
            // Devolver un error de rechazo personalizado con el tipo CustomRejection
            Err(warp::reject::custom(CustomRejection::ReqwestError(reqwest_err)))
        }
    }
}

async fn create_customer(input: BodyCustomer) -> Result<impl Reply, Rejection> {
    let pk = "pk_test_90667d0a57d45c48";
    let sk = "sk_test_1573b0e8079863ff";
    // Convertir el input a JSON y manejar errores de serialización
    let body = match serde_json::to_string(&input) {
        Ok(json_str) => json_str,
        Err(e) => return Ok(warp::reply::with_status(warp::reply::html(format!("Serialization error: {}", e)), StatusCode::BAD_REQUEST)),
    };
    
    match create(&body, "customers", pk, sk).await {
        Ok((response_text, status_code)) => {
            println!("Status Code: {}", status_code);
            println!("Response Text: {}", response_text);

            // Crear una respuesta con el contenido de response_text y configurar el código de estado a 201
            match status_code {
                201 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::CREATED)),
                200 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::OK)),
                400 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::BAD_REQUEST)),
                _ => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::INTERNAL_SERVER_ERROR)),
            }
            
        }
        Err(reqwest_err) => {
            println!("Reqwest Error: {:?}", reqwest_err);
            // Devolver un error de rechazo personalizado con el tipo CustomRejection
            Err(warp::reject::custom(CustomRejection::ReqwestError(reqwest_err)))
        }
    }
}

async fn generate_charge(input: BodyCharge) -> Result<impl Reply, Rejection> {

    let pk = "pk_test_90667d0a57d45c48";
    let sk = "sk_test_1573b0e8079863ff";
    // Convertir el input a JSON y manejar errores de serialización
    let body = match serde_json::to_string(&input) {
        Ok(json_str) => json_str,
        Err(e) => return Ok(warp::reply::with_status(warp::reply::html(format!("Serialization error: {}", e)), StatusCode::BAD_REQUEST)),
    };
    
    match create(&body, "charges", pk, sk).await {
        Ok((response_text, status_code)) => {
            println!("Status Code: {}", status_code);
            println!("Response Text: {}", response_text);

            // Crear una respuesta con el contenido de response_text y configurar el código de estado a 201
            match status_code {
                201 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::CREATED)),
                200 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::OK)),
                400 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::BAD_REQUEST)),
                _ => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::INTERNAL_SERVER_ERROR)),
            }
            
        }
        Err(reqwest_err) => {
            println!("Reqwest Error: {:?}", reqwest_err);
            // Devolver un error de rechazo personalizado con el tipo CustomRejection
            Err(warp::reject::custom(CustomRejection::ReqwestError(reqwest_err)))
        }
    }
}


async fn generate_order(input: InputData) -> Result<impl Reply, Rejection> {

    println!("Amount: {}", input.amount);
    let pk = "pk_test_90667d0a57d45c48";
    let sk = "sk_test_1573b0e8079863ff";
    // Convertir el input a JSON y manejar errores de serialización
    let body = match serde_json::to_string(&input) {
        Ok(json_str) => json_str,
        Err(e) => return Ok(warp::reply::with_status(warp::reply::html(format!("Serialization error: {}", e)), StatusCode::BAD_REQUEST)),
    };
    
    match create(&body, "orders", pk, sk).await {
        Ok((response_text, status_code)) => {
            println!("Status Code: {}", status_code);
            println!("Response Text: {}", response_text);

            // Crear una respuesta con el contenido de response_text y configurar el código de estado a 201
            match status_code {
                201 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::CREATED)),
                200 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::OK)),
                400 => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::BAD_REQUEST)),
                _ => Ok(warp::reply::with_status(warp::reply::html(response_text), StatusCode::INTERNAL_SERVER_ERROR)),
            }
            
        }
        Err(reqwest_err) => {
            println!("Reqwest Error: {:?}", reqwest_err);
            // Devolver un error de rechazo personalizado con el tipo CustomRejection
            Err(warp::reject::custom(CustomRejection::ReqwestError(reqwest_err)))
        }
    }
}