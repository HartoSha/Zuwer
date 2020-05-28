'use strict'

const modalWidnow = document.querySelector('.purchase-modal');
const quantityInputNotModal = document.querySelector('.quantity__value');

const modalShowBtn = document.querySelector('.buy').addEventListener('click', (e) => {
    // Отменяем обновление страницы
    e.preventDefault();
    toggleModal();
    getQuantity(quantityInputNotModal);
});

const background = document.querySelector('.purchase-modal .background').addEventListener('click', () => {
    toggleModal();
})

const toggleModal = () => {
    modalWidnow.classList.toggle('purchase-modal_hidden');
}



