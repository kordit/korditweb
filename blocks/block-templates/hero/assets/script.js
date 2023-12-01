/* eslint-disable no-unused-vars */
/* eslint-disable no-shadow */
/* eslint-disable no-undef */
function initHero(element = document) {
	const hero = element.querySelectorAll( ".splide_slider" );
	hero.forEach(item => {
		const slider = new Splide(item, {
			rewind:true,
			type:"loop",
			arrows:false,
			pagination:false,
			navigation:false
		});
		slider.mount();
	});
};

document.addEventListener("DOMContentLoaded", () => {
	initHero();
});

/* -- Admin JS START -- */
if(window.acf){
	window.acf.addAction("render_block_preview/type=hero", (el) => {
		if(!!el[0].querySelector(".hero") && !el[0].querySelector(".hero").classList.contains("block-js-added")){
			initHero(el[0]);
			el[0].querySelector(".hero").classList.add("block-js-added");
		}
	});
}
/* -- Admin JS END -- */
