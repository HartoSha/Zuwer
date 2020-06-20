const date = document.querySelector("#clock .date");
const weekday = document.querySelector("#clock .weekday");
const hour = document.querySelector("#clock .hour");
const minutes = document.querySelector("#clock .min");


function setCurrentDate() {
  date.innerHTML = dateFromPhp;

  weekday.innerHTML = getCurrentWeekDay();
}

function getCurrentWeekDay() {
  let days = [
    "Воскресенье",
    "Понедельник",
    "Вторник",
    "Среда",
    "Четверг",
    "Пятница",
    "Суббота",
  ];

  return days[new Date().getDay()];
}
setCurrentDate();

function currentTime() {
  let time = new Date();
  dateTotal = time.getHours();

  if(dateTotal < 10){
    hour.innerHTML = `0${dateTotal}:`;
  }
  else hour.innerHTML = `${dateTotal}:`;

  dateTotal = time.getMinutes();

  if (dateTotal < 10) {
    minutes.innerHTML = `0${dateTotal}`;
  } else minutes.innerHTML = `${dateTotal}`;
}
let timerId;

function clockStart() {
  timerId = setInterval(currentTime, 1000);

  currentTime();
}
clockStart();


let vid = document.getElementById("tik-tak");
let swtich = document.getElementById("buttonTikTak");

document.addEventListener("DOMContentLoaded", function() {
  vid.volume = 0;
  buttonTikTak.addEventListener("click", TurnOffOnVolume);
  function TurnOffOnVolume() {
    vid.play();
    swtich.classList.toggle("muted");
    if (swtich.classList.contains("muted")) vid.volume = 0;
    else vid.volume = 1;
  }
});
