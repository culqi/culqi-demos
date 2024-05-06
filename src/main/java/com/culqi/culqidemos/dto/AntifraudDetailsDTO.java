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
public class AntifraudDetailsDTO {

  @JsonProperty("first_name")
  private String firstName;

  @JsonProperty("last_name")
  private String lastName;

  private String address;

  @JsonProperty("address_city")
  private String addressCity;

  @JsonProperty("country_code")
  private String countryCode;

  @JsonProperty("phone_number")
  private String phoneNumber;

  @JsonProperty("device_finger_print_id")
  private String deviceFingerPrintId;
}
