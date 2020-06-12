const priceFrom = document.querySelectorAll(".filter-criteria_range .filter-criteria__option-from");
const priceTo = document.querySelectorAll(".filter-criteria_range .filter-criteria__option-to");
const priceContainer = document.querySelectorAll(".filter-criteria_range .filter-criteria__option.slider");
const offsets = [5, 1];

// debugger;
class Slider{
	constructor(fromInput, toInput, inputsContainer, minOffset){
		
		
		this.fromInput = fromInput;
		this.toInput = toInput;

		//создание dom-элементов 
		this.sliderContainer = document.createElement("div");
		this.sliderContainer.className = "range-slider";
		inputsContainer.appendChild(this.sliderContainer);

		this.rangeSlider = document.createElement("div");
		this.rangeSlider.className = "multi-range-slider";
		this.sliderContainer.appendChild(this.rangeSlider);

		this.inputLeft = document.createElement("input");
		this.inputLeft.className = "input-left";
		this.inputLeft.max = fromInput.max;
		this.inputLeft.min = fromInput.min;
		this.inputLeft.value = fromInput.value;
		this.inputLeft.type = "range";
		this.rangeSlider.appendChild(this.inputLeft);

		this.inputRight = document.createElement("input");
		this.inputRight.className = "input-right";
		this.inputRight.max = toInput.max;
		this.inputRight.min = toInput.min;
		this.inputRight.value = toInput.value;
		this.inputRight.type = "range";
		this.rangeSlider.appendChild(this.inputRight);

		this.sliderView = document.createElement("div");
		this.sliderView.className = "slider";
		this.rangeSlider.appendChild(this.sliderView);

		this.track = document.createElement("div");
		this.track.className = "track";
		this.sliderView.appendChild(this.track);

		this.range = document.createElement("div");
		this.range.className = "range";
		this.sliderView.appendChild(this.range);

		this.minOffset = minOffset; // Минимальная разница значений ползунков 
		this.setLeftValue();
		this.setRightValue();
		this.inputLeft.addEventListener("input", this.setLeftValue.bind(this));
		this.inputRight.addEventListener("input", this.setRightValue.bind(this));


		// const iL = this.inputLeft;
		// const leftInput = this.fromInput;
		// const leftMove = this.setLeftValue.bind(this);
		this.fromInput.addEventListener("change", this.syncIRangeToINumberLeft.bind(this));
		this.toInput.addEventListener("change", this.syncIRangeToINumberRight.bind(this));
		// this.toInput.addEventListener("change", this.setRightValue.bind(this));
	}
	
	setLeftValue() {
		const max = parseInt(this.inputLeft.max);
		const min = parseInt(this.inputLeft.min);
	
		// Запрещает левому ползунку сдвигаться дальше правого минус смещение
		this.inputLeft.value = Math.min(parseInt(this.inputLeft.value), parseInt(this.inputRight.value) - this.minOffset);
	
		// percent - процентное соотношение пройденой дистанции ползунка (слева) к общей доступной 
		const percent = (((this.inputLeft.value - min) / (max - min))) * 100; // max - min доступное смещение
		
		// console.log(`min: ${min}`);
		// console.log(`max: ${max}`);
		// console.log(`il value: ${this.inputLeft.value}`);
		// console.log(`percent (max/li value): ${percent}`);

		// Меняем числовое поле ввода в зависимости от текущего пройденного расстояния ползунком (прибавляем min, чтобы значения были не меньше минимального). // max - min доступное смещение
		this.fromInput.value =  min + Math.round((max - min) * percent / 100);
		this.range.style.left = percent + "%";
	}
	
	setRightValue() {
		const max = parseInt(this.inputRight.max);
		const min = parseInt(this.inputRight.min);
	
		this.inputRight.value = Math.max(parseInt(this.inputRight.value), parseInt(this.inputLeft.value) + this.minOffset);

		const percent = ((this.inputRight.value - min) / (max - min)) * 100;
	
		this.toInput.value =  min + Math.round((max - min) * percent / 100);
		this.range.style.right = (100 - percent) + "%";
	}

	syncIRangeToINumberLeft() {
		// Синхронизирует значение в цифровом input'e с его отображением на ползунке
		const INumberLeft = this.fromInput;
		const IRangeLeft = this.inputLeft;

		// Валидация введенных значений на соответствие допустимому диапазону
		const inputValue = parseInt(INumberLeft.value);
		const minPossible = parseInt(INumberLeft.min);
		const maxPossible = parseInt(INumberLeft.max);
		const isValueInRange = inputValue >= minPossible && inputValue <= maxPossible;
		let finalValue = minPossible;
		if(isValueInRange) {
			finalValue = inputValue;
		}

		// Перемещаяем левый ползунок
		INumberLeft.value = finalValue;
		IRangeLeft.value = finalValue;
		this.setLeftValue();
	}
	syncIRangeToINumberRight() {
		// Синхронизирует значение в цифровом input'e с его отображением на ползунке
		const INumberRight = this.toInput;
		const IRangeRight = this.inputRight;

		// Валидация введенных значений на соответствие допустимому диапазону
		const inputValue = parseInt(INumberRight.value);
		const minPossible = parseInt(INumberRight.min);
		const maxPossible = parseInt(INumberRight.max);
		const isValueInRange = inputValue >= minPossible && inputValue <= maxPossible;
		let finalValue = maxPossible;
		if(isValueInRange) {
			finalValue = inputValue;
		}

		// Перемещаяем правый ползунок
		INumberRight.value = finalValue;
		IRangeRight.value = finalValue;
		this.setRightValue();
	}
}

priceContainer.forEach((item, i)=>{
	new Slider(priceFrom[i], priceTo[i], item, offsets[i]);
});
