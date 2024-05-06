package com.culqi.culqidemos.dto;

import javax.validation.Valid;

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
public class ChargeRequestDTO {

  private String amount;

  @JsonProperty("currency_code")
  private String currencyIsoCode;

  @JsonProperty(value = "source_id", required = true)
  private String source;

  private String email;

  @JsonProperty("authentication_3DS")
  private Authentication3dsDTO authentication3DS;

  @Valid
  @JsonProperty("antifraud_details")
  private AntifraudDetailsDTO antifraud;
}
