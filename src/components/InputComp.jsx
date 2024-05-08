import React, { useState } from "react";

const InputComp = ({
  input,
  label,
  types,
  placeholder,
  data,
  values,
  maxlength = 50,
  spanDouble = false
}) => {
  const [inputValue, setInputValue] = useState("");

  const handleInputChange = (e) => {
    const newValue = e.target.value;
    setInputValue(newValue);
    values(input, { [input]: newValue }, e.target);
  };

  const handleFocus = (e) => {
    e.target.removeAttribute("style");
  };

  const renderInput = () => (
    <input
      type={types}
      id={input}
      name={input}
      placeholder={placeholder}
      onChange={handleInputChange}
      maxLength={maxlength}
      onFocus={handleFocus}
      className="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
      value={data}
    />
  );

  return (
    <div
      className={`w-full px-3 ${spanDouble ? " md:w-1/2 mb-6 md:mb-0" : ""}`}
    >
      {label && (
        <label
          className="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
          htmlFor={input}
        >
          {label}
        </label>
      )}
      {renderInput()}
    </div>
  );
};

export default InputComp;
