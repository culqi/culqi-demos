use serde_json::{Value, json};

#[allow(dead_code)]
pub fn get_header_charge_recurrent() -> Value {
    json!({
        "X-Charge-Channels": "recurrent"
    })
}
