document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".modal-log-reg-container")


  const loginBtn = document.querySelector(".modal-header .login-btn");
  const RegBtn = document.querySelector(".modal-header .registration-btn");

loginBtn.addEventListener("click", (e)=> {
  e.preventDefault();
  if(!container.classList.contains("js-inLogin")) {
    container.classList.add("js-inLogin");
    container.classList.remove("js-inReg");
  }
});
RegBtn.addEventListener("click", (e)=> {
  e.preventDefault();
  if(!container.classList.contains("js-inReg")) {
    container.classList.add("js-inReg");
    container.classList.remove("js-inLogin");
  }
});
  // changeLogin.addEventListener("click", switchWindow);
  // changeReg.addEventListener("click", switchWindow);

  const modal = document.querySelector(".modal-log-reg");
  const modalTogglers = document.querySelectorAll(".toggle-modal-log-reg");

  modalTogglers.forEach((item) => {
    item.addEventListener("click", (e) => {  //TODO: пофиксить краш скрипта при залогиненом пользователе
      e.preventDefault();
      modal.classList.toggle("invisible");
    });
  })
});