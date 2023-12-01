/* eslint-disable no-unused-vars */
function initCta(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
initCta();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=cta", (el) => {
if(!!el[0].querySelector(".cta") && !el[0].querySelector(".cta").classList.contains("block-js-added")){
initCta(el[0]);
el[0].querySelector(".cta").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
