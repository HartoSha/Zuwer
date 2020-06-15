// Соединяемя цену с количеством в модальном окне покупки
linkPriceAndQuantity(
    document.querySelector('.purchase-form-modal__quantity'),
    document.querySelector('.purchase-form-modal__price-value'),
    document.querySelector('.purchase-form-modal__price-value'),
);

'use strict'

const modalWidnow = document.querySelector('.purchase-modal');

const quantityInputNotModal = document.querySelector('.quantity__value');
const quantityModal = document.querySelector('.purchase-form-modal__quantity');

const priceOutputNotModal = document.querySelector('.price__value');
const priceOutputModal = document.querySelector('.purchase-form-modal__price-value');

// При загрузке страницы модальное окно получает значение цены
priceOutputModal.innerHTML = priceOutputNotModal.innerHTML;

const modalShowBtn = document.querySelector('.toggle-modal-buy').addEventListener('click', (e) => {
    // Отменяем обновление страницы
    e.preventDefault();
    toggleModal();

    // При открытии модального окна обновляем занчения в нем
    quantityModal.value = quantityInputNotModal.value;
    priceOutputModal.innerHTML = priceOutputNotModal.innerHTML;

});

const background = document.querySelector('.purchase-modal .background').addEventListener('click', () => {

    // При закрытии модального окна обновляем значения на странице
    quantityInputNotModal.value = quantityModal.value;
    priceOutputNotModal.innerHTML = priceOutputModal.innerHTML;
    toggleModal();
})

const toggleModal = () => {
    modalWidnow.classList.toggle('purchase-modal_hidden');
}



