/* eslint-disable no-unused-vars */
function initFaq(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
initFaq();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=faq", (el) => {
if(!!el[0].querySelector(".faq") && !el[0].querySelector(".faq").classList.contains("block-js-added")){
initFaq(el[0]);
el[0].querySelector(".faq").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
