package com.apitest.apiTest.rest.controller;

import com.apitest.apiTest.rest.dto.CardRequest;
import com.apitest.apiTest.rest.dto.ChargeRequest;
import com.apitest.apiTest.rest.dto.CustomerRequest;
import com.apitest.apiTest.rest.dto.OrderRequest;
import com.apitest.apiTest.service.CulqiService;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import javax.validation.Valid;

@RestController
@RequestMapping("/culqi")
@RequiredArgsConstructor
public class CulqiController {
    private final CulqiService culqiService;

    @PostMapping("/generateCharge")
    public ResponseEntity<Object> generateCharge(@RequestBody @Valid ChargeRequest chargeRequest) {
        return culqiService.generateCharge(chargeRequest);
    }

    @PostMapping("/createCustomer")
    public ResponseEntity<Object> createCustomer(@RequestBody @Valid CustomerRequest customerRequest) {
        return culqiService.createCustomer(customerRequest);
    }

    @PostMapping("/createCard")
    public ResponseEntity<Object> createCard(@RequestBody @Valid CardRequest cardRequest) {
        return culqiService.createCard(cardRequest);
    }

    @PostMapping("/generateOrder")
    public ResponseEntity<Object> generateOrder(@RequestBody @Valid OrderRequest orderRequest) {
        return culqiService.generateOrder(orderRequest);
    }

}
