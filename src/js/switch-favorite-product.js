'use strict'
const likeBtn = document.getElementById("like-checkbox");
const request = new XMLHttpRequest();
const url = "/catalog/switchFavorite/";

likeBtn.addEventListener("click", () => {
    request.open("POST", url, true);
    // В заголовке говорим что тип передаваемых данных закодирован. 
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Отправляем запрос. 
    request.send();
});