document.addEventListener("DOMContentLoaded", () => {
    const authUser = document.querySelector('.authUser');
    const registerBtn = document.querySelector('.authUser__boton--registrar');
    const loginBtn = document.querySelector('.authUser__boton--ingresar');

    if (registerBtn && loginBtn) {
        registerBtn.addEventListener('click', () => {
            authUser.classList.add('active');
        });

        loginBtn.addEventListener('click', () => {
            authUser.classList.remove('active');
        });
    } else {
        console.error("No se encontraron los botones de registro o inicio de sesión.");
    }
});
