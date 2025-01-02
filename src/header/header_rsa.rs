use serde_json::{Value, json};

use crate::client::credentials::RSA_ID;

#[allow(dead_code)]
pub fn get_header_encrypt() -> Value {
    json!({
        "x-culqi-rsa-id": RSA_ID
    })
}
