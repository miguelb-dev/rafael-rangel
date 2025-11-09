document.addEventListener('DOMContentLoaded', function() {
    cargarEventos();
});

// Detecta el usuario para redirigir correctamente
const currentPage = window.location.pathname.split('/').pop();
    if (currentPage === 'calendar-docente.php') {
        eventRoot = 'event-docente.php'
        mainRoot = '../../scripts/get-events.php'
    }
    else if (currentPage === 'calendar-admin.php') {
        eventRoot = 'event-admin.php'
        mainRoot = '../../scripts/get-events.php'
    } else if (currentPage == 'calendar-estudiante.php') {
        eventRoot = 'event-estudiante.php'
        mainRoot = '../../scripts/get-events.php'
    } else {
        eventRoot = 'event-view.php'
        mainRoot = '../../scripts/get-events.php'
    }

function cargarEventos() {
    fetch(mainRoot)
        .then(response => response.json())
        .then(eventos => {

            // Recibir las fechas de los eventos
            eventos.forEach(evento => {

                const fecha = new Date(evento.fecha_evento);

                // Separa la fecha para poder utilizarla
                const dia = fecha.getDate() + 1;    // Día del mes (1–31), se suma 1 para que funcione correctamente
                const mes = fecha.getMonth() + 1;   // Mes (0–11), se suma 1 para que sea 1–12
                const año = fecha.getFullYear();    // Año completo (ej. 2025)
                


                // Selecciona todos los meses del calendario
                const $months = document.querySelectorAll('.month')

                // Recorre cada uno de los meses del calendario
                $months.forEach(month => {
                    const monthNumber = month.getAttribute('id')    // El numero del mes (1-12)

                    // Compara el mes del calendario con el mes de la publicacion
                    if (monthNumber == mes) {

                        // Selecciona la lista ordenada de elementos (cada elemento de la grilla del mes)
                        const $AllDays = document.querySelectorAll('.month__days')
                        const $days = $AllDays[mes - 1] // Son todos los dias del mes seleccionado


                        // Cuenta todos los días el mes del calendario
                        for (let hijo of $days.children) {

                            // Compara el dia del calendario con el dia de la publicacion
                            if (hijo.textContent == dia ) {
                                
                                // Verifica si es laborable o no
                                if (evento.laborable == 'Si' ) {
                                    hijo.outerHTML = `<li class="important-day"><a class="link-date" href="${eventRoot}?id=${evento.id_calendario}">${dia}</a></li>`
                                } else {
                                    hijo.outerHTML = `<li class="non-working-day"><a class="link-date" href="${eventRoot}?id=${evento.id_calendario}">${dia}</a></li>`
                                }
                            }
                        }
                    }
                })
            });

            
        })
        .catch(error => {
            console.error('Error al cargar los eventos:', error);
        });
}