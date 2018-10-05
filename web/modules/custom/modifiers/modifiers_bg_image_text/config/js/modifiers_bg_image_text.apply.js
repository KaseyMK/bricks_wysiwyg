/**
 * @file
 * Initializes modification based on provided configuration.
 */

(function (ImageBgTextModifier) {

  'use strict';

  ImageBgTextModifier.apply = function (selector, media, config) {

    var element = document.querySelector(selector);
    if (!element) {
      return;
    }

    setHeight(element, media, config.height);

    window.addEventListener('resize', function () {
      setHeight(element, media, config.height);
    });

  };

  function setHeight(element, media, height) {

    if (window.matchMedia(media).matches) {
      element.style.minHeight = (window.innerHeight * parseFloat(height) / 100) + 'px';
    }
    else {
      element.style.minHeight = '';
    }

  }

})(window.ImageBgTextModifier = window.ImageBgTextModifier || {});
