package com.apitest.apiTest.rest.dto;

import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.*;

@Builder
@Getter
@Setter
@AllArgsConstructor
@ToString
public class Authentication3DS {

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
