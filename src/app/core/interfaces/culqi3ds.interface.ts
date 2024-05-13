interface ICulqi3DSOptions {
  showModal: boolean;
  showLoading: boolean;
  showIcon: boolean;
  closeModalAction: () => void;
}

interface ICulqi3DSSettingsCharge {
  totalAmount: string | number;
  returnUrl: string;
}

interface ICulqi3DSSettings {
  charge: ICulqi3DSSettingsCharge;
  card: {
    email: string;
  };
}

export interface ICulqi3DS {
  options: ICulqi3DSOptions;
  publicKey: string | null;
  _publicKey: string | null;
  reset(): void;
  settings: ICulqi3DSSettings;
  initAuthentication: (tokenId?: string) => Promise<void>;
  generateDevice: () => Promise<string | null>;
}

export interface IAuthentication3DS {
  eci: string;
  xid: string;
  cavv: string;
  protocolVersion: string;
  directoryServerTransactionId: string;
}
