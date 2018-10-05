/**
 * @file
 * Initializes modification based on provided configuration.
 */

(function (ParallaxBgTextModifier) {

  'use strict';

  ParallaxBgTextModifier.apply = function (selector, media, config) {

    var element = document.querySelector(selector);
    if (!element) {
      return;
    }

    setHeight(element, media, config.height);

    var pluginConfig = {
      speed: (typeof config.speed !== 'undefined' ? config.speed : 0.5)
    };

    toggle(element, media, pluginConfig);

    window.addEventListener('resize', function () {
      toggle(element, media, pluginConfig);
      setHeight(element, media, config.height);
    });

  };

  function toggle(element, media, pluginConfig) {

    if (window.matchMedia(media).matches) {
      jarallax(element, pluginConfig);
    }
    else {
      jarallax(element, 'destroy');
    }

  }

  function setHeight(element, media, height) {

    if (window.matchMedia(media).matches) {
      element.style.minHeight = (window.innerHeight * parseFloat(height) / 100) + 'px';
    }
    else {
      element.style.minHeight = '';
    }

  }

})(window.ParallaxBgTextModifier = window.ParallaxBgTextModifier || {});
