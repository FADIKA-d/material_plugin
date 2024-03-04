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
    pageLength: 5,
    paging: true,
    lengthMenu: [5, 10, 15, 20, { label: "All", value: -1 }],
    columnDefs: [
      {
        target: [0, 2, 3, 4, 5],
        searchable: false
      }
    ],
    columns: [
      {
        name: "id",
        data: "id",
      },
      {
        name: "name",
        data: "name",
      },
      {
        name: "quantity",
        data: "quantity",
      },
      {
        name: "priceBeforeTax",
        data: "priceBeforeTax",
      },
      {
        name: "priceIncVAT",
        data: "priceIncVAT",
      },
      {
        name: "createdAt",
        data: "createdAt",
      },
    ],
  });
});
