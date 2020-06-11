let inputLeft = document.getElementById("input-left");
let inputRight = document.getElementById("input-right");

let thumbLeft = document.querySelector(".slider > .thumb.left");
let thumbRight = document.querySelector(".slider > .thumb.right");
let range = document.querySelector(".slider > .range");

let minPrice = document.querySelector(".minPrice");
let maxPrice = document.querySelector(".maxPrice");

// debugger;

function setLeftValue() {
	let _this = inputLeft;
	let max = parseInt(_this.max);

	_this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value) - 1);

	let percent = _this.value / max;

	minPrice.value = Math.floor(max * percent);

	thumbLeft.style.left = (percent * 100) + "%";
	range.style.left = (percent * 100) + "%";
}
setLeftValue();

function setRightValue() {
	let _this = inputRight;
	let max = parseInt(_this.max);

	_this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value) + 1);

	let percent = _this.value  / max;

	maxPrice.value = Math.floor(max * percent);

	thumbRight.style.right = (100 - (percent * 100)) + "%";
	range.style.right = (100 - (percent * 100)) + "%";
}
setRightValue();

inputLeft.addEventListener("input", setLeftValue);
inputRight.addEventListener("input", setRightValue);