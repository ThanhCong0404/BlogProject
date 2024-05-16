(() => {
  'use strict'

  // Check if Bootstrap tooltip is available
  if (typeof bootstrap === 'undefined' || !bootstrap.Tooltip) {
    console.warn('Bootstrap Tooltip not found, tooltips will not be initialized');
    return;
  }

  // Get all elements with data-bs-toggle="tooltip"
  const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');

  // Initialize Bootstrap Tooltip for each element
  tooltipElements.forEach(tooltipElement => {
    new bootstrap.Tooltip(tooltipElement);
  });
})();
