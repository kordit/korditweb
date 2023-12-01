const hamburger = document.querySelector('.hamburger');
const header = document.querySelector('header');
const headerNav = document.querySelector('.header-nav');
const mobileNav = document.querySelector('.mobile-nav');

document.addEventListener('DOMContentLoaded', () => {});

hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('active');
  header?.classList.toggle('active');
  headerNav?.classList.toggle('active');
  mobileNav?.classList.toggle('active');
});

document.addEventListener('DOMContentLoaded', function() {
    // Wybieramy wszystkie linki wewnątrz .mobile-nav, które zawierają #
  var links = document.querySelectorAll('.mobile-nav a[href*="#"]');

  links.forEach(function(link) {
    link.addEventListener('click', function() {
      var mobileNav = document.querySelector('.mobile-nav');
      if (mobileNav.classList.contains('active')) {
        mobileNav.classList.remove('active');
      }
    });
  });
});
