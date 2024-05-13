import { Component, OnDestroy, OnInit } from '@angular/core';
import { culqiConfig } from '../../../../core/constants/checkoutConfig.constants';
import { checkoutConfig } from '../../../../core/constants/global.constants';
import { CulqiApiService } from '../../../../core/services/culqi-api.service';
import CulqiCheckoutClass from '../../../../core/utils/CheckoutClass.utils';
import Culqi3DSClass from '../../../../core/utils/Culqi3DSClass.utils';
import { getMessage } from '../../../../core/utils/global.utils';

@Component({
  selector: 'app-charge',
  standalone: true,
  imports: [],
  templateUrl: './charge.component.html',
  styleUrl: './charge.component.css',
})
export class ChargeComponent implements OnInit, OnDestroy {
  private culqiApi: CulqiApiService = new CulqiApiService();

  private publicKey = checkoutConfig.PUBLIC_KEY;
  public CulqiCheckout: any;
  private Culqi3DS: any;
  private removeMessageListener: any;
  private device3DS: string | null = null;
  private orderId: string | null = null;
  private tokenId: string | null = null;
  private tokenEmail: string | null = null;
  public chargeMessage: string | null = null;
  private amount = 900;

  constructor() {}

  ngOnInit(): void {
    this.initializeCulqi3DS();
    this.setupMessageListener();
    this.initializeCulqiCheckout();
  }

  ngOnDestroy(): void {
    if (this.removeMessageListener) {
      this.removeMessageListener();
    }
  }

  initializeCulqi3DS(): void {
    this.Culqi3DS = new Culqi3DSClass(this.publicKey);
    this.Culqi3DS.open()
      .then(async () => {
        console.log('3DS GENERADO');
        this.device3DS = await this.Culqi3DS.getDevice();
      })
      .catch((err: any) => {
        console.log('error 3DS:: ', err);
      });
  }

  async initializeCulqiCheckout(): Promise<void> {
    const config = await culqiConfig({
      installments: true,
      orderId: this.orderId || '',
      buttonTex: '',
      amount: this.amount,
    });
    this.CulqiCheckout = new CulqiCheckoutClass(this.publicKey, config);
  }

  setupMessageListener(): void {
    this.removeMessageListener = getMessage(
      this.handleSuccess3DSParameters.bind(this),
      (err) => {
        console.log('ERROR 3DS CARGO:: ', err);
      }
    );
  }

  async handleSuccess3DSParameters(parameters3DS: any): Promise<void> {
    const { data, status } = await this.culqiApi.createCharge({
      deviceId: this.device3DS || '',
      email: this.tokenEmail || '',
      tokenId: this.tokenId || '',
      parameters3DS,
    });

    if (status === 201 && data.object === 'charge') {
      this.chargeMessage = 'OPERACIÓN REALIZADA EXITOSAMENTE CON 3DS';
    }
    this.Culqi3DS.reset();
  }

  handleResponse(
    token: string,
    email: string,
    statusCode: number,
    objResponse: any
  ): void {
    let message = '';
    switch (statusCode) {
      case 200:
        if (objResponse.action_code === 'REVIEW') {
          this.Culqi3DS.validationInit3DS({
            token,
            statusCode,
            email,
            amount: this.amount,
            url: checkoutConfig.URL_BASE,
          });
          return;
        }
        message = 'ERROR AL REALIZAR LA OPERACIÓN';
        break;
      case 201:
        message = 'OPERACIÓN EXITOSA - SIN 3DS';
        this.Culqi3DS.reset();
        break;
      default:
        message = 'OPERACIÓN FALLIDA - SIN 3DS';
        this.Culqi3DS.reset();
        break;
    }
    this.chargeMessage = message;
  }

  async handleCulqiToken(): Promise<void> {
    const token = this.CulqiCheckout.getToken();
    const error = this.CulqiCheckout.getError();
    if (error) {
      console.log('ERROR - ERROR: ', error);
      alert(error.user_message);
      return;
    }
    if (!token) {
      return;
    }
    this.tokenId = token.id;
    this.tokenEmail = token.email;

    this.CulqiCheckout.close();
    const { data, status } = await this.culqiApi.createCharge({
      deviceId: this.device3DS || '',
      email: token.email,
      tokenId: token.id,
    });
    this.handleResponse(token.id, token.email, status, data);
  }

  async openCheckout(): Promise<void> {
    this.CulqiCheckout.open()
      .then(async () => {
        this.CulqiCheckout.handleAction = () => this.handleCulqiToken();
        this.CulqiCheckout.closeCheckoutFunction = () => {
          console.log('cerrando...');
        };
      })
      .catch((err: any) => {
        console.log('falló al abrir checkout');
      });
  }
}
