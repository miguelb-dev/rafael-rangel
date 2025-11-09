document.addEventListener('DOMContentLoaded', function () {
    
    //* Elementos generales del DOM
    const editButton = document.querySelector('.action-buttons-wrapper .edit');
    const eliminarBtn = document.querySelector('.action-buttons-wrapper .delete');
    const crudWrapper = document.getElementById('crud-wrapper');
    const editForm = document.getElementById('edit-form-wrapper');
    const cancelEditBtn = document.getElementById('cancel-edit');
    const guardarBtn = document.querySelector('.status-buttons-wrapper .save');
    const cancelarBtn = document.querySelector('.status-buttons-wrapper .cancel');
    const statusWrapper = document.querySelector('.status-buttons-wrapper');
    const seleccionCols = document.querySelectorAll('.seleccion-col');
    const radioCells = document.querySelectorAll('.seleccion-edicion');


    //* === Activar modo eliminación ===
    eliminarBtn.addEventListener('click', () => {
        eliminarBtn.classList.add('user-selection');
        editButton.classList.remove('user-selection');

        // Mostrar checkboxes, ocultar radios
        radioCells.forEach(cell => cell.style.display = 'none');
        seleccionCols.forEach(col => col.style.display = 'table-cell');
        statusWrapper.style.display = 'flex';
        guardarBtn.style.display = 'block'; // Aparece el botón de guardar
    });

    // === Confirmar eliminación ===
    guardarBtn.addEventListener('click', () => {
        const seleccionados = document.querySelectorAll('input[name="seleccion[]"]:checked');
        if (seleccionados.length === 0) {
            alert("No seleccionaste ningún registro.");
        } else if (confirm("ADVERTENCIA: ¿Estás seguro de que quieres eliminar TODA la información del estudiante/s seleccionado/s?")) {
            document.getElementById('form-table').submit(); // Precisión: envía el formulario correcto
        }
    });

    // === Cancelar modo eliminación y edicion ===
    cancelarBtn.addEventListener('click', () => {
        // Desactivar modo eliminación
        eliminarBtn.classList.remove('user-selection');

        // Desactivar modo edición
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

    
    //* === Activar modo edición ===
    editButton.addEventListener('click', () => {
        editButton.classList.add('user-selection');
        eliminarBtn.classList.remove('user-selection');

        // Ocultar checkboxes y limpiar selección
        seleccionCols.forEach(col => {
            col.style.display = 'none';
            const checkbox = col.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = false;
        });

        // Mostrar radios para seleccionar estudiante
        radioCells.forEach(cell => cell.style.display = 'table-cell');
        statusWrapper.style.display = 'flex';
        guardarBtn.style.display = 'none'; // Oculta el botón de guardar
    });

    // === Cargar datos al seleccionar estudiante para edición ===
    document.querySelector('tbody').addEventListener('change', function (e) {
        if (e.target && e.target.name === 'estudiante_editar') {
            const fila = e.target.closest('tr');
            const btn = fila.querySelector('.edit-btn');
            if (!btn) return;

            // === Cargar datos en el formulario ===
            document.getElementById('edit-id').value = btn.dataset.id_estudiante || '';  // COMENTARIO: antes usaba btn.dataset.id (la cédula), ahora usa el ID real del estudiante
            document.getElementById('edit-cedula').value = btn.dataset.cedula;
            document.getElementById('edit-nombre').value = btn.dataset.nombre;
            document.getElementById('edit-apellido').value = btn.dataset.apellido;

            document.getElementById('edit-id_estudiante_asignatura').value = btn.dataset.id_estudiante_asignatura || '';  // COMENTARIO: clave foránea para guardar en periodo_escolar

            // === Cargar notas e inasistencias si existen ===
            document.getElementById('nota-lapso1').value = btn.dataset.nota1 || '';
            document.getElementById('nota-lapso2').value = btn.dataset.nota2 || '';
            document.getElementById('nota-lapso3').value = btn.dataset.nota3 || '';

            document.getElementById('inasistencia-lapso1').value = btn.dataset.inas1 || '';
            document.getElementById('inasistencia-lapso2').value = btn.dataset.inas2 || '';
            document.getElementById('inasistencia-lapso3').value = btn.dataset.inas3 || '';

            // === Mostrar nombre de la asignatura y guardar claves foráneas ===
            document.getElementById('assignature-name').textContent = btn.dataset.asignatura || 'Asignatura';
            document.getElementById('edit-id_asignatura').value = btn.dataset.id_asignatura || '';
            document.getElementById('edit-id_anio_seccion').value = btn.dataset.id_anio_seccion || '';

            // === Mostrar formulario de edición ===
            editForm.style.display = 'block';
            crudWrapper.style.display = 'none';
            window.scrollTo({ top: editForm.offsetTop, behavior: 'smooth' });
        }
    });

    // === Cancelar formulario de edición ===
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Ocultar formulario y restaurar CRUD
            editForm.style.display = 'none';
            crudWrapper.style.display = 'block';
            statusWrapper.style.display = 'none';
            radioCells.forEach(cell => cell.style.display = 'none');

            // Limpiar campos del formulario
            document.getElementById('edit-id').value = '';
            document.getElementById('edit-cedula').value = '';
            document.getElementById('edit-nombre').value = '';
            document.getElementById('edit-apellido').value = '';
            // Si luego agregas notas/inasistencias, también se deben limpiar aquí

            // Desmarcar selección
            const seleccionado = document.querySelector('input[name="estudiante_editar"]:checked');
            if (seleccionado) {
                seleccionado.checked = false;
            }
        });
    }

    // === Limpieza de parámetro 'error' en la URL ===
    if (window.location.search.includes('error=')) {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.toString());
    }
});
