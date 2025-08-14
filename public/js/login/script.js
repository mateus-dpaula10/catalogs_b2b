document.addEventListener('DOMContentLoaded', function () {
    const btnViewPassword = document.getElementById('btnPassLogin');
    const inputPassword = document.getElementById('password');

    if (btnViewPassword) {
        btnViewPassword.addEventListener('click', function () {
            if (inputPassword.type === 'password') {
                inputPassword.type = 'text';
                btnViewPassword.classList.remove('bi-eye-fill');
                btnViewPassword.classList.add('bi-eye-slash-fill');
            } else {
                inputPassword.type = 'password';
                btnViewPassword.classList.remove('bi-eye-slash-fill');
                btnViewPassword.classList.add('bi-eye-fill');
            }
        });
    }
    
    // document.addEventListener('click', function (e) {
    //     if (e.target && e.target.id === 'btnPassLogin') {
    //         alert('olá');
    //     }
    // });
});