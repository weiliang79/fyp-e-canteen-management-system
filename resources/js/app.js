// Bootstrap
import './bootstrap';

// jQuery
import jQuery from 'jquery';
window.$ = jQuery;

// DataTables
import DataTable from 'datatables.net-bs5';
DataTable(window, window.$);

//sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;

//sweetalert2 bootstrap theme
window.SwalWithBootstrap = Swal.mixin({
      customClass: {
            confirmButton: 'btn btn-primary mx-3',
            cancelButton: 'btn btn-danger mx-3',
      },
      buttonsStyling: false,
});

// flatpickr
import flatpickr from 'flatpickr';
window.flatpickr = flatpickr;

// stripe js
import {loadStripe} from "@stripe/stripe-js";
window.loadStripe = loadStripe;

//dateFormat
import dateFormat from 'dateformat';
window.dateFormat = dateFormat;

window.addEventListener('DOMContentLoaded', event => {

    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            //localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    $('.dataTable').DataTable({
        language: {
            paginate: {
                previous: '<i class="fa-solid fa-angle-left"></i>',
                next: '<i class="fa-solid fa-angle-right"></i>',
            }
        }
    });

    $('.dataTable-cart').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        language: {
            emptyTable: 'No product has added into cart.',
        }
    });

    flatpickr('.timepicker', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'h:i K',
    });

})
