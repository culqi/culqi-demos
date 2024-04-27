package com.apitest.apiTest.rest.dto;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.*;

@Builder
@Getter
@Setter
@AllArgsConstructor
@ToString
public class CustomerRequest {

    @JsonProperty("first_name")
    private String firstName;

    @JsonProperty("last_name")
    private String lastName;

    private String email;

    private String address;

    @JsonProperty("address_city")
    private String addressCity;

    @JsonProperty("country_code")
    private String countryCode;

    @JsonProperty("phone_number")
    private String phoneNumber;

}
