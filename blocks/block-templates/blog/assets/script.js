/* eslint-disable no-unused-vars */
function init__Blog(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
init__Blog();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=blog", (el) => {
if(!!el[0].querySelector(".blog") && !el[0].querySelector(".blog").classList.contains("block-js-added")){
init__Blog(el[0]);
el[0].querySelector(".blog").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
