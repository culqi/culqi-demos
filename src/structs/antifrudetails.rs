use serde::{Deserialize, Serialize};

#[derive(Serialize, Deserialize, Debug,)]
pub struct AntiFraudDetails {
    #[serde(skip_serializing_if = "Option::is_none")]
    first_name:             Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    last_name:              Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    email:                  Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    phone_number:           Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    device_finger_print_id: Option<String,>,
}
