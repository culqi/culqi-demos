export const Loader = (show) => {
    if (!show) {
        const loader = document.querySelector('.overlay-class');
        if (loader) loader.remove();
        return;
    }

    const loaderHTML = `
    <div class="overlay-class">
      <div class="spinner-container">
        <div class="spinner-content">
          <img
            src="./images/culqiLogo-animation.svg"
            alt="Logo animado"
          />
        </div>
      </div>
    </div>
  `;

    document.body.insertAdjacentHTML('beforeend', loaderHTML);
};