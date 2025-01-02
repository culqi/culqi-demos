use serde::{Deserialize, Serialize};

#[derive(Serialize, Deserialize, Debug,)]
#[allow(non_snake_case)]
pub struct Authentication3DS {
    #[serde(skip_serializing_if = "Option::is_none")]
    eci:                          Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    xid:                          Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    cavv:                         Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    protocolVersion:              Option<String,>,
    #[serde(skip_serializing_if = "Option::is_none")]
    directoryServerTransactionId: Option<String,>,
}
