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

// $(document).ready(function () {
//   $("#material-list").DataTable({
//     responsive: {
//       details: {
//         display: DataTable.Responsive.display.modal({
//           header: function (row) {
//             console.log(row);
//             var data = row.data();
//             return "Details for " + data[0] + " " + data[1];
//           },
//         }),
//         renderer: DataTable.Responsive.renderer.tableAll({
//           tableClass: "table",
//         }),
//       },
//     },
//     layout: {
//       top2End: {
//         buttons: ["pdfHtml5"],
//       },
//       bottomNEnd: {
//         buttons: [
//           {
//             action: function (e) {
//               e.stopPropagation();
//               this.popover("<div>I love popovers!</div>", {
//                 popoverTitle: "Hello world",
//               });
//             },
//           },
//         ],
//       },
//     },
//     language: {
//       url: "//cdn.datatables.net/plug-ins/2.0.1/i18n/fr-FR.json",
//     },
//     // buttons : true,
//     ajax: url_path,
//     processing: true,
//     serverSide: true,
//     pageLength: 5,
//     paging: true,
//     lengthMenu: [5, 10, 15, 20, { label: "All", value: -1 }],
//     columnDefs: [
//       { target: 1, responsivePriority: 1 },
//       {
//         target: [0, 2, 3, 4, 5],
//         searchable: false,
//       },
//       {
//         target: -1,
//         orderable: false,
//       },
//       {
//         target: -1,
//         visible: true,
//       },
//       {
//         target: -1,
//         data: "id",
//         //   render:
//         // function (data) {
//         //   let link = '<a href="/material/update/'+ data +'">Modifier</a>'
//         //   return link;

//         // },
//         //   if( table.rows( { selected: true } ).count() == table.data().count()){
//         //     table.rows().deselect();
//         // }
//       },
//       {
//         target: 5,
//         render: function (data, type) {
//           let created_at = new Date(data);
//           return formatDate(created_at);
//         },
//       },
//       {
//         className: "dtr-control",
//         orderable: true,
//         targets: 0,
//       },
//     ],
//     columns: [
//       {
//         name: "id",
//         data: "id",
//       },
//       {
//         name: "name",
//         data: "name",
//         responsivePriority: 1,
//       },
//       {
//         name: "quantity",
//         data: "quantity",
//       },
//       {
//         name: "priceBeforeTax",
//         data: "priceBeforeTax",
//       },
//       {
//         name: "priceIncVAT",
//         data: "priceIncVAT",
//       },
//       {
//         name: "createdAt",
//         data: "createdAt",
//       },
//       {
//         name: "modifier",
//         data: "id",
//         // render: function (data) {
//         //   // let link = '<a href="/material/update/'+ data +'">Modifier</a>'
//         //   // return [link, "a"];
//         //   let details = '<a href="/material/update/' + data + '">Voir</a>';
//         //   let update = '<a href="/material/update/' + data + '">Modifier</a>';
//         //   let decrement =
//         //     '<a href="/material/update/' + data + '">Décrémenter</a>';
//         //   return [details, update, decrement];
//         // },
//       },
//     ],
//   });
// });
	//datatable.buttons('.update').disable();
//   $('update').on('click', function(){
//     console.log('row');
//    var tr = $(this).closest('button.dt-button.update');
//    console.log('tr',tr),
//     var row = datatable.row['tr'],
//     console.log(row);
//  })
// /**
//  * Permet de convertir un objet date en chaine de caractère au format local FR
//  * @param {Date} date
//  * @returns string
//  */
// function formatDate(date) {
//   // On ajoute un 0 devant lorsque la valeur de la date est inférieure à 10
//   let day = date.getDay() < 10 ? `0${date.getDay()}` : date.getDay();
//   // On ajoute un 0 devant lorsque la valeur de la date est inférieure à 10. On ajoute 1 car les mois sont numéro de 0 à 11 en JS
//   let month =
//     date.getMonth() + 1 < 10 ? `0${date.getMonth() + 1}` : date.getMonth() + 1;
//   let year = date.getFullYear();
//   return `${day}/${month}/${year}`;
// }
// function decrement(data) {
//   var quantity = data.quantity;
//   if (quantity > 1) {
//     var newQuantity = quantity - 1;
//   }
//   return newQuantity;
// }
