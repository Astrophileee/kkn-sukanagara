
window.Swal = Swal;

document.addEventListener('DOMContentLoaded', function () {
    const commentForm = document.getElementById('comment-form');
    const commentText = document.getElementById('comment-text');
    const commentPhoto = document.getElementById('comment-photo');
    const preview = document.getElementById('image-preview');
    const previewContainer = document.getElementById('image-preview-container');
    const commentList = document.querySelector('.mb-28');

        window.handleSubmitComment = function () {
        const form = document.getElementById('comment-form');
        const textarea = document.getElementById('comment-text');
        const formData = new FormData(form);
        const forumId = document.querySelector('input[name="forum_id"]').value;
        const max = 500;
        const contentLength = textarea.value.length;

        if (contentLength > max) {
            Swal.fire({
                icon: 'error',
                title: 'Komentar terlalu panjang!',
                text: 'Komentar kamu melebihi batas maksimal (500 karakter).',
                confirmButtonText: 'Back',
                confirmButtonColor: '#000',
            });
            return;
        }

        if (!textarea.value.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Komentar kosong!',
                text: 'Silakan tulis komentar terlebih dahulu.',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#000',
            });
            return;
        }

        console.log('Isi komentar:', textarea.value);

        fetch(`${window.location.origin}/forums/${forumId}/comments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData,
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                console.error(`HTTP error! Status: ${res.status}`);
                console.error(text);

                let errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';

                try {
                    const data = JSON.parse(text);
                    errorMsg = data.message || errorMsg;
                } catch (e) {
                    console.warn('Gagal parse error JSON:', e);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengirim komentar',
                    text: errorMsg,
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#000',
                });

                throw new Error(errorMsg);
            }

            return res.json();
        })

        .then(data => {
            commentText.value = '';
            commentPhoto.value = '';
            preview.src = '';
            previewContainer.classList.add('hidden');
            document.getElementById('char-remaining').textContent = '500';

            const temp = document.createElement('div');
            temp.innerHTML = data.html;
            commentList.appendChild(temp.firstElementChild);
        })
        .catch(error => {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal mengirim komentar',
                text: 'Terjadi kesalahan. Silakan coba lagi.',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#000',
            });
        });
    };
});

