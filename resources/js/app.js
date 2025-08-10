import $ from 'jquery';
window.$ = window.jQuery = $;
// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import AOS from 'aos';
import 'aos/dist/aos.css';


AOS.init({
    duration: 1000,
    once: false,
    offset: 120,
});

// init Swiper:
var swiper = new Swiper(".mySwiper", {
        modules: [Navigation, Pagination],
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      slidesPerView: 1,
      loop: true,
      pagination: {
        el: '.swiper-pagination',
  },
});


import './bootstrap';
import Alpine from 'alpinejs';

import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import DataTable from 'datatables.net-dt';
import Swal from 'sweetalert2';


window.Alpine = Alpine;
Alpine.start();

window.Swal = Swal;

window.showToast = function (type, message) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
};


$(document).ready(function () {
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        const type = flashMessage.dataset.type;
        const message = flashMessage.dataset.message;

        if (type && message) {
            window.showToast(type, message);
        }
    }else {
        console.log('Flash message not found.');
    }
    $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: false,
        language: {
            searchPlaceholder: 'Cari...',
            search: '',
        },
    });
    $('#informationsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: false,
        language: {
            searchPlaceholder: 'Cari...',
            search: '',
        },    columnDefs: [
        {
            targets: 2,
            width: '600px',
        },
        {
            targets: 3,
            width: '300px',
        },
    ]
    });

    $('#apbnsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: false,
        language: {
            searchPlaceholder: 'Cari...',
            search: '',
        },
    });

    $('#penduduksTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: false,
        language: {
            searchPlaceholder: 'Cari...',
            search: '',
        },
    });

});
