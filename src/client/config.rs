use LibCulqi::client::Client;

use super::credentials::{PUBLIC_KEY, RSA_KEY, SECRET_KEY};

pub fn create_client_encrypt() -> Client {
    Client::config(&SECRET_KEY, &PUBLIC_KEY, Some(&RSA_KEY,),)
}

pub fn create_client() -> Client {
    Client::config(&SECRET_KEY, &PUBLIC_KEY, None,)
}
