export const getEpochSeconds = () => {
  const currentDate = new Date();
  currentDate.setDate(currentDate.getDate() + 1);
  return Math.floor(currentDate.getTime() / 1000);
};
