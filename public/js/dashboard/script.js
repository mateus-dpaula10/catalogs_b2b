document.addEventListener('DOMContentLoaded', function () {
    const aside = document.querySelector('aside');
    const btnToggle = document.getElementById('toggle_button');

    btnToggle.addEventListener('click', function () {
        if (btnToggle.innerText === '☰') {
            btnToggle.innerText = 'X'
        } else {
            btnToggle.innerText = '☰'
        }
        aside.classList.toggle('opened');
    });

    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['bold', 'italic', 'underline', 'bulletedList', 'numberedList', 'link']
        })
        .catch(error => console.error(error));
})