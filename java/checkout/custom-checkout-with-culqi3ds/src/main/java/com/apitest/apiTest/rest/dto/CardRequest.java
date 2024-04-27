package com.apitest.apiTest.rest.dto;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.*;

@Builder
@Getter
@Setter
@AllArgsConstructor
@ToString
public class CardRequest {

    @JsonProperty("customer_id")
    private String customerId;

    @JsonProperty("token_id")
    private String tokenId;

    @JsonProperty("authentication_3DS")
    private Authentication3DS authentication3DS;
    // hchallco
    @JsonProperty("device_finger_print_id")
    private String deviceFingerPrintId;

}
