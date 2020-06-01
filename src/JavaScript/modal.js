document.addEventListener("DOMContentLoaded", function () {
  const changeLogin = document.getElementById("registr-btn");
  const changeReg = document.getElementById("login-btn");
  const modalLogin = document.querySelector(".modal-log");
  const modalRegistration = document.querySelector(".modal-registration");
  const loginBtn = document.querySelector(".modal-header .login-btn");
  const RegBtn = document.querySelector(
    ".modal-registration .registration-btn"
  );
  const openModal = document.querySelector(".open-modal");
  const modal = document.querySelector(".modal-log-reg");
  const background = document.querySelector(".modal-log-reg .background");

  changeLogin.addEventListener("click", switchWindow);
  changeReg.addEventListener("click", switchWindow);
  openModal.addEventListener("click", function () {
    modal.classList.toggle("invisible");
  });
  background.addEventListener("click", function () {
    modal.classList.toggle("invisible");
  });

  function switchWindow() {
    modalLogin.classList.toggle("invisible");
    loginBtn.classList.toggle("selected-btn");
    modalRegistration.classList.toggle("invisible");
    RegBtn.classList.toggle("selected-btn");
  }
});