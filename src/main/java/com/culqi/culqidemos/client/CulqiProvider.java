package com.culqi.culqidemos.client;

import org.springframework.http.ResponseEntity;

import com.culqi.culqidemos.dto.CardRequestDTO;
import com.culqi.culqidemos.dto.ChargeRequestDTO;
import com.culqi.culqidemos.dto.CustomerRequestDTO;
import com.culqi.culqidemos.dto.OrderRequestDTO;

public interface CulqiProvider {
  ResponseEntity<Object> createCharge(ChargeRequestDTO chargeRequest) throws Exception;

  ResponseEntity<Object> createOrder(OrderRequestDTO orderRequest) throws Exception;

  ResponseEntity<Object> createCustomer(CustomerRequestDTO customerRequest) throws Exception;

  ResponseEntity<Object> createCard(CardRequestDTO cardRequest) throws Exception;
}
