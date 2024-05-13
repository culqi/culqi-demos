import type { ICulqi3DS } from '../interfaces/culqi3ds.interface';
import ScriptService from './ScriptClass.utils';
import { CULQI3DS_RESULT } from '../enum/global.enum';
import type { CULQI3DS_RESULT as CULQI3DS_RESULT_TYPE } from '../enum/global.enum';
import { HTTP } from '../enum/http.enum';
import { culqi_url_base } from '../constants/http.constants';

const baseUrl3DS = culqi_url_base.culqi_3ds;

export default class Culqi3DSService extends ScriptService {
  private Culqi3DS: ICulqi3DS | null = null;

  public device: string | null = null;

  constructor(private codigoComercio: string) {
    super('culqi-3ds-lib', 'Culqi3DS', baseUrl3DS);
    if (typeof window !== 'undefined') {
      this.initCulqi3DS();
    }
  }

  private async initCulqi3DS(): Promise<void> {
    await this.appendScript();
    this.Culqi3DS = window['Culqi3DS'];
    this.Culqi3DS!.publicKey = this.codigoComercio;
  }

  public open(): any {
    return new Promise<void>(
      (resolve: () => void, reject: (reason?: any) => void) => {
        let c: number = 0;
        const Culqi3DSInitial: NodeJS.Timeout = setInterval(async () => {
          c++;
          if (c > 10) {
            clearInterval(Culqi3DSInitial);
            console.error('Superó el límite de verificaciones');
            reject();
          }
          if (this.Culqi3DS?._publicKey) {
            clearInterval(Culqi3DSInitial);
            this.Culqi3DS.options = {
              showModal: true,
              showLoading: true,
              showIcon: true,
              closeModalAction: () => window.location.reload(),
            };
            this.device = (await this.Culqi3DS?.generateDevice()) as string;
            resolve();
          }
        }, 1000);
      }
    );
  }

  override destroy(): void {
    document.getElementById('culqi-3ds-lib')?.remove();
    this.Culqi3DS = null;
  }

  public getDevice(): string | null {
    return this.device;
  }
  public getPk() {
    return this.Culqi3DS?._publicKey;
  }

  public async validationInit3DS({
    token,
    statusCode,
    email,
    amount,
    url,
  }: {
    token: string;
    statusCode: number;
    email: string;
    amount: number;
    url: string;
  }): Promise<CULQI3DS_RESULT_TYPE> {
    if (statusCode === HTTP.STATUS_CODE_200) {
      this.Culqi3DS!.settings = {
        charge: {
          totalAmount: amount,
          returnUrl: url,
        },
        card: {
          email,
        },
      };
      await this.Culqi3DS?.initAuthentication(token);
      return CULQI3DS_RESULT.INIT_AUTH;
    }
    if (statusCode === HTTP.STATUS_CODE_201) {
      this.Culqi3DS?.reset();
      return CULQI3DS_RESULT.SUCCES_WITH_3DS;
    }
    return CULQI3DS_RESULT.ERROR;
  }

  public reset(): void {
    this.Culqi3DS?.reset();
  }
}
