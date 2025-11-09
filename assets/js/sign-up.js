//* Elementos de la página

// Ventana de Diálogo
const $dialogWindow = document.querySelector('.dialog-window')
const $studentButton = document.querySelector('#student-button')
const $professorButton = document.querySelector('#professor-button')

// Mensaje para el Docente
const $professorMessage = document.querySelector('.professor-message')

// Formulario
const $formSignUp = document.querySelector('.sign-up')
const $name = document.querySelector("#first-name")
const $lastname = document.querySelector("#last-name")
const $birthDate = document.querySelector("#birthdate")
const $cedula = document.querySelector("#cedula")
const $telephone = document.querySelector("#telephone")
const $fatherTelephone = document.querySelector("#father-telephone")




//* Filtros

// Evita que el campo de apellidos reciba números y carácteres no permitidos
$name.addEventListener('input', () => {
    $name.value = $name.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
});

// Evita que el campo de apellidos reciba números y carácteres no permitidos
$lastname.addEventListener('input', () => {
    $lastname.value = $lastname.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
});

// Evita que la fecha de nacimiento sea superior al día actual
const hoy = new Date().toISOString().split('T')[0]; // Formato YYYY-MM-DD
$birthDate.max = hoy;

// Elimina todo lo que no sea dígito en el campo de cedula
$cedula.addEventListener('input', () => {
    $cedula.value = $cedula.value.replace(/\D/g, '');
});

// Elimina todo lo que no sea dígito en el campo de teléfono
$telephone.addEventListener('input', () => {
    $telephone.value = $telephone.value.replace(/\D/g, '');
});

// Elimina todo lo que no sea dígito en el campo del teléfono del representante
$fatherTelephone.addEventListener('input', () => {
    $fatherTelephone.value = $fatherTelephone.value.replace(/\D/g, '');
});




// * Lógica de la ventana de diálogo

// Mostrar el formulario de registro para el estudiante
$studentButton.addEventListener('click', ()=>{
    $dialogWindow.style.display = 'none';
    $professorMessage.style.display = 'none';
    $formSignUp.style.display = 'block'
})

// Mostrar el mensaje para el docente
$professorButton.addEventListener('click', ()=>{
    $dialogWindow.style.display = 'none';
    $formSignUp.style.display = 'none';
    $professorMessage.style.display = 'block';
})




//* Sigue mostrando el formulario de registro cuando hay un mensaje de error
const $errorMessage = document.querySelector('.error-message')
if ($errorMessage) {
    let textoMensaje = $errorMessage.textContent
    if (textoMensaje.includes('Ya existe un estudiante con esa <strong>cédula</strong> y <strong>correo</strong>.') || textoMensaje.includes('Ya existe un estudiante con esa <strong>cédula</strong>.') || textoMensaje.includes('Ya existe un estudiante con ese <strong>correo</strong>.') || textoMensaje.includes('Error inesperado al registrar: ') || textoMensaje.includes('La combinación de año y sección no existe.') || textoMensaje.includes('Faltan campos obligatorios.')) {
        console.log('Error en el formulario')
    }else {
        $dialogWindow.style.display = 'none';
        $professorMessage.style.display = 'none';
        $formSignUp.style.display = 'block';
    }
}