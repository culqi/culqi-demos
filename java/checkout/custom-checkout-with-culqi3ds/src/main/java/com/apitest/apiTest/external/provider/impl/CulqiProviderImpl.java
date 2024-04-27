package com.apitest.apiTest.external.provider.impl;

import com.apitest.apiTest.external.provider.CulqiProvider;
import com.apitest.apiTest.rest.dto.CardRequest;
import com.apitest.apiTest.rest.dto.ChargeRequest;
import com.apitest.apiTest.rest.dto.CustomerRequest;
import com.apitest.apiTest.rest.dto.OrderRequest;

import lombok.RequiredArgsConstructor;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.*;
import org.springframework.stereotype.Component;
import com.culqi.Culqi;
import com.culqi.model.ResponseCulqi;

import java.util.*;

@Component
@RequiredArgsConstructor
public class CulqiProviderImpl implements CulqiProvider {

    @Value("${app.culqi.public-key}")
    private String PUBLIC_KEY;

    @Value("${app.culqi.secret-key}")
    private String SECRET_KEY;

    @Value("${app.culqi.encrypt-payload}")
    private int encryptPayload;

    @Value("${app.culqi.rsa-public-key}")
    private String rsaPublicKey;

    @Value("${app.culqi.rsa-id}")
    private String rsaId;

    public Culqi init() {
        Culqi culqi = new Culqi();
        culqi.public_key = PUBLIC_KEY;
        culqi.secret_key = SECRET_KEY;
        return culqi;
    }

    protected Map<String, Object> jsonCharge(ChargeRequest chargeRequest) throws Exception {
        Map<String, Object> charge = new HashMap<String, Object>();
        Map<String, Object> metadata = new HashMap<String, Object>();
        metadata.put("order_id", "1234");
        charge.put("amount", chargeRequest.getAmount());
        charge.put("capture", true);
        charge.put("currency_code", chargeRequest.getCurrency());
        charge.put("description", "Venta de prueba");
        charge.put("email", chargeRequest.getMail());
        charge.put("installments", 0);
        charge.put("metadata", metadata);
        charge.put("source_id", chargeRequest.getSource());
        charge.put("antifraud_details", chargeRequest.getAntifraud());
        if (chargeRequest.getAuthentication3DS() != null) {
            charge.put("authentication_3DS", chargeRequest.getAuthentication3DS());
        }
        System.out.println(charge);
        return charge;
    }

    protected Map<String, Object> jsonOrder(OrderRequest orderRequest) throws Exception {
        Map<String, Object> order = new HashMap<String, Object>();
        order.put("amount", orderRequest.getAmount());
        order.put("currency_code", orderRequest.getCurrency());
        order.put("description", orderRequest.getDescription());
        order.put("order_number", orderRequest.getOrder_number());
        order.put("expiration_date", (System.currentTimeMillis() / 1000) + 24 * 60 * 60);
        order.put("confirm", false);
        order.put("client_details", orderRequest.getClientDetailsRequest());
        System.out.println(order);
        return order;
    }

    @Override
    public ResponseEntity<Object> generateCharge(ChargeRequest chargeRequest) throws Exception {
        ResponseCulqi response = new ResponseCulqi();
        if (encryptPayload == 1) {
            response = init().charge.create(jsonCharge(chargeRequest), rsaPublicKey, rsaId);
        } else {
            response = init().charge.create(jsonCharge(chargeRequest));
        }
        System.out.println(response.getBody());
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);

        return new ResponseEntity<>(response.getBody(), headers, response.getStatusCode());
    }

    @Override
    public ResponseEntity<Object> generateOrder(OrderRequest orderRequest) throws Exception {
        ResponseCulqi response = init().order.create(jsonOrder(orderRequest));
        System.out.println("response.getBody() " + response.getBody());
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);
        return new ResponseEntity<>(response.getBody(), headers, response.getStatusCode());
    }

    protected Map<String, Object> jsonCustomer(CustomerRequest customerRequest) throws Exception {
        Map<String, Object> customer = new HashMap<String, Object>();
        customer.put("address", customerRequest.getAddress());
        customer.put("address_city", customerRequest.getAddressCity());
        customer.put("country_code", customerRequest.getCountryCode());
        customer.put("email", customerRequest.getEmail());
        customer.put("first_name", customerRequest.getFirstName());
        customer.put("last_name", customerRequest.getLastName());
        customer.put("phone_number", customerRequest.getPhoneNumber());
        return customer;
    }

    @Override
    public ResponseEntity<Object> createCustomer(CustomerRequest customerRequest) throws Exception {
        ResponseCulqi response = init().customer.create(jsonCustomer(customerRequest));
        System.out.println(response.getBody());
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);
        return new ResponseEntity<>(response.getBody(), headers, response.getStatusCode());
    }

    protected Map<String, Object> jsonCard(CardRequest cardRequest) throws Exception {
        Map<String, Object> card = new HashMap<String, Object>();
        card.put("customer_id", cardRequest.getCustomerId());
        card.put("token_id", cardRequest.getTokenId());
        if (cardRequest.getAuthentication3DS() != null) {
            card.put("authentication_3DS", cardRequest.getAuthentication3DS());
        }
        return card;
    }

    @Override
    public ResponseEntity<Object> createCard(CardRequest cardRequest) throws Exception {
        ResponseCulqi response = init().card.create(jsonCard(cardRequest));
        System.out.println(response.getBody());
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_JSON);
        return new ResponseEntity<>(response.getBody(), headers, response.getStatusCode());
    }

}
