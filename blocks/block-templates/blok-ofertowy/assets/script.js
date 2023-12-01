/* eslint-disable no-unused-vars */
function initBlok_ofertowy(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
initBlok_ofertowy();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=blok-ofertowy", (el) => {
if(!!el[0].querySelector(".blok-ofertowy") && !el[0].querySelector(".blok-ofertowy").classList.contains("block-js-added")){
initBlok_ofertowy(el[0]);
el[0].querySelector(".blok-ofertowy").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
