package com.culqi.culqidemos.dto;

import com.fasterxml.jackson.annotation.JsonProperty;

import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Getter;
import lombok.Setter;
import lombok.ToString;

@Builder
@Getter
@Setter
@AllArgsConstructor
@ToString
public class CardRequestDTO {

  @JsonProperty("customer_id")
  private String customerId;

  @JsonProperty("token_id")
  private String tokenId;

  @JsonProperty("authentication_3DS")
  private Authentication3dsDTO authentication3DS;
  // hchallco
  @JsonProperty("device_finger_print_id")
  private String deviceFingerPrintId;
}
