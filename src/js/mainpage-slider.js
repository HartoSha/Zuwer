'use strict';

const START_INDEX = 1;                                          //Стартовый индекс
const TRANSITION_TIME = 0.8;                                    //Время смещения в секундах
const FLIP_TIME = 3;
                                             
const slider      = document.getElementById("slider");    
const leftButton  = slider.querySelector(".slider__leftButton"); 
const contentRoot = slider.querySelector(".slider__content");     //Находим корневой элемент для контента (тут хранятся сами новости) 
const rightButton = slider.querySelector(".slider__rightButton");   
const items       = contentRoot.querySelectorAll(".slider__item"); 
let currentOffset = START_INDEX;


let centering_var = calcCenteringVar();                                     // переменная центровки - дополнительное смещение в %. необходима для выравнивания элементов.
console.log(`отступ слева для центровки: ${centering_var} %`);

initMove();                                                              // Сдвигаем элементы на стартовую позицию

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
        item.style.transform = `translateX(${-(100 * currentOffset - centering_var)}%)`;   // Двигаем элементы на 100% их ширины * currentOffset (отрицательное значение, тк.к currentOffset положительный)
        // console.log("Все элементы смещены на = " + item.style.transform);
    });   
    
}

function initMove(){ // Если это первое смещение, то смещаем без анимации
    items.forEach(item => {
        item.style.transform = `translateX(${-(100 * currentOffset - centering_var)}%)`;    // Двигаем элементы на 100% их ширины * currentOffset
        // console.log("Стартовое смещение = " + item.style.transform);
        setTimeout(function(){ // Ставим стиль с transition'ом для элементов через определенное время, чтобы при загрузке стр. они не двигались 
            item.style.transition = `transform ${TRANSITION_TIME}s`; // transform, чтобы заданное время влияло только на смену слайдов, а не на всё (не на наведение на элементы)
        },TRANSITION_TIME * 100);
    }); 
}

function checkOffset(){
    console.log("Проверяем offset: " + currentOffset);

    let itemsInRow = 1; // Math.floor(contentRoot.offsetWidth / items[0].offsetWidth) Находим кол-во видимых item'ов в строке делая ширину контейнера на ширину 1 item'a и округляя до целого
    if (currentOffset < 0) { // Если смещение меньше 0, то ставим смещение на конец сладера (на последние n видимых элиментов)
        currentOffset = items.length - itemsInRow;
    }
    else if(currentOffset > (items.length - itemsInRow)){
        currentOffset = 0;
    }
    // console.log("itemsInRow = " + itemsInRow);
}

function calcCenteringVar() { // заметки расчетов https://i.imgur.com/1MoBiKB.png
    const diffPx = contentRoot.offsetWidth - items[0].offsetWidth; // Разница в px между контейнером и 1 элементом
    // console.log(diffPx); 
    const offsetToCenter = ((diffPx / 2) / items[0].offsetWidth) * 100; // для центровки делим разницу на 2 и находим ее "количество" в элементе. Умножаем на 100 для получения процентов
    return offsetToCenter;
}

window.onresize = () => {
    centering_var = calcCenteringVar();
    initMove();
    // console.log("resize");
}

setInterval(function(){
    currentOffset++;
    moveItems();
}, FLIP_TIME * 1000);