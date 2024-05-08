import React, { useEffect } from "react";
import { Link, useLocation } from "react-router-dom";

const SideBar = () => {

  const location = useLocation();

  const showClass = "border-l-2 border-white dark:bg-gray-700";

  useEffect(() => {
  }, [location]);

  return (
    <aside className="w-64" aria-label="Sidebar">
      <div className="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800 h-full pt-20">
        <a
          href="https://docs.culqi.com/es/documentacion/"
          className="flex items-center pl-2.5 mb-5"
        >
          <img
            src="https://culqi.com/assets/images/brand/brandCulqi-white.svg"
            className="mr-3 h-6 sm:h-7"
            alt="Culqi Logo"
          />
        </a>
        <ul className="space-y-2">
          <li>
            <div
              className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white w-full justify-between"
            >
              <span className="ml-3 text-left whitespace-nowrap">Cargos</span>
              <svg
                className="w-6 h-6"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fillRule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clipRule="evenodd"
                ></path>
              </svg>
            </div>
            <div>
              <ul className="py-2 pl-8 space-y-2">
                <li>
                  <Link
                    to="/"
                    data-mode-menu="only-charge"
                    className={`flex items-start p-2 w-full text-base font-normal text-left text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 ${location.pathname === '/' ? showClass : ''}`}
                  >
                    Solo Cargo
                  </Link>
                </li>
                <li>
                  <Link
                    to="with-card"
                    data-mode-menu="with-card"
                    className={`flex items-start p-2 w-full text-base font-normal text-left text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 ${location.pathname === '/with-card' ? showClass : ''}`}
                  >
                    Con creación tarjeta
                  </Link>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </aside>
  );
}

export default SideBar;