document.addEventListener('DOMContentLoaded', function () {
    
    //* Elementos generales del DOM
    const addButton = document.querySelector('.action-buttons-wrapper .add');
    const editButton = document.querySelector('.action-buttons-wrapper .edit');
    const eliminarBtn = document.querySelector('.action-buttons-wrapper .delete');
    const createForm = document.getElementById('create-form-wrapper');
    const editForm = document.getElementById('edit-form-wrapper');
    const crudWrapper = document.getElementById('crud-wrapper');
    const cancelCreateBtn = document.getElementById('cancel-create');
    const cancelEditBtn = document.getElementById('cancel-edit');
    const guardarBtn = document.querySelector('.status-buttons-wrapper .save');
    const cancelarBtn = document.querySelector('.status-buttons-wrapper .cancel');
    const statusWrapper = document.querySelector('.status-buttons-wrapper');
    const seleccionCols = document.querySelectorAll('.seleccion-col');
    const radioCells = document.querySelectorAll('.seleccion-edicion');

    //* Campos de los formularios
    const $cedula = document.querySelector("#cedula")
    const $name = document.querySelector("#nombre")
    const $lastname = document.querySelector("#apellido")
    const $birthDate = document.querySelector("#fecha_nacimiento")
    const $telephone = document.querySelector("#telefono_personal")
    

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


    

    //* Oculta el mensaje de error de los formularios cuando el mensaje está vacío
    const $errorMessage = document.querySelector('.error-message')
    if ($errorMessage) {
        let textoMensaje = $errorMessage.textContent
        if (textoMensaje.includes('Ya existe un docente con esa cédula.') || textoMensaje.includes('Ya existe un docente con ese correo.') || textoMensaje.includes('Ocurrió un error al registrar el docente.') || textoMensaje.includes('La cédula debe tener entre 7 y 8 dígitos numéricos.') || textoMensaje.includes('La fecha de nacimiento no puede ser mayor a la fecha actual.')) {
            console.log('Error en el formulario')
        }else {
            $errorMessage.style.display = 'none'
        }
    }


    
    //* Lógica para Registrar Docentes
    
    // Mostrar formulario de registro
    addButton.addEventListener('click', () => {
        editButton.classList.remove('user-selection');
        eliminarBtn.classList.remove('user-selection');
        
        crudWrapper.style.display = 'none';
        editForm.style.display = 'none';
        createForm.style.display = 'block';
        
        // Limpiar formulario solo si no venimos de un error
        if (!window.location.search.includes('error=')) {
            createForm.querySelectorAll('input, select').forEach(el => {
                if (el.type === 'checkbox' || el.type === 'radio') {
                    el.checked = false;
                } else {
                    el.value = '';
                }
            });
        }
        
        // Si hay un error en la URL, hacer scroll al formulario
        if (window.location.search.includes('error=')) {
            window.scrollTo({ top: createForm.offsetTop, behavior: 'smooth' });
        }
    });
    
    // Referencia al botón que agrega una nueva asignatura en el formulario de agregar
    const $createAsignatureButton = document.querySelector('#new-asignature');

    // Contador para indexar cada bloque de asignatura correctamente (form agregar)
    let asignaturaIndexCrear = 1; // Empieza en 1 porque el primer bloque ya está en el HTML como [0]

    $createAsignatureButton.addEventListener('click', function () {
        // Contenedor donde se insertan los bloques de asignatura
        const $asignaturasContainer = document.querySelector('.asignaturas-container');

        // HTML del nuevo bloque de asignatura con índice dinámico
        const $newAsignature = `
        <div class='asignatura'>
            <div class='materia'>
                <label>Asignatura
                    <!-- El name usa asignaturas[índice][id_asignatura] para agrupar correctamente -->
                    <select name='asignaturas[${asignaturaIndexCrear}][id_asignatura]' required>
                        <option value=''>-- Asignatura --</option>
                        <option value='1'>Matemática</option>
                        <option value='2'>Física</option>
                        <option value='3'>Inglés</option>
                        <option value='4'>Biología</option>
                        <option value='5'>Arte y Patrimonio</option>
                        <option value='6'>Química</option>
                        <option value='7'>Orientación y Convivencia</option>
                        <option value='8'>Formación para la Ciudadanía</option>
                        <option value='9'>Historia y Geografía</option>
                        <option value='10'>Grupo de Interés</option>
                        <option value='11'>Castellano y Literatura</option>
                        <option value='12'>Educación Física</option>
                    </select>
                </label>
            </div>

            <div class='anio-seccion'>
                <label>Año y Sección
                    <div class='checkbox-scroll-grid edit-anios'>
                        <!-- Cada checkbox usa el mismo índice para agrupar con su asignatura -->
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='1'> 1° A</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='2'> 1° B</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='3'> 1° C</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='4'> 2° A</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='5'> 2° B</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='6'> 2° C</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='7'> 3° A</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='8'> 3° B</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='9'> 3° C</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='10'> 4° A</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='11'> 4° B</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='12'> 4° C</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='13'> 5° A</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='14'> 5° B</label>
                        <label><input type='checkbox' name='asignaturas[${asignaturaIndexCrear}][id_anio_seccion][]' value='15'> 5° C</label>
                    </div>
                </label>
            </div>
            <button type="button" class="remove-button">✖</button>

        </div>`;

        // Insertar el nuevo bloque en el contenedor
        $asignaturasContainer.insertAdjacentHTML('beforeend', $newAsignature);

        // Incrementar el índice para el próximo bloque
        asignaturaIndexCrear++;




        // Elimina la asignatura seleccionada

        // Referencia a todas las asignaturas del formulario
        const $removeButtons = document.querySelectorAll('.remove-button')
        $removeButtons.forEach(item => {
            item.addEventListener('click', ()=>{
                item.parentElement.outerHTML = ''
            })
        })
    });


    // Cancelar el formulario de registro
    if (cancelCreateBtn) {
        cancelCreateBtn.addEventListener('click', () => {
            location.reload()
        });
    }




    //* Lógica para Eliminar Docentes
    eliminarBtn.addEventListener('click', () => {
        eliminarBtn.classList.add('user-selection'); // Marca la función activa
        editButton.classList.remove('user-selection');

        radioCells.forEach(cell => cell.style.display = 'none');
        seleccionCols.forEach(col => col.style.display = 'table-cell');
        statusWrapper.style.display = 'flex';
        guardarBtn.style.display = 'block'; // Aparece el botón de guardar
    });



    //* Lógica para los Botones de Estado
    // Eliminar registros
        const $formulario = document.querySelector('#form-table');

        $formulario.addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario

            // Referencia a todos los registros seleccionados
            const seleccionados = document.querySelectorAll('input[name="seleccion[]"]:checked');

            if (seleccionados.length === 0) {
                alert("No seleccionaste ningún registro.");
            } else if (confirm("ADVERTENCIA: ¿Estás seguro de que quieres eliminar TODA la información del profesor/es seleccionado/s?")) {
                document.getElementById('form-table').submit(); // Envía el formulario
            }
        });
        


    // Cancelar eliminación o edicion
    cancelarBtn.addEventListener('click', () => {
        eliminarBtn.classList.remove('user-selection');
        editButton.classList.remove('user-selection');

        // Ocultar checkboxes y limpiar selección
        seleccionCols.forEach(col => {
            col.style.display = 'none';
            const checkbox = col.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = false;
        });

        // Ocultar radios y limpiar selección
        radioCells.forEach(cell => {
            cell.style.display = 'none';
            const radio = cell.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });

        // Ocultar barra de estado
        statusWrapper.style.display = 'none';
    });





    //* Lógica para Editar Registros de Docentes
    editButton.addEventListener('click', () => {
        editButton.classList.add('user-selection');
        eliminarBtn.classList.remove('user-selection');

        guardarBtn.style.display = 'none'; // Oculta el botón de guardar

        seleccionCols.forEach(col => {
            col.style.display = 'none';
            const checkbox = col.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = false;
        });

        statusWrapper.style.display = 'flex';
        radioCells.forEach(cell => cell.style.display = 'table-cell');

        // Limpiar formulario solo si no venimos de un error de edición
        if (!window.location.search.includes('error=') || !window.location.search.includes('form=editar')) {
            document.getElementById('edit-id').value = '';
            document.getElementById('edit-cedula').value = '';
            document.getElementById('edit-nombre').value = '';
            document.getElementById('edit-apellido').value = '';
            document.getElementById('edit-email').value = '';
            document.getElementById('edit-telefono_personal').value = '';
            document.getElementById('edit-direccion').value = '';
            document.getElementById('edit-genero').value = '';
            document.getElementById('edit-fecha_nacimiento').value = '';
        }
        
        // Si hay un error de edición en la URL, hacer scroll al formulario
        if (window.location.search.includes('error=') && window.location.search.includes('form=editar')) {
            // Esperar un poco para que el formulario se muestre antes del scroll
            setTimeout(() => {
                window.scrollTo({ top: editForm.offsetTop, behavior: 'smooth' });
            }, 100);
        }
    });

    // Cargar datos al seleccionar el docente
    document.querySelector('tbody').addEventListener('change', function (e) {
        if (e.target && e.target.name === 'docente_editar') {
            const fila = e.target.closest('tr');
            const btn = fila.querySelector('.edit-btn');
            if (!btn) return;

            document.getElementById('edit-id').value = btn.dataset.id;
            document.getElementById('edit-cedula').value = btn.dataset.cedula;
            document.getElementById('edit-nombre').value = btn.dataset.nombre;
            document.getElementById('edit-apellido').value = btn.dataset.apellido;
            document.getElementById('edit-email').value = btn.dataset.email;
            document.getElementById('edit-telefono_personal').value = btn.dataset.telefono;
            document.getElementById('edit-direccion').value = btn.dataset.direccion;
            document.getElementById('edit-genero').value = btn.dataset.genero;
            document.getElementById('edit-fecha_nacimiento').value = btn.dataset.fecha;

            // Limitar fecha de edicion
            const fechaEditInput = document.getElementById('edit-fecha_nacimiento');
            if (fechaEditInput) {
                const hoy = new Date().toISOString().split('T')[0];
                fechaEditInput.max = hoy;
            }

            // Reconstruir bloques de asignatura con años/secciones
            const asignacionesRaw = btn.dataset.asignaciones || '[]';
            const asignaciones = JSON.parse(asignacionesRaw);
            cargarAsignacionesEditables(asignaciones);
            editForm.style.display = 'block';
            createForm.style.display = 'none';
            crudWrapper.style.display = 'none';
            window.scrollTo({ top: editForm.offsetTop, behavior: 'smooth' });

            // ------------------------------
            // Inicializar contador de edición basado en bloques actuales
            // ------------------------------
            // NUEVO: calcular asignaturaIndexEdicion según contenedor de edición
            const contenedorEdicion = document.querySelector('#edit-form-wrapper .asignaturas-container');
            // Si el contenedor existe, establecer el índice al número de bloques existentes
            window.asignaturaIndexEdicion = contenedorEdicion ? contenedorEdicion.querySelectorAll('.asignatura').length : 0;
            // Nota: uso window.asignaturaIndexEdicion para que el listener global pueda acceder a él.
            // ------------------------------
        }

        // Nota: no definimos aquí el listener del botón de añadir asignatura en edición.
        // El listener para el botón de edición se registra una vez abajo, fuera del evento 'change'.
    });

    // ------------------------------
    // Listener global para añadir asignatura en el formulario de edición
    // ------------------------------
    // NUEVO: definimos el listener una sola vez, fuera del change del tbody
    const $createAsignatureButtonEdition = document.querySelector('#new-asignature-edition-form');
    if ($createAsignatureButtonEdition) {
        $createAsignatureButtonEdition.addEventListener('click', function () {
            // Contenedor donde se insertan los bloques de asignatura en edición
            const $asignaturasContainers = document.querySelectorAll('.asignaturas-container');
            const $asignaturasContainerEditionForm = $asignaturasContainers[1]; // Contenedor del formulario de edición

            // Asegurar que la variable de índice existe; si no, inicializar en 0
            if (typeof window.asignaturaIndexEdicion === 'undefined' || window.asignaturaIndexEdicion === null) {
                window.asignaturaIndexEdicion = $asignaturasContainerEditionForm ? $asignaturasContainerEditionForm.querySelectorAll('.asignatura').length : 0;
            }

            // HTML del nuevo bloque de asignatura con índice dinámico (usa asignaturaIndexEdicion)
            const idx = window.asignaturaIndexEdicion;
            const $newAsignature = `
            <div class='asignatura'>
                <div class='materia'>
                    <label>Asignatura
                        <!-- El name usa asignaturas[índice][id_asignatura] para agrupar correctamente -->
                        <select name='asignaturas[${idx}][id_asignatura]' required>
                            <option value=''>-- Asignatura --</option>
                            <option value='1'>Matemática</option>
                            <option value='2'>Física</option>
                            <option value='3'>Inglés</option>
                            <option value='4'>Biología</option>
                            <option value='5'>Arte y Patrimonio</option>
                            <option value='6'>Química</option>
                            <option value='7'>Orientación y Convivencia</option>
                            <option value='8'>Formación para la Ciudadanía</option>
                            <option value='9'>Historia y Geografía</option>
                            <option value='10'>Grupo de Interés</option>
                            <option value='11'>Castellano y Literatura</option>
                            <option value='12'>Educación Física</option>
                        </select>
                    </label>
                </div>

                <div class='anio-seccion'>
                    <label>Año y Sección
                        <div class='checkbox-scroll-grid edit-anios'>
                            <!-- Cada checkbox usa el mismo índice para agrupar con su asignatura -->
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='1'> 1° A</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='2'> 1° B</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='3'> 1° C</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='4'> 2° A</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='5'> 2° B</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='6'> 2° C</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='7'> 3° A</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='8'> 3° B</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='9'> 3° C</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='10'> 4° A</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='11'> 4° B</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='12'> 4° C</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='13'> 5° A</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='14'> 5° B</label>
                            <label><input type='checkbox' name='asignaturas[${idx}][id_anio_seccion][]' value='15'> 5° C</label>
                        </div>
                    </label>
                </div>
                <button type="button" class="remove-button">✖</button>

            </div>`;

            // Insertar el nuevo bloque en el contenedor
            if ($asignaturasContainerEditionForm) {
                $asignaturasContainerEditionForm.insertAdjacentHTML('beforeend', $newAsignature);
            }

            // Incrementar el índice para el próximo bloque
            window.asignaturaIndexEdicion++;



            // Elimina la asignatura seleccionada

            // Referencia a todas las asignaturas del formulario
            const $removeButtons = document.querySelectorAll('.remove-button')
            $removeButtons.forEach(item => {
                item.addEventListener('click', ()=>{
                    item.parentElement.outerHTML = ''
                })
            })
        });
    }

    // ------------------------------
    // Reindexado antes de enviar el formulario de edición
    // ------------------------------
    // NUEVO: asegurarse que los names de asignaturas estén indexados secuencialmente antes del submit
    const editFormElement = document.querySelector('#edit-form-wrapper form');
    if (editFormElement) {
        editFormElement.addEventListener('submit', function (e) {
            // Reasignar índices secuenciales a todos los bloques .asignatura del formulario de edición
            const container = document.querySelector('#edit-form-wrapper .asignaturas-container');
            if (!container) return; // nada que hacer si no existe

            const bloques = container.querySelectorAll('.asignatura');
            bloques.forEach((bloque, nuevoIndex) => {
                // actualizar select id_asignatura
                const select = bloque.querySelector('select[name*="id_asignatura"]');
                if (select) {
                    select.setAttribute('name', `asignaturas[${nuevoIndex}][id_asignatura]`);
                }
                // actualizar checkboxes id_anio_seccion[]
                const checkboxes = bloque.querySelectorAll('input[type="checkbox"][name*="id_anio_seccion"]');
                checkboxes.forEach(cb => {
                    cb.setAttribute('name', `asignaturas[${nuevoIndex}][id_anio_seccion][]`);
                });
            });

            // Después del reindexado, el formulario continúa su envío normal
        });
    }
    // ------------------------------
    // FIN cambios relacionados con edición
    // ------------------------------

    // Cancelar edición
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const seleccionado = document.querySelector('input[name="docente_editar"]:checked');
            if (seleccionado) {
                seleccionado.checked = false;
            }

            location.reload()
        });
    }





    // Reconstruye los bloques de asignatura con sus años/secciones
    function cargarAsignacionesEditables(asignaciones) {
        const container = document.querySelector('#edit-form-wrapper .asignaturas-container');
        container.innerHTML = '';
        container.style.display = 'flex'; // fuerza visibilidad

        asignaciones.forEach((bloque, index) => {
            const selectHTML = `
            <div class='materia'>
                <label>Asignatura
                    <select name='asignaturas[${index}][id_asignatura]' required>
                        <option value=''>-- Asignatura --</option>
                        ${[
                            'Matemática','Física','Inglés','Biología','Arte y Patrimonio','Química',
                            'Orientación y Convivencia','Formación para la Ciudadanía','Historia y Geografía',
                            'Grupo de Interés','Castellano y Literatura','Educación Física'
                        ].map((nombre, i) => {
                            const id = i + 1;
                            const selected = bloque.id_asignatura == id ? 'selected' : '';
                            return `<option value='${id}' ${selected}>${nombre}</option>`;
                        }).join('')}
                    </select>
                </label>
            </div>`;

            const checkboxesHTML = `
            <div class='anio-seccion'>
                <label>Año y Sección
                    <div class='checkbox-scroll-grid'>
                        ${[
                            '1° A','1° B','1° C','2° A','2° B','2° C',
                            '3° A','3° B','3° C','4° A','4° B','4° C',
                            '5° A','5° B','5° C'
                        ].map((label, i) => {
                            const value = i + 1;
                            //cambia el  de texto a numero
                            const checked = bloque.id_anio_seccion.map(Number).includes(value) ? 'checked' : '';
                            return `<label><input type='checkbox' name='asignaturas[${index}][id_anio_seccion][]' value='${value}' ${checked}> ${label}</label>`;
                        }).join('')}
                    </div>
                </label>
            </div>
            <button type="button" class="remove-button">✖</button>
            `;

            container.insertAdjacentHTML('beforeend', `<div class='asignatura'>${selectHTML}${checkboxesHTML}</div>`);



            // Elimina la asignatura seleccionada

            // Referencia a todas las asignaturas del formulario
            const $removeButtons = document.querySelectorAll('.remove-button')
            $removeButtons.forEach(item => {
                item.addEventListener('click', ()=>{
                    item.parentElement.outerHTML = ''
                })
            })
        });

        // IMPORTANTE: después de reconstruir desde datos, actualizar el contador de edición
        // Sincronizar window.asignaturaIndexEdicion al número de bloques actual
        const contenedorEdicionPost = document.querySelector('#edit-form-wrapper .asignaturas-container');
        if (contenedorEdicionPost) {
            window.asignaturaIndexEdicion = contenedorEdicionPost.querySelectorAll('.asignatura').length;
        }
    }



    // Limpia el parámetro 'error' de la URL
    if (window.location.search.includes('error=')) {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.toString());
    }

    // Marca en el filtro la materia seleccionada
    const params = new URLSearchParams(window.location.search);
    const materia = params.get('materia');
    if (materia !== null) {
        const select = document.getElementById('order-by');
        const options = select.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].value === materia) {
                options[i].selected = true;
                break;
            }
        }
    }
    if (window.location.search.includes('materia=')) {
        const url = new URL(window.location.href);
        url.searchParams.delete('materia');
        window.history.replaceState({}, document.title, url.toString());
    }
});
