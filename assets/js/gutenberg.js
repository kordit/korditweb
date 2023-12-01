const linkTags = document.querySelectorAll('link[rel="stylesheet"]:not([id])');
linkTags.forEach((tag) => {
  const href = tag.getAttribute('href');
  if (href.indexOf('load-styles.php') > -1) {
    const link = document.createElement('link');
    link.media = 'all';
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = href.replace('wp-reset-editor-styles,', '');
    link.onload = function loadTag() {
      // eslint-disable-next-line no-param-reassign
      tag.disabled = true;
    };
    tag.after(link);
  }
});
