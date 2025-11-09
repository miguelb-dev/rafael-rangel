document.addEventListener('DOMContentLoaded', function () {
    cargarEventos();
});

// Elementos de la página
const $pageTitle = document.querySelector("title");
const $mainTitle = document.querySelector(".main__title");
const $eventTitle = document.querySelector(".event__title");
const $eventDate = document.querySelector(".event__date");
const $eventDescription = document.querySelector(".event__description");

function cargarEventos() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        console.error('No se encontró el parámetro "id" en la URL');
        return;
    }

    fetch('../../scripts/get-event-view.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(eventos => {

        const evento = eventos[0]; // Accede al primer evento

        if (!evento) {
            $eventTitle.textContent = 'Evento no encontrado';
            $eventDescription.textContent = 'Lo sentimos, no se pudo cargar la información de este evento.';
            return;
        }

        // Extraer partes de la fecha manualmente para evitar desfase por zona horaria
        const [año, mes, dia] = evento.fecha_evento.split('-');
        const fecha = new Date(año, mes - 1, dia); // mes - 1 porque Date usa 0–11

        // Formatear fecha completa en español
        const opcionesFecha = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const fechaFormateada = fecha.toLocaleDateString('es-VE', opcionesFecha);

        // Capitalizar el mes manualmente para el <title>
        const mesCapitalizado = fecha.toLocaleDateString('es-VE', { month: 'long' })
            .replace(/\b\w/, c => c.toUpperCase()); // Primera letra en mayúscula
        const tituloFecha = `${mesCapitalizado} ${dia}, ${año}`;

        // Título de la pestaña con formato personalizado
        $pageTitle.textContent = tituloFecha;

        // Título principal
        $mainTitle.textContent = evento.titulo_evento;

        // Laborable o no laborable
        if (evento.laborable === 'Si') {
            $eventTitle.outerHTML = `<h2 class="event__title important-day">Día laborable</h2>`;
        } else {
            $eventTitle.outerHTML = `<h2 class="event__title non-working-day">Día no laborable</h2>`;
        }

        // Descripción
        $eventDescription.textContent = evento.descripcion_evento;

        // Fecha visible en el evento
        $eventDate.innerHTML = `<i class="fa-regular fa-calendar-days"></i> ${fechaFormateada}`;
    })
    .catch(error => {
        console.error('Error al cargar los datos del evento:', error);
    });
}
