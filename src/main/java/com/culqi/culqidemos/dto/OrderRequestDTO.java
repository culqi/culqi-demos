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
public class OrderRequestDTO {

  private String amount;

  @JsonProperty("currency_code")
  private String currencyIsoCode;

  private String description;

  @JsonProperty("order_number")
  private String orderNumber;

  @JsonProperty("client_details")
  private ClientDetailsRequestDTO clientDetailsRequest;
}
