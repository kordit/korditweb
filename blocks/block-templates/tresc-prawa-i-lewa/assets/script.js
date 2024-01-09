/* eslint-disable no-unused-vars */
function init__Tresc_prawa_i_lewa(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
init__Tresc_prawa_i_lewa();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=tresc-prawa-i-lewa", (el) => {
if(!!el[0].querySelector(".tresc-prawa-i-lewa") && !el[0].querySelector(".tresc-prawa-i-lewa").classList.contains("block-js-added")){
init__Tresc_prawa_i_lewa(el[0]);
el[0].querySelector(".tresc-prawa-i-lewa").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
