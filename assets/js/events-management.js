// - un único handler para $save (evita mensajes/peticiones duplicadas)
// - lectura segura de valores del DOM al momento de enviar

// * Elementos de la página

// Botones de acción
const $addButton = document.querySelector('#add');
const $editButton = document.querySelector('#edit');
const $deleteButton = document.querySelector('#delete');

// Formulario
const $form = document.querySelector('.form')
const $formTitle = document.querySelector('.form__title');
const $selectWrapper = document.querySelector('.select-wrapper');
const $date = document.querySelector("#date");
const $nonWorkingDay = document.querySelector('#non-working-day');
const $importantDay = document.querySelector('#important-day');
const $description = document.querySelector('#description');

// Botones de estado
const $save = document.querySelector("#save");
const $cancel = document.querySelector("#cancel");

// Variable global para almacenar eventos
let eventos = [];

// Helper: limpiar campos básicos (no toca el wrapper dinámico)
function limpiarCamposBasicos() {
    const $maybeTitle = document.querySelector('#title');
    if ($maybeTitle && $maybeTitle.tagName.toLowerCase() === 'input') $maybeTitle.value = '';
    // si existe title-edit, lo limpia también
    const $titleEdit = document.querySelector('#title-edit');
    if ($titleEdit) $titleEdit.value = '';
    $date.value = '';
    $importantDay.checked = false;
    $nonWorkingDay.checked = false;
    $description.value = '';
}

// Helper: establecer modo visual del botón save (texto)
function setModeText(text) {
    $save.textContent = text;
}

// --- CREAR ---
function addSeccion() {
    $formTitle.textContent = "Crear evento";
    $addButton.classList.add('user-selection');
    $editButton.classList.remove('user-selection');
    $deleteButton.classList.remove('user-selection');

    $save.classList.remove('erase') // Le cambia el color al botón principal


    // input para título (id 'title' como en tu versión original)
    let html = `
        <label for="title">Título</label>
        <input id="title" class="input__field" type="text" required>
    `;
    $selectWrapper.innerHTML = html;

    limpiarCamposBasicos();

    // habilitar campos
    const $titleInput = document.querySelector('#title');
    if ($titleInput) $titleInput.disabled = false;
    $date.disabled = false;
    $importantDay.disabled = false;
    $nonWorkingDay.disabled = false;
    $description.disabled = false;

    setModeText('Crear');
    // quitar cualquier data-id
    $save.removeAttribute('data-id');
}

