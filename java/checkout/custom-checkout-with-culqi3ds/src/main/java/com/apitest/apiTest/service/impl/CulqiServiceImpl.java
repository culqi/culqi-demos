package com.apitest.apiTest.service.impl;

import com.apitest.apiTest.external.provider.CulqiProvider;
import com.apitest.apiTest.rest.dto.CardRequest;
import com.apitest.apiTest.rest.dto.ChargeRequest;
import com.apitest.apiTest.rest.dto.CustomerRequest;
import com.apitest.apiTest.rest.dto.OrderRequest;
import com.apitest.apiTest.service.CulqiService;
import com.google.gson.Gson;
import lombok.AllArgsConstructor;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.client.HttpStatusCodeException;

import java.util.Objects;

@Service
@AllArgsConstructor
public class CulqiServiceImpl implements CulqiService {

    private CulqiProvider culqiProvider;

    private static final Logger log = LoggerFactory.getLogger(CulqiServiceImpl.class);

    @Override
    public ResponseEntity<Object> generateCharge(ChargeRequest chargeRequest) {
        try {
            ResponseEntity<Object> response = generateChargeExternal(chargeRequest);
            Object responseBody = response.getBody();
            log.info("Culqi response {} ", responseBody);
            if (responseBody instanceof String) {
                Gson g = new Gson();
                responseBody = g.fromJson(Objects.requireNonNull(response.getBody()).toString(), Object.class);
            }
            return new ResponseEntity<>(responseBody, response.getStatusCode());
        } catch (Exception e) {
            log.info(e.getMessage());
            return new ResponseEntity<>("Ocurrio un error al generar el cargo", HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    @Override
    public ResponseEntity<Object> generateOrder(OrderRequest orderRequest) {
        try {
            ResponseEntity<Object> response = generateOrderExternal(orderRequest);
            Object responseBody = response.getBody();
            log.info("Culqi response {} ", responseBody);
            if (responseBody instanceof String) {
                Gson g = new Gson();
                responseBody = g.fromJson(Objects.requireNonNull(response.getBody()).toString(), Object.class);
            }
            return new ResponseEntity<>(responseBody, response.getStatusCode());
        } catch (Exception e) {
            log.info(e.getMessage());
            return new ResponseEntity<>("Ocurrio un error al generar el orden", HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    @Override
    public ResponseEntity<Object> createCustomer(CustomerRequest customerRequest) {
        ResponseEntity<Object> response = generateCustomerExternal(customerRequest);
        if (response != null) {
            Object responseBody = response.getBody();
            log.info("Culqi response {} ", responseBody);
            return new ResponseEntity<>(responseBody, response.getStatusCode());
        } else {
            return new ResponseEntity<>("Ocurrio un error al crear el customer", HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    @Override
    public ResponseEntity<Object> createCard(CardRequest cardRequest) {
        try {
            ResponseEntity<Object> response = generateCardExternal(cardRequest);
            Object responseBody = response.getBody();
            log.info("Culqi response {} ", responseBody);
            if (responseBody instanceof String) {
                Gson g = new Gson();
                responseBody = g.fromJson(Objects.requireNonNull(response.getBody()).toString(), Object.class);
            }
            return new ResponseEntity<>(responseBody, response.getStatusCode());
        } catch (Exception e) {
            log.info(e.getMessage());
            return new ResponseEntity<>("Ocurrio un error al generar el card", HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    private ResponseEntity<Object> generateChargeExternal(ChargeRequest chargeRequest) {
        try {
            return culqiProvider.generateCharge(chargeRequest);
        } catch (HttpStatusCodeException e) {
            return new ResponseEntity<>(e.getResponseBodyAsString(), e.getStatusCode());
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    private ResponseEntity<Object> generateOrderExternal(OrderRequest orderRequest) {
        try {
            return culqiProvider.generateOrder(orderRequest);
        } catch (HttpStatusCodeException e) {
            return new ResponseEntity<>(e.getResponseBodyAsString(), e.getStatusCode());
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    private ResponseEntity<Object> generateCardExternal(CardRequest cardRequest) {
        try {
            return culqiProvider.createCard(cardRequest);
        } catch (HttpStatusCodeException e) {
            return new ResponseEntity<>(e.getResponseBodyAsString(), e.getStatusCode());
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    private ResponseEntity<Object> generateCustomerExternal(CustomerRequest customerRequest) {
        try {
            return culqiProvider.createCustomer(customerRequest);
        } catch (HttpStatusCodeException e) {
            return new ResponseEntity<>(e.getResponseBodyAsString(), e.getStatusCode());
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }
}
