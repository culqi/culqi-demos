import type { IAuthentication3DS } from '../interfaces/culqi3ds.interface';

export const getMessage = (
  succesCb: (parameters3DS: IAuthentication3DS) => void,
  errorCb: (error: any) => void
) => {
  if (typeof window === 'undefined') {
    return () => {};
  }
  const messageHandler = async (event: MessageEvent) => {
    if (event.origin !== window.location.origin) {
      return;
    }

    const { parameters3DS, error } = event.data;

    if (parameters3DS) {
      succesCb(parameters3DS);
    }

    if (error) {
      errorCb(error);
    }
  };

  window.addEventListener('message', messageHandler);

  return () => {
    window.removeEventListener('message', messageHandler);
  };
};
