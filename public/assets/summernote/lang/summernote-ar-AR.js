/*!
 * Super simple wysiwyg editor v0.8.18
 * https://summernote.org
 *
 * Copyright 2013- Alan Hong. and other contributors
 * summernote may be freely distributed under the MIT license.
 */
(function webpackUniversalModuleDefinition(root, factory) {
  if (typeof exports === 'object' && typeof module === 'object')
    module.exports = factory();
  else if (typeof define === 'function' && define.amd)
    define([], factory);
  else {
    var a = factory();
    for (var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
  }
})(window, function() {
  return /******/ (function(modules) { // webpackBootstrap
    // The module cache
    var installedModules = {};

    // The require function
    function __webpack_require__(moduleId) {

      // Check if module is in cache
      if (installedModules[moduleId])
        return installedModules[moduleId].exports;

      // Create a new module (and put it into the cache)
      var module = installedModules[moduleId] = {
        i: moduleId,
        l: false,
        exports: {}
      };

      // Execute the module function
      modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

      // Flag the module as loaded
      module.l = true;

      // Return the exports of the module
      return module.exports;
    }

    //
