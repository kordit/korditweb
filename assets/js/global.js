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
document.addEventListener('DOMContentLoaded', function() {
  document.body.style.opacity = 0;
  window.setTimeout(function() {
    document.body.style.opacity = 1;
  }, 125);
  function handleLinkClick(e) {
    var destination = this.href;
    var isInternalLink = destination.startsWith(window.location.origin) || destination.startsWith('/');
    var isDownloadLink = this.hasAttribute('download');
    var isEmptyLink = destination.endsWith('#');
    if (!isInternalLink || isDownloadLink || isEmptyLink) {
      return;
    }

    e.preventDefault();
    document.body.classList.add('fade-out');
    // setTimeout(function() {
    window.location.href = destination;
    // }, 125);
  }

  var links = document.querySelectorAll('a');
  links.forEach(function(link) {
    link.addEventListener('click', handleLinkClick);
  });
});

