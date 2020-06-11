const priceFrom = document.querySelectorAll(".filter-criteria_range .filter-criteria__option-from");
const priceTo = document.querySelectorAll(".filter-criteria_range .filter-criteria__option-to");
const priceContainer = document.querySelectorAll(".filter-criteria_range .filter-criteria__option.slider");

// debugger;
class Slider{

	constructor(fromInput, toInput, inputsContainer){
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

		this.thumbLeft = document.createElement("div");
		this.thumbLeft.className = "thumb";
		this.sliderView.appendChild(this.thumbLeft);
		this.thumbRight = document.createElement("div");
		this.thumbRight.className = "thumb";
		this.sliderView.appendChild(this.thumbRight);

		this.setLeftValue();
		this.setRightValue();
		this.inputLeft.addEventListener("input", this.setLeftValue.bind(this));
		this.inputRight.addEventListener("input", this.setRightValue.bind(this));
	}
	
	setLeftValue() {
		const max = parseInt(this.inputLeft.max);
	
		this.inputLeft.value = Math.min(parseInt(this.inputLeft.value), parseInt(this.inputRight.value) - 5);
	
		const percent = this.inputLeft.value / max;
	
		this.fromInput.value = Math.floor(max * percent) + parseInt(this.fromInput.min);
	
		this.thumbLeft.style.left = (percent * 100) + "%";
		this.range.style.left = (percent * 100) + "%";
	}
	
	setRightValue() {
		const max = parseInt(this.inputRight.max);
	
		this.inputRight.value = Math.max(parseInt(this.inputRight.value), parseInt(this.inputLeft.value) + 5);
	
		const percent = this.inputRight.value  / max;
	
		this.toInput.value = Math.floor(max * percent);
	
		this.thumbRight.style.right = (100 - (percent * 100)) + "%";
		this.range.style.right = (100 - (percent * 100)) + "%";
	}
}
priceContainer.forEach((item, i)=>{
	new Slider(priceFrom[i], priceTo[i], item);
});
