/* eslint-disable no-unused-vars */
function initCennik(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
initCennik();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=cennik", (el) => {
if(!!el[0].querySelector(".cennik") && !el[0].querySelector(".cennik").classList.contains("block-js-added")){
initCennik(el[0]);
el[0].querySelector(".cennik").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
