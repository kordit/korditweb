const hamburger = document.querySelector('.hamburger');
const header = document.querySelector('header');
const headerNav = document.querySelector('.header-nav');
const mobileNav = document.querySelector('.mobile-nav');

document.addEventListener('DOMContentLoaded', () => { });

hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('active');
  header?.classList.toggle('active');
  headerNav?.classList.toggle('active');
  mobileNav?.classList.toggle('active');
});

document.addEventListener('DOMContentLoaded', function () {
  var linksmobile = document.querySelectorAll('.mobile-nav a[href*="#"]');

  linksmobile.forEach(function (link) {
    link.addEventListener('click', function () {
      var mobileNav = document.querySelector('.mobile-nav');
      if (mobileNav.classList.contains('active')) {
        mobileNav.classList.remove('active');
      }
    });
  });

  const links = document.querySelectorAll('.header-nav a');

  links.forEach(function (link) {
    const text = link.innerHTML.trim();
    link.setAttribute('title', text);
  });


});

