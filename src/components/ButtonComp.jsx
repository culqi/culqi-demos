import React from "react";

const ButtonComp = ({ text, onClickButton, isDisabled = false }) => {
  return (
    <button
      className="px-4 py-2 font-bold text-white bg-purple-500 rounded shadow hover:bg-purple-400 focus:shadow-outline focus:outline-none"
      onClick={onClickButton}
      disabled={isDisabled}
    >
      {text}
    </button>
  );
};

export default ButtonComp;
