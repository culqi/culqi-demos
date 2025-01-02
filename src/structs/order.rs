use serde::{Deserialize, Serialize};

#[derive(Serialize, Deserialize, Debug,)]
struct ClientDetails {
    first_name:   String,
    last_name:    String,
    email:        String,
    phone_number: String,
}

#[derive(Serialize, Deserialize, Debug,)]
pub struct BodyOrder {
    amount:          i32,
    currency_code:   String,
    description:     String,
    order_number:    String,
    client_details:  ClientDetails,
    expiration_date: i64,
}
