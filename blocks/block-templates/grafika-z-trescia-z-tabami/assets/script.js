/* eslint-disable no-unused-vars */
function initgrafika_z_trescia_z_tabami(element = document) {
    const navItems = element.querySelectorAll(".grafika-z-trescia-z-tabami .single-navi");
    const tabs = element.querySelectorAll(".grafika-z-trescia-z-tabami .single-tab");

    if (navItems.length > 0 && tabs.length > 0) {
        navItems[0].classList.add('active');
        tabs[0].classList.add('active');
    }

    navItems.forEach(function (nav) {
        nav.addEventListener('click', function () {
            navItems.forEach(function (navItem) {
                navItem.classList.remove('active');
            });

            this.classList.add('active');
            var targetId = this.getAttribute('data-template');
            tabs.forEach(function (tab) {
                tab.classList.remove('active');
            });

            var targetTab = element.getElementById(targetId);
            if (targetTab) {
                targetTab.classList.add('active');
            }
        });
    });
};

document.addEventListener("DOMContentLoaded", () => {
    initgrafika_z_trescia_z_tabami();
});

/* -- Admin JS START -- */
if (window.acf) {
    window.acf.addAction("render_block_preview/type=grafika-z-trescia-z-tabami", (el) => {
        if (!!el[0].querySelector(".grafika-z-trescia-z-tabami") && !el[0].querySelector(".grafika-z-trescia-z-tabami").classList.contains("block-js-added")) {
            initgrafika_z_trescia_z_tabami(el[0]);
            el[0].querySelector(".grafika-z-trescia-z-tabami").classList.add("block-js-added");
        }
    });
}
/* -- Admin JS END -- */
