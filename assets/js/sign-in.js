// TODO: Validar el formulario

// Elementos de la página
const $formMessage = document.querySelector(".error-message")


// Oculta los mensajes del formulario luego de 5 segundos
if ($formMessage) {
    if ($formMessage.textContent === "Registro exitoso.") {
        $formMessage.classList.replace('error-message', 'success-message') // Cambia el estilo si viene de un registro exitoso
    }
    setTimeout(() => {
        $formMessage.style.display = "none";
    }, 5000);
}