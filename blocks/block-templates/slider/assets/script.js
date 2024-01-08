/* eslint-disable no-unused-vars */
/* eslint-disable no-shadow */
/* eslint-disable no-undef */
function initSlider(element = document) {
const slider = element.querySelectorAll( ".splide_slider" );
slider.forEach(item => {
const slider = new Splide(item, {
rewind:true,
type:"loop",
perPage:"2",
padding: { left: 10, right: 20 },
});
slider.mount();
});
};

document.addEventListener("DOMContentLoaded", () => {
initSlider();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=slider", (el) => {
if(!!el[0].querySelector(".slider") && !el[0].querySelector(".slider").classList.contains("block-js-added")){
initSlider(el[0]);
el[0].querySelector(".slider").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
