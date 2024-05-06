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
public class Authentication3dsDTO {
  @JsonProperty("cavv")
  private String cavv;

  @JsonProperty("directoryServerTransactionId")
  private String directoryServerTransactionId;

  @JsonProperty("eci")
  private String eci;

  @JsonProperty("protocolVersion")
  private String protocolVersion;

  @JsonProperty("xid")
  private String xid;
}
