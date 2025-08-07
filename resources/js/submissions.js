window.Swal = Swal;

window.updateStatus = function (selectElement) {
    const status = selectElement.value;
    const submissionId = selectElement.dataset.id;

    fetch(`/submissions/${submissionId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal memperbarui status.');
        return response.json();
    })
    .then(data => {
        console.log(data.message);
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    })
    .catch(error => {
        console.error('Error detail:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: error.message || 'Terjadi kesalahan saat mengubah status.',
        });
    });
};

