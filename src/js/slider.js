'use strict';

const START_INDEX = 1;                                          //Стартовый индекс
const TRANSITION_TIME = 0.8;                                    //Время смещения в секундах

                                             
let slider      = document.getElementById("slider");    
let leftButton  = slider.querySelector(".slider__leftButton"); 
let contentRoot = slider.querySelector(".slider__content");     //Находим корневой элемент для контента (тут хранятся сами новости) 
let rightButton = slider.querySelector(".slider__rightButton");   
let items       = contentRoot.querySelectorAll(".slider__item"); 
let currentOffset = START_INDEX;

initMove();                                                     // Сдвигаем элементы на стартовую позицию

rightButton.addEventListener("click", function(){
    currentOffset++;
    moveItems();
});

leftButton.addEventListener("click", function(){
    currentOffset--;
    moveItems();
});

function moveItems(){
    checkOffset();                     
    items.forEach(item => {
        item.style.transform = `translateX(${-(100 * currentOffset)}%)`;   // Двигаем элементы на 100% их ширины * currentOffset (отрицательное значение, тк.к currentOffset положительный)
        console.log("Все элементы смещены на = " + item.style.transform);
    });   
    
}

function initMove(){ // Если это первое смещение, то смещаем без анимации
    items.forEach(item => {
        item.style.transform = `translateX(${-(100 * currentOffset)}%)`;    // Двигаем элементы на 100% их ширины * currentOffset
        console.log("Стартовое смещение = " + item.style.transform);
        setTimeout(function(){ // Ставим стиль с transition'ом для элементов через определенное время, чтобы при загрузке стр. они не двигались 
            item.style.transition = `transform ${TRANSITION_TIME}s`; // transform, чтобы заданное время влияло только на смену слайдов, а не на всё (не на наведение на элементы)
        },TRANSITION_TIME * 100);
    }); 
}

function checkOffset(){
    console.log("Проверяем offset: " + currentOffset);

    let itemsInRow = Math.round(contentRoot.offsetWidth / items[0].offsetWidth); // Находим кол-во item'ов в строке делая ширину контейнера на ширину 1 item'a и округляя до целого
    if (currentOffset < 0) { // Если смещение меньше 0, то ставим смещение на конец сладера (на последние n видимых элиментов)
        currentOffset = items.length - itemsInRow;
    }
    else if(currentOffset > (items.length - itemsInRow)){
        currentOffset = 0;
    }
    console.log("itemsInRow = " + itemsInRow);
}