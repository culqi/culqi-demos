use serde::{Deserialize, Serialize};

use super::authentication_3ds::Authentication3DS;

#[derive(Serialize, Deserialize, Debug,)]
#[allow(non_snake_case)]
pub struct BodyCard {
    #[serde(skip_serializing_if = "Option::is_none")]
    customer_id:        Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    token_id:           Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    authentication_3DS: Option<Authentication3DS,>,
}