// --- EDITAR ---
function editSeccion() {
    $formTitle.textContent = "Editar evento";
    $editButton.classList.add('user-selection');
    $addButton.classList.remove('user-selection');
    $deleteButton.classList.remove('user-selection');

    $save.classList.remove('erase') // Le cambia el color al botón principal

    limpiarCamposBasicos();

    // pedir eventos
    fetch('obtener-evento.php')
        .then(res => {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(data => {
            eventos = Array.isArray(data) ? data : [];

            // select (id 'title') y input editable (id 'title-edit', oculto hasta seleccionar)
            let html = `
                <label for="title">Selecciona el evento</label>
                <select id="title" class="input__field">
                    <option value="">Selecciona un evento</option>
                    ${eventos.map(ev => `<option value="${ev.id_calendario}">${ev.titulo_evento}</option>`).join('')}
                </select>

                <label for="title-edit" id="label-title-edit" style="display:none;">Título editable</label>
                <input id="title-edit" class="input__field" type="text" style="display:none;">
            `;
            $selectWrapper.innerHTML = html;

            // referencias dinámicas
            const $select = document.querySelector('#title');
            const $titleEdit = document.querySelector('#title-edit');
            const $labelTitleEdit = document.querySelector('#label-title-edit');

            // habilitar campos
            $date.disabled = false;
            $importantDay.disabled = false;
            $nonWorkingDay.disabled = false;
            $description.disabled = false;

            setModeText('Guardar');
            $save.removeAttribute('data-id');

            // change del select: llena campos y muestra input editable
            $select.addEventListener('change', function () {
                const id = $select.value;
                if (!id) {
                    // ocultar input editable y limpiar
                    if ($titleEdit) $titleEdit.value = '';
                    if ($titleEdit) $titleEdit.style.display = 'none';
                    if ($labelTitleEdit) $labelTitleEdit.style.display = 'none';
                    $date.value = '';
                    $importantDay.checked = false;
                    $nonWorkingDay.checked = false;
                    $description.value = '';
                    $save.removeAttribute('data-id');
                    return;
                }

                const evento = eventos.find(ev => String(ev.id_calendario) === String(id));
                if (!evento) {
                    alert('Evento no encontrado');
                    return;
                }

                // mostrar input editable con título actual
                if ($titleEdit) $titleEdit.style.display = '';
                if ($labelTitleEdit) $labelTitleEdit.style.display = '';
                if ($titleEdit) $titleEdit.value = evento.titulo_evento || '';

                // llenar demás campos
                $date.value = evento.fecha_evento || '';
                $importantDay.checked = (evento.laborable === 'Si');
                $nonWorkingDay.checked = (evento.laborable === 'No');
                $description.value = evento.descripcion_evento || '';

                // marcar id para uso si se desea (no obligatorio para el handler único)
                $save.setAttribute('data-id', evento.id_calendario);

                // cancelar restaura valores originales
                $cancel.onclick = function () {
                    if ($titleEdit) $titleEdit.value = evento.titulo_evento || '';
                    $date.value = evento.fecha_evento || '';
                    $importantDay.checked = (evento.laborable === 'Si');
                    $nonWorkingDay.checked = (evento.laborable === 'No');
                    $description.value = evento.descripcion_evento || '';
                };
            });
        })
        .catch(err => {
            console.error('Error al obtener eventos', err);
            alert('No se pudieron cargar los eventos');
        });
}

// --- ELIMINAR ---
function deleteSeccion() {
    $formTitle.textContent = "Eliminar evento";
    $deleteButton.classList.add('user-selection');
    $addButton.classList.remove('user-selection');
    $editButton.classList.remove('user-selection');

    $save.classList.add('erase') // Le cambia el color al botón principal

    limpiarCamposBasicos();

    fetch('obtener-evento.php')
        .then(res => {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(data => {
            eventos = Array.isArray(data) ? data : [];

            let html = `
                <label for="title">Selecciona el evento</label>
                <select id="title" class="input__field">
                    <option value="">Selecciona un evento</option>
                    ${eventos.map(ev => `<option value="${ev.id_calendario}">${ev.titulo_evento}</option>`).join('')}
                </select>
            `;
            $selectWrapper.innerHTML = html;

            const $select = document.querySelector('#title');
            $select.addEventListener('change', () => {
                const evento = eventos.find(ev => ev.id_calendario == $select.value);
                if (evento) {
                    $date.value = evento.fecha_evento;
                    $importantDay.checked = evento.laborable === 'Si';
                    $nonWorkingDay.checked = evento.laborable === 'No';
                    $description.value = evento.descripcion_evento;
                }
            });

            $date.disabled = true;
            $importantDay.disabled = true;
            $nonWorkingDay.disabled = true;
            $description.disabled = true;
        })
        .catch(err => {
            console.error('Error al obtener eventos', err);
            alert('No se pudieron cargar los eventos');
        });

    setModeText('Eliminar');
    $save.removeAttribute('data-id');
}


// --- Único handler para $save (leer DOM en el momento del click) ---
$save.addEventListener('click', function (e) {
    e.preventDefault();
    const modo = String($save.textContent).trim();

    // Obtener el elemento con id "title" (puede ser input o select según modo)
    const $titleElem = document.querySelector('#title');

    if (modo === "Crear") {
        const titulo = $titleElem && $titleElem.tagName.toLowerCase() === 'input' ? $titleElem.value.trim() : '';
        const fecha = $date.value;
        const descripcion = $description.value.trim();
        const laborable = $importantDay.checked ? "Si" : "No";

        if (titulo === "" || fecha === "") {
            alert("Por favor completa el título y la fecha.");
            return;
        }

        const formData = new FormData();
        formData.append("titulo_evento", titulo);
        formData.append("fecha_evento", fecha);
        formData.append("descripcion_evento", descripcion);
        formData.append("laborable", laborable);

        fetch("agregar-evento.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                alert("Evento creado correctamente.");
                // limpiar campos
                if ($titleElem && $titleElem.tagName.toLowerCase() === 'input') $titleElem.value = '';
                $date.value = '';
                $importantDay.checked = false;
                $nonWorkingDay.checked = false;
                $description.value = '';
            } else {
                alert("Error: " + (data && data.error ? data.error : 'Sin detalle'));
            }
        })
        .catch(() => {
            alert("Error de conexión con el servidor.");
        });

    } else if (modo === "Guardar") {
        // Para editar leemos el select actual y el input editable (title-edit)
        const $selectNow = document.querySelector('#title');
        const selectedId = $selectNow ? $selectNow.value : null;

        if (!selectedId) {
            alert("Selecciona un evento para editar.");
            return;
        }

        const $titleEdit = document.querySelector('#title-edit');
        const tituloEditable = $titleEdit ? $titleEdit.value.trim() : '';
        if (!tituloEditable) {
            alert("El título es obligatorio");
            return;
        }

        const fecha = $date.value;
        const descripcion = $description.value.trim();
        const laborable = $importantDay.checked ? "Si" : "No";

        const formData = new FormData();
        formData.append("id_calendario", selectedId);
        formData.append("titulo_evento", tituloEditable);
        formData.append("fecha_evento", fecha);
        formData.append("descripcion_evento", descripcion);
        formData.append("laborable", laborable);

        fetch("editar-evento.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data && (data.success || data.message)) {
                alert("Evento actualizado correctamente.");
                // refrescar modo editar para mostrar cambios
                editSeccion();
            } else {
                alert("Error: " + (data && data.error ? data.error : 'Sin detalle'));
            }
        })
        .catch(() => {
            alert("Error de conexión con el servidor.");
        });

    } else if (modo === "Eliminar") {
        const $selectNow = document.querySelector('#title');
        const id = $selectNow ? $selectNow.value : null;
        if (!id) {
            alert("Selecciona un evento para eliminar.");
            return;
        }

        const formData = new FormData();
        formData.append("id_calendario", id);

        fetch("eliminar-evento.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                alert("Evento eliminado correctamente.");
                // refrescar modo eliminar para mostrar cambios
                deleteSeccion()
            } else {
                alert("Error: " + (data && data.error ? data.error : 'Sin detalle'));
            }
        })
        .catch(() => {
            alert("Error de conexión con el servidor.");
        });
    }
});

// Conectar botones de acción
$addButton.addEventListener('click', addSeccion);
$editButton.addEventListener('click', editSeccion);
$deleteButton.addEventListener('click', deleteSeccion);

// Inicializar en modo crear por defecto
addSeccion();
