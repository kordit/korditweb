/* eslint-disable no-unused-vars */
function initOferta(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
initOferta();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=oferta", (el) => {
if(!!el[0].querySelector(".oferta") && !el[0].querySelector(".oferta").classList.contains("block-js-added")){
initOferta(el[0]);
el[0].querySelector(".oferta").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
