package com.apitest.apiTest.rest.dto;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.*;

import javax.validation.Valid;

@Builder
@Getter
@Setter
@AllArgsConstructor
@ToString
public class ChargeRequest {
    @JsonProperty("amount")
    private String amount;

    @JsonProperty("currency_code")
    private String currency;

    @JsonProperty(value = "source_id", required = true)
    private String source;

    @JsonProperty("email")
    private String mail;

    @JsonProperty("authentication_3DS")
    private Authentication3DS authentication3DS;

    @Valid
    @JsonProperty("antifraud_details")
    private AntifraudDetails antifraud;

}
