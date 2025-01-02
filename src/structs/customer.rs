use serde::{Deserialize, Serialize};

#[derive(Serialize, Deserialize, Debug,)]
pub struct BodyCustomer {
    first_name:   String,
    last_name:    String,
    email:        String,
    address:      String,
    address_city: String,
    country_code: String,
    phone_number: String,
}
