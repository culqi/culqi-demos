package com.culqi.culqidemos.controller;

import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.culqi.culqidemos.dto.CardRequestDTO;
import com.culqi.culqidemos.dto.ChargeRequestDTO;
import com.culqi.culqidemos.dto.CustomerRequestDTO;
import com.culqi.culqidemos.dto.OrderRequestDTO;
import com.culqi.culqidemos.service.PaymentService;

import lombok.RequiredArgsConstructor;

import javax.validation.Valid;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;

@RestController
@RequestMapping("/culqi")
@RequiredArgsConstructor
public class PaymentController {
  private final PaymentService paymentService;

  @PostMapping("/createCharge")
  public ResponseEntity<Object> createCharge(@RequestBody @Valid ChargeRequestDTO chargeRequest) throws Exception {
    return paymentService.createCharge(chargeRequest);
  }

  @PostMapping("/createCustomer")
  public ResponseEntity<Object> createCustomer(@RequestBody @Valid CustomerRequestDTO customerRequest)
      throws Exception {
    return paymentService.createCustomer(customerRequest);
  }

  @PostMapping("/createCard")
  public ResponseEntity<Object> createCard(@RequestBody @Valid CardRequestDTO cardRequest) throws Exception {
    return paymentService.createCard(cardRequest);
  }

  @PostMapping("/createOrder")
  public ResponseEntity<Object> createOrder(@RequestBody @Valid OrderRequestDTO orderRequest) throws Exception {
    return paymentService.createOrder(orderRequest);
  }
}
