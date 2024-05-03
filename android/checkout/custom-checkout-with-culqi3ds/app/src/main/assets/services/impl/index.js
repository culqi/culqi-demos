import Service from "../index.js";

const service = new Service();

export const generateChargeImpl = async ({ payload, headers = {} }) => {
  return service.generateCharge(payload, headers);
};
