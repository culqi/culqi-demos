package com.culqi.culqidemos.service.impl;

import java.util.Objects;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

import com.culqi.culqidemos.client.CulqiProvider;
import com.culqi.culqidemos.dto.CardRequestDTO;
import com.culqi.culqidemos.dto.ChargeRequestDTO;
import com.culqi.culqidemos.dto.CustomerRequestDTO;
import com.culqi.culqidemos.dto.OrderRequestDTO;
import com.culqi.culqidemos.service.PaymentService;
import com.google.gson.Gson;

@Service
public class PaymentServiceImpl implements PaymentService {

  private CulqiProvider culqiProvider;

  private static final Logger LOGGER = LoggerFactory.getLogger(PaymentServiceImpl.class);

  public PaymentServiceImpl(CulqiProvider culqiProvider) {
    this.culqiProvider = culqiProvider;
  }

  @Override
  public ResponseEntity<Object> createCharge(ChargeRequestDTO chargeRequest) throws Exception {
    return processRequest(chargeRequest, culqiProvider::createCharge, "Ocurrio un error al generar el cargo");
  }

  @Override
  public ResponseEntity<Object> createOrder(OrderRequestDTO orderRequest) throws Exception {
    return processRequest(orderRequest, culqiProvider::createOrder, "Ocurrio un error al generar el orden");
  }

  @Override
  public ResponseEntity<Object> createCustomer(CustomerRequestDTO customerRequest) throws Exception {
    return processRequest(customerRequest, culqiProvider::createCustomer, "Ocurrio un error al crear el customer");

  }

  @Override
  public ResponseEntity<Object> createCard(CardRequestDTO cardRequest) throws Exception {
    return processRequest(cardRequest, culqiProvider::createCard, "currio un error al generar el card");
  }

  private <T> ResponseEntity<Object> processRequest(T request,
      FunctionWithException<T, ResponseEntity<Object>> function, String errorMessage) {
    try {
      ResponseEntity<Object> response = function.apply(request);
      Object responseBody = convertResponseToObject(response.getBody());
      LOGGER.info("Culqi response => {}", responseBody);
      return new ResponseEntity<>(responseBody, response.getStatusCode());
    } catch (Exception e) {
      LOGGER.error(errorMessage, e);
      return new ResponseEntity<>(errorMessage, HttpStatus.INTERNAL_SERVER_ERROR);
    }
  }

  @FunctionalInterface
  public interface FunctionWithException<T, R> {
    R apply(T t) throws Exception;
  }

  private Object convertResponseToObject(Object responseBody) {
    if (responseBody instanceof String) {
      Gson g = new Gson();
      responseBody = g.fromJson(Objects.requireNonNull(responseBody).toString(), Object.class);
    }
    return responseBody;
  }

}
