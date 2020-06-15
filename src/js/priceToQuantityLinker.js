'use strict'

const linkPriceAndQuantity = (quantityInput, priceOutput, initialPriceInput) => {
    const initialPrice = +initialPriceInput.innerHTML;
    quantityInput.addEventListener('change', () => {
        // Значение количества в допустимом диапазоне?
        if(quantityInput.value >= +quantityInput.min && quantityInput.value <= +quantityInput.max) {
            // Устанавливаем посчитанную цену
            priceOutput.innerHTML = (quantityInput.value * initialPrice).toFixed(2);
        }
        else {
            // Иначе сбрасываем цену и количество
            priceOutput.innerHTML = initialPrice;
            quantityInput.value = 1;
        }
    });
}


// Соединяем цену с количеством на странице товара
linkPriceAndQuantity (
    document.querySelector('.quantity__value'),
    document.querySelector('.price__value'),
    document.querySelector('.price__value'),
);


