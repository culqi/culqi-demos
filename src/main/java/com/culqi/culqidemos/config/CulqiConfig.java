package com.culqi.culqidemos.config;

import com.culqi.Culqi;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

@Configuration
public class CulqiConfig {

  @Value("${app.culqi.public-key}")
  private String publicKey;

  @Value("${app.culqi.secret-key}")
  private String secretKey;

  @Bean
  @SuppressWarnings("static-access")
  public Culqi init() {
    Culqi culqi = new Culqi();
    culqi.public_key = publicKey;
    culqi.secret_key = secretKey;
    return culqi;
  }

}
