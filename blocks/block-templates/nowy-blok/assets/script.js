/* eslint-disable no-unused-vars */
/* eslint-disable no-shadow */
/* eslint-disable no-undef */
function initNowy_blok(element = document) {
const nowy_blok = element.querySelectorAll( ".splide_slider" );
nowy_blok.forEach(item => {
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
initNowy_blok();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=nowy-blok", (el) => {
if(!!el[0].querySelector(".nowy-blok") && !el[0].querySelector(".nowy-blok").classList.contains("block-js-added")){
initNowy_blok(el[0]);
el[0].querySelector(".nowy-blok").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
