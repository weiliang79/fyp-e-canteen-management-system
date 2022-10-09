// Bootstrap
import './bootstrap';

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
