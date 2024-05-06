package com.culqi.culqidemos.client.impl;

import java.util.HashMap;
import java.util.Map;

// import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Component;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.culqi.Culqi;
import com.culqi.culqidemos.client.CulqiProvider;
import com.culqi.culqidemos.config.CulqiConfig;
import com.culqi.culqidemos.dto.CardRequestDTO;
import com.culqi.culqidemos.dto.ChargeRequestDTO;
import com.culqi.culqidemos.dto.CustomerRequestDTO;
import com.culqi.culqidemos.dto.OrderRequestDTO;
import com.culqi.model.ResponseCulqi;

@Component
public class CulqiProviderImpl implements CulqiProvider {

  private static final Logger LOGGER = LoggerFactory.getLogger(CulqiProviderImpl.class);

  private final Culqi culqi;

  @Value("${app.culqi.should-encrypt-payload}")
  private int shouldEncryptPayload;

  @Value("${app.culqi.rsa-public-key}")
  private String rsaPublicKey;

  @Value("${app.culqi.rsa-id}")
  private String rsaId;

  // @Autowired
  public CulqiProviderImpl(CulqiConfig culqiConfig) {
    this.culqi = culqiConfig.init();
  }

  protected Map<String, Object> createChargeMap(ChargeRequestDTO chargeRequest) {
    Map<String, Object> charge = new HashMap<String, Object>() {
      {
        put("amount", chargeRequest.getAmount());
        put("capture", true);
        put("currency_code", chargeRequest.getCurrencyIsoCode());
        put("description", "Venta de prueba");
        put("email", chargeRequest.getEmail());
        put("installments", 0);
        put("metadata", new HashMap<String, Object>() {
          {
            put("order_id", "1234");
          }
        });
        put("source_id", chargeRequest.getSource());
        put("antifraud_details", chargeRequest.getAntifraud());
        if (chargeRequest.getAuthentication3DS() != null) {
          put("authentication_3DS", chargeRequest.getAuthentication3DS());
        }
      }
    };
    LOGGER.info("CulqiProvider :: createChargeMap => {}", charge);
    return charge;
  }

  @Override
  public ResponseEntity<Object> createCharge(ChargeRequestDTO chargeRequest) throws Exception {
    ResponseCulqi response;
    if (shouldEncryptPayload == 1) {

      response = culqi.charge.create(createChargeMap(chargeRequest), rsaPublicKey, rsaId);
    } else {
      response = culqi.charge.create(createChargeMap(chargeRequest));
    }
    return createResponseEntity(response);
  }

  protected Map<String, Object> createOrderMap(OrderRequestDTO orderRequest) {
    Map<String, Object> order = new HashMap<String, Object>() {
      {
        put("amount", orderRequest.getAmount());
        put("currency_code", orderRequest.getCurrencyIsoCode());
        put("description", orderRequest.getDescription());
        put("order_number", orderRequest.getOrderNumber());
        put("expiration_date", (System.currentTimeMillis() / 1000) + 24 * 60 * 60);
        put("confirm", false);
        put("client_details", orderRequest.getClientDetailsRequest());
      }
    };
    LOGGER.info("CulqiProvider :: createOrderMap => {}", order);
    return order;
  }

  @Override
  public ResponseEntity<Object> createOrder(OrderRequestDTO orderRequest) throws Exception {
    ResponseCulqi response;
    if (shouldEncryptPayload == 1) {
      response = culqi.order.create(createOrderMap(orderRequest), rsaPublicKey, rsaId);
    } else {
      response = culqi.order.create(createOrderMap(orderRequest));
    }
    return createResponseEntity(response);
  }

  protected Map<String, Object> createCustomerMap(CustomerRequestDTO customerRequest) {
    Map<String, Object> customer = new HashMap<String, Object>() {
      {
        put("address", customerRequest.getAddress());
        put("address_city", customerRequest.getAddressCity());
        put("country_code", customerRequest.getCountryCode());
        put("email", customerRequest.getEmail());
        put("first_name", customerRequest.getFirstName());
        put("last_name", customerRequest.getLastName());
        put("phone_number", customerRequest.getPhoneNumber());
      }
    };
    LOGGER.info("CulqiProvider :: createCustomerMap => {}", customer);
    return customer;
  }

  @Override
  public ResponseEntity<Object> createCustomer(CustomerRequestDTO customerRequest) throws Exception {
    ResponseCulqi response;
    if (shouldEncryptPayload == 1) {
      response = culqi.customer.create(createCustomerMap(customerRequest), rsaPublicKey, rsaId);
    } else {
      response = culqi.customer.create(createCustomerMap(customerRequest));
    }
    return createResponseEntity(response);
  }

  protected Map<String, Object> createCardMap(CardRequestDTO cardRequest) {
    Map<String, Object> card = new HashMap<String, Object>() {
      {
        put("customer_id", cardRequest.getCustomerId());
        put("token_id", cardRequest.getTokenId());

        if (cardRequest.getAuthentication3DS() != null) {
          put("authentication_3DS", cardRequest.getAuthentication3DS());
        }
      }
    };
    LOGGER.info("CulqiProvider :: createCardMap => {}", card);
    return card;
  }

  @Override
  public ResponseEntity<Object> createCard(CardRequestDTO cardRequest) throws Exception {
    ResponseCulqi response;
    if (shouldEncryptPayload == 1) {
      response = culqi.card.create(createCardMap(cardRequest), rsaPublicKey, rsaId);
    } else {
      response = culqi.card.create(createCardMap(cardRequest));
    }
    return createResponseEntity(response);
  }

  private ResponseEntity<Object> createResponseEntity(ResponseCulqi response) {
    HttpHeaders headers = new HttpHeaders();
    headers.setContentType(MediaType.APPLICATION_JSON);
    return new ResponseEntity<>(response.getBody(), headers, response.getStatusCode());
  }
}
