document.addEventListener('DOMContentLoaded', function () {
    const aside = document.querySelector('aside');
    const btnToggle = document.getElementById('toggle_button');
    const main = document.querySelector('main');

    btnToggle.addEventListener('click', function () {
        aside.classList.toggle('opened');
        main.classList.toggle('opened');
    });

    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['bold', 'italic', 'underline', 'bulletedList', 'numberedList', 'link']
        })
        .catch(error => console.error(error));
})