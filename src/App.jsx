import React from 'react'
import { OnlyCharge, WithCard } from './pages'
import Sidebar from './components/Sidebar'
import { BrowserRouter, Route, Routes } from "react-router-dom";


const App = () => {

  return (
    <BrowserRouter>
      <div className='w-full h-full'>
        <div
          className="max-w-7xl mt-10 mx-auto w-full flex flex-col sm:flex-row flex-grow overflow-hidden"
        >
          <Sidebar />
          <div
            className="w-full p-6 px-6 grid grid-cols-1 gap-4 place-content-center place-items-center"
          >
            <h1 className="my-6 text-xl font-bold text-center">PYTHON DEMO</h1>
            <h2 className="text-xl font-bold text-purple-800">
              CULQI - CUSTOM CHECKOUT
            </h2>

            <Routes>
              <Route path="/" element={<OnlyCharge />} />
              <Route path="/with-card" element={<WithCard />} />
            </Routes>

            <div className="mt-20">
              <button
                className="bg-blue-500 hover:bg-blue-700 px-5 py-4 leading-5 rounded-full font-semibold text-white text-2xl"
                id="reset"
              >
                Reiniciar
              </button>
            </div>
          </div>

        </div></div>
    </BrowserRouter>
  )
}

export default App;
