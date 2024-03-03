import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

import "./styles/app.css";

// Initialisation des tooltips bootstrap
(function () {
  "use strict";
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
})();

$(document).ready(function () {
  $("#material-list").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/2.0.1/i18n/fr-FR.json",
    },
    ajax: url_path,
    processing: true,
    serverSide: true,
    columns: [
      //  "id", "name", "quantity", "createdAt", "priceBeforeTax", "priceIncVAT"
      { data: "id" },
      { data: "name" },
      { data: "quantity" },
      { data: "priceBeforeTax" },
      { data: "priceIncVAT" },
      { data: "createdAt" },
    ],
  });
});
