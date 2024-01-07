/* eslint-disable no-unused-vars */
function init__Blok_cpt(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
init__Blok_cpt();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=blok-cpt", (el) => {
if(!!el[0].querySelector(".blok-cpt") && !el[0].querySelector(".blok-cpt").classList.contains("block-js-added")){
init__Blok_cpt(el[0]);
el[0].querySelector(".blok-cpt").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
