const year = document.querySelector("#clock .year");
const month = document.querySelector("#clock .month");
const day = document.querySelector("#clock .day");
const weekday = document.querySelector("#clock .weekday");
const hour = document.querySelector("#clock .hour");
const minutes = document.querySelector("#clock .min");

let date = new Date();
let dateTotal

function currentDate() {
  dateTotal = date.getFullYear();
  year.innerHTML = `${dateTotal}-`;

  dateTotal = date.getMonth();
  if (dateTotal < 10) {
    month.innerHTML = `0${dateTotal}-`;
  } else month.innerHTML = `0${dateTotal}-`;

  dateTotal = date.getDate();
  if (dateTotal < 10) {
    day.innerHTML = `0${dateTotal}`;
  } else day.innerHTML = dateTotal;

  dateTotal = getWeekDay(date);
  weekday.innerHTML = dateTotal;
}

function getWeekDay(date) {
  let days = [
    "Воскресенье",
    "Понедельник",
    "Вторник",
    "Среда",
    "Четверг",
    "Пятница",
    "Суббота",
  ];

  return days[date.getDay()];
}
currentDate();

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
    swtich.classList.toggle("muted");
    if (swtich.classList.contains("muted")) vid.volume = 0;
    else vid.volume = 1;
  }
});

