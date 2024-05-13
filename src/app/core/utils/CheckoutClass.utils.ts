import { culqi_url_base } from '../constants/http.constants';
import type {
  ICulqi,
  ICulqiConfig,
  ICulqiError,
  IOrder,
  IToken,
} from '../interfaces/checkout.interface';

import ScriptService from './ScriptClass.utils';

const baseUrlCheckout = culqi_url_base.checkout;

export default class CulqiCheckout extends ScriptService {
  private Culqi: ICulqi | null = null;

  constructor(private codigoComercio: string, private config: ICulqiConfig) {
    super('culqi-lib', 'CulqiCheckout', baseUrlCheckout);
    if (typeof window !== 'undefined' && this.config.options?.paymentMethods) {
      this.initCulqi();
    }
  }

  private async initCulqi(): Promise<void> {
    await this.appendScript();
    this.Culqi = new window['CulqiCheckout'](this.codigoComercio, this.config);
  }

  public open(): any {
    return new Promise<void>(
      (resolve: () => void, reject: (reason?: any) => void) => {
        let c: number = 0;
        const checkoutCulqiOpen: NodeJS.Timeout = setInterval(() => {
          c++;
          if (c > 10) {
            clearInterval(checkoutCulqiOpen);
            console.error('Superó el límite de verificaciones');
            reject();
          }
          if (this.Culqi?.getSettings()) {
            clearInterval(checkoutCulqiOpen);
            this.Culqi?.open();
            resolve();
          }
        }, 1000);
      }
    );
  }

  override destroy(): void {
    document.getElementById('checkout-lib')?.remove();
    this.Culqi = null;
  }

  getSettings(): any {
    return this.Culqi?.getSettings() ?? null;
  }

  getToken(): IToken | null {
    return this.Culqi?.token ?? null;
  }

  getOrder(): IOrder | null {
    return this.Culqi?.order ?? null;
  }

  getError(): ICulqiError | null {
    return this.Culqi?.error ?? null;
  }

  getMethodActived(): string | null {
    return this.Culqi!.methodValue;
  }

  orderWasObjectCreated(): boolean {
    return this.Culqi!.wasObjectCreated;
  }
  public set handleAction(fun: () => void) {
    this.Culqi!.culqi = fun;
  }

  public set methodActivedFunction(fun: () => void) {
    this.Culqi!.methodActive = fun;
  }

  public set closeCheckoutFunction(fun: () => void) {
    this.Culqi!.closeCheckout = fun;
  }

  public get isOpen(): boolean {
    return this.Culqi!.isOpen;
  }

  close(): void {
    this.Culqi?.close();
  }
}
