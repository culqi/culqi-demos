use serde::{Deserialize, Serialize};

use super::{antifrudetails::AntiFraudDetails, authentication_3ds::Authentication3DS};

#[derive(Serialize, Deserialize, Debug,)]
#[allow(non_snake_case)]
pub struct BodyCharge {
    #[serde(skip_serializing_if = "Option::is_none")]
    amount:             Option<i32,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    currency_code:      Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    email:              Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    source_id:          Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    antifraud_details:  Option<AntiFraudDetails,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    authentication_3DS: Option<Authentication3DS,>,
}
