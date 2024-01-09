/* eslint-disable no-unused-vars */
function init__After_hero(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
init__After_hero();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=after-hero", (el) => {
if(!!el[0].querySelector(".after-hero") && !el[0].querySelector(".after-hero").classList.contains("block-js-added")){
init__After_hero(el[0]);
el[0].querySelector(".after-hero").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
