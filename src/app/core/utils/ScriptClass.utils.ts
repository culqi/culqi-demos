declare global {
  interface Window {
    [key: string]: any;
  }
}

export interface IScriptService {
  appendScript(): Promise<void>;
  destroy(): void;
}

export default class ScriptService implements IScriptService {
  constructor(
    private scriptId: string,
    private nameFunction: string,
    private scriptSrc: string
  ) {}

  public appendScript(): Promise<void> {
    return new Promise<void>(
      (resolve: () => void, reject: (reason?: any) => void) => {
        if (!document.getElementById(this.scriptId)) {
          const script: HTMLScriptElement = document.createElement('script');
          script.setAttribute('src', this.scriptSrc);
          script.setAttribute('id', this.scriptId);
          document.body.appendChild(script);
        }
        this.checkScript(resolve, reject);
      }
    );
  }

  private checkScript(
    resolve: () => void,
    reject: (reason?: any) => void
  ): void {
    let c: number = 0;
    const checkScript: NodeJS.Timeout = setInterval(() => {
      c++;
      if (c > 10) {
        clearInterval(checkScript);
        reject(new Error('Superó el límite de verificaciones'));
      }
      if (window[this.nameFunction]) {
        clearInterval(checkScript);
        resolve();
      }
    }, 1000);
  }

  public destroy(): void {
    document.getElementById(this.scriptId)?.remove();
    window[this.scriptId] = null;
  }
}
