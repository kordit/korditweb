/* eslint-disable no-unused-vars */
function init__Jakis_dodatkowy_blok(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
init__Jakis_dodatkowy_blok();
});

/* -- Admin JS START -- */
if(window.acf){
window.acf.addAction("render_block_preview/type=jakis-dodatkowy-blok", (el) => {
if(!!el[0].querySelector(".jakis-dodatkowy-blok") && !el[0].querySelector(".jakis-dodatkowy-blok").classList.contains("block-js-added")){
init__Jakis_dodatkowy_blok(el[0]);
el[0].querySelector(".jakis-dodatkowy-blok").classList.add("block-js-added");
}
});
}
/* -- Admin JS END -- */
