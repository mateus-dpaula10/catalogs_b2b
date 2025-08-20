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
})