/* eslint-disable no-unused-vars */
function init__O_nas(element = document) {

};

document.addEventListener("DOMContentLoaded", () => {
    init__O_nas();
});

/* -- Admin JS START -- */
if (window.acf) {
    window.acf.addAction("render_block_preview/type=o-nas", (el) => {
        if (!!el[0].querySelector(".o-nas") && !el[0].querySelector(".o-nas").classList.contains("block-js-added")) {
            init__O_nas(el[0]);
            el[0].querySelector(".o-nas").classList.add("block-js-added");
        }
    });
}
/* -- Admin JS END -- */
