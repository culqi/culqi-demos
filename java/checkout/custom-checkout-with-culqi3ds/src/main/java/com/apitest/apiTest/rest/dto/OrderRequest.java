package com.apitest.apiTest.rest.dto;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.*;

import javax.validation.Valid;

@Builder
@Getter
@Setter
@AllArgsConstructor
@ToString
public class OrderRequest {
    @JsonProperty("amount")
    private String amount;

    @JsonProperty("currency_code")
    private String currency;

    @JsonProperty(value = "description")
    private String description;

    @JsonProperty("order_number")
    private String order_number;

    @JsonProperty("client_details")
    private ClientDetailsRequest clientDetailsRequest;

}
