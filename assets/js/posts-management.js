// === Elementos de la página ===
const $addButton = document.querySelector('#add');
const $editButton = document.querySelector('#edit');
const $deleteButton = document.querySelector('#delete');

const $formTitle = document.querySelector('.form__title');
const $selectWrapper = document.querySelector('.select-wrapper');
let $title = document.querySelector('#title'); // si existe en el HTML

const $description = document.querySelector('#description');
const $images = document.querySelector('#images');
const $documents = document.querySelector('#documents');

const $save = document.querySelector('#save');
const $cancel = document.querySelector('#cancel');

// === Estado interno ===
// NUEVO: ahora los nuevos adjuntos son objetos {id, name, file, url}
let imagenesAcumuladas = [];      // {id, name, file, url}
let documentosAcumulados = [];    // {id, name, file}
let imagenesEliminar = [];        // nombres de imágenes existentes marcadas para eliminar
let documentosEliminar = [];      // nombres de documentos existentes marcados para eliminar

let publicaciones = []; // datos cargados desde backend en modo editar

// === Helpers de UI ===
function limpiarPreviews() {
    const $previewImages = document.querySelector('#preview-images');
    const $previewDocuments = document.querySelector('#preview-documents');
    if ($previewImages) $previewImages.innerHTML = '';
    if ($previewDocuments) $previewDocuments.innerHTML = '';
}

// === RENDER IMÁGENES (existentes + nuevas) ===
// NUEVO: render combinado, identifica nuevos por id y existentes por nombre
function renderAllImagenes(existingImagenes = []) {
    const $previewImages = document.querySelector('#preview-images');
    if (!$previewImages) return;
    $previewImages.innerHTML = '';

    // Copia defensiva de existentes para poder filtrar sin tocar fuente original
    let existingCopy = Array.isArray(existingImagenes) ? existingImagenes.slice() : [];

    // Construir combinado: existing primero luego new
    const combined = [];

    existingCopy.forEach(img => combined.push({
        origen: 'existing',
        nombre: img.nombre_archivo,
        orden: Number(img.orden) || 0
    }));

    imagenesAcumuladas.forEach(obj => combined.push({
        origen: 'new',
        id: obj.id,
        nombre: obj.name,
        fileObj: obj,
        url: obj.url
    }));

    // Determinar portada: existing con orden===1 prioriza; si no, primera del combined
    let portadaNombre = null;
    const existingPortada = combined.find(item => item.origen === 'existing' && Number(item.orden) === 1);
    if (existingPortada) portadaNombre = existingPortada.nombre;
    else if (combined.length > 0) portadaNombre = combined[0].nombre;

    combined.forEach(item => {
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-item';

        const imgEl = document.createElement('img');
        imgEl.className = 'preview-image';
        if (item.origen === 'existing') {
            imgEl.src = `../../../public/uploads/img/${item.nombre}`;
            imgEl.alt = item.nombre;
        } else {
            imgEl.src = item.url;
            imgEl.alt = item.nombre;
        }

        if (item.nombre === portadaNombre) {
            imgEl.classList.add('portada');
            const tag = document.createElement('span');
            tag.className = 'preview-label';
            tag.textContent = 'Portada';
            wrapper.appendChild(tag);
        }

        const label = document.createElement('p');
        label.className = 'preview-label';
        label.textContent = item.nombre;

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'remove-button';
        btn.textContent = '✖';

        if (item.origen === 'existing') {
            btn.addEventListener('click', () => {
                // marcar para eliminar y quitar de la copia para que no reaparezca
                if (!imagenesEliminar.includes(item.nombre)) imagenesEliminar.push(item.nombre);
                existingCopy = existingCopy.filter(i => i.nombre_archivo !== item.nombre);
                // también actualizar la estructura en publicaciones si estamos en modo editar
                const $select = document.querySelector('#title-select');
                if ($select && $select.value) {
                    const pub = publicaciones.find(p => String(p.id_publicacion) === String($select.value));
                    if (pub && Array.isArray(pub.imagenes)) {
                        pub.imagenes = pub.imagenes.filter(i => i.nombre_archivo !== item.nombre);
                    }
                }
                renderAllImagenes(existingCopy);
            });
        } else {
            btn.addEventListener('click', () => {
                const idx = imagenesAcumuladas.findIndex(a => a.id === item.id);
                if (idx !== -1) {
                    try { URL.revokeObjectURL(imagenesAcumuladas[idx].url); } catch (e) {}
                    imagenesAcumuladas.splice(idx, 1);
                }
                // re-render usando existingCopy (no modificado)
                renderAllImagenes(existingCopy);
            });
        }

        wrapper.appendChild(imgEl);
        wrapper.appendChild(label);
        wrapper.appendChild(btn);
        $previewImages.appendChild(wrapper);
    });
}

// === RENDER DOCUMENTOS (existentes + nuevos) ===
function renderAllDocumentos(existingDocumentos = []) {
    const $previewDocuments = document.querySelector('#preview-documents');
    if (!$previewDocuments) return;
    $previewDocuments.innerHTML = '';

    // existing primero
    if (Array.isArray(existingDocumentos)) {
        existingDocumentos.forEach(doc => {
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-item';

            const link = document.createElement('a');
            link.className = 'preview-document';
            link.href = `../../../public/uploads/doc/${doc.nombre_archivo}`;
            link.target = '_blank';
            link.textContent = doc.nombre_archivo;
            link.title = doc.nombre_archivo;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-button';
            btn.textContent = '✖';
            btn.addEventListener('click', () => {
                if (!documentosEliminar.includes(doc.nombre_archivo)) documentosEliminar.push(doc.nombre_archivo);
                // actualizar publicaciones en memoria para que no reaparezca
                const $select = document.querySelector('#title-select');
                if ($select && $select.value) {
                    const pub = publicaciones.find(p => String(p.id_publicacion) === String($select.value));
                    if (pub && Array.isArray(pub.documentos)) {
                        pub.documentos = pub.documentos.filter(d => d.nombre_archivo !== doc.nombre_archivo);
                    }
                }
                wrapper.remove();
            });

            wrapper.appendChild(link);
            wrapper.appendChild(btn);
            $previewDocuments.appendChild(wrapper);
        });
    }

    // luego los nuevos
    documentosAcumulados.forEach((obj, idx) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-item';

        const label = document.createElement('p');
        label.className = 'preview-document';
        label.textContent = obj.name;
        label.title = obj.name;

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'remove-button';
        btn.textContent = '✖';
        btn.addEventListener('click', () => {
            const i = documentosAcumulados.findIndex(f => f.id === obj.id);
            if (i !== -1) documentosAcumulados.splice(i, 1);
            // re-render
            const $select = document.querySelector('#title-select');
            let existingDocs = [];
            if ($select && $select.value) {
                const pub = publicaciones.find(p => String(p.id_publicacion) === String($select.value));
                if (pub && Array.isArray(pub.documentos)) existingDocs = pub.documentos.slice();
            }
            renderAllDocumentos(existingDocs);
        });

        wrapper.appendChild(label);
        wrapper.appendChild(btn);
        $previewDocuments.appendChild(wrapper);
    });
}

// === Validación y handlers de selección de archivos ===
// NUEVO: crear id único y objectURL para cada imagen nueva
function verificarImagenes () {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
    const files = Array.from($images.files || []);

    const invalidFiles = files.filter(file => !allowedTypes.includes(file.type));
    if (invalidFiles.length > 0) {
        alert('Solo se permiten archivos de imagen. Se han detectado archivos no válidos.');
        $images.value = '';
        return;
    }

    files.forEach(file => {
        // id por timestamp + random
        const id = Date.now().toString(36) + '-' + Math.random().toString(36).slice(2,8);
        // evitar duplicados por nombre+size
        if (!imagenesAcumuladas.some(a => a.name === file.name && a.file.size === file.size)) {
            const obj = { id, name: file.name, file, url: URL.createObjectURL(file) };
            imagenesAcumuladas.push(obj);
        }
    });

    // obtener existing actuales (si estamos en modo editar)
    const $select = document.querySelector('#title-select');
    let existingImgs = [];
    if ($select && $select.value) {
        const pub = publicaciones.find(p => String(p.id_publicacion) === String($select.value));
        if (pub && Array.isArray(pub.imagenes)) existingImgs = pub.imagenes;
    }

    renderAllImagenes(existingImgs);
    $images.value = '';
}

// NUEVO: documentos con ids
function verificarDocumentos () {
    const forbiddenTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const files = Array.from($documents.files || []);

    const invalid = files.filter(file => forbiddenTypes.includes(file.type));
    if (invalid.length > 0) {
        alert('Solo se permiten archivos de documento. Se han detectado archivos no válidos.');
        $documents.value = '';
        return;
    }

    files.forEach(file => {
        const id = Date.now().toString(36) + '-' + Math.random().toString(36).slice(2,8);
        if (!documentosAcumulados.some(a => a.name === file.name && a.file.size === file.size)) {
            documentosAcumulados.push({ id, name: file.name, file });
        }
    });

    const $select = document.querySelector('#title-select');
    let existingDocs = [];
    if ($select && $select.value) {
        const pub = publicaciones.find(p => String(p.id_publicacion) === String($select.value));
        if (pub && Array.isArray(pub.documentos)) existingDocs = pub.documentos;
    }

    renderAllDocumentos(existingDocs);
    $documents.value = '';
}

$images.addEventListener('change', verificarImagenes);
$documents.addEventListener('change', verificarDocumentos);

// === Modos: add / edit / delete ===
function resetFormState(keepWrapper = false) {
    // limpia campos y arrays; si keepWrapper=false también restaura wrapper externo si hace falta
    if (!keepWrapper) {
        // no tocar wrapper aquí; los modos lo reescriben
    }
    imagenesAcumuladas.forEach(obj => { try { URL.revokeObjectURL(obj.url); } catch(e){} });
    imagenesAcumuladas = [];
    documentosAcumulados = [];
    imagenesEliminar = [];
    documentosEliminar = [];
    limpiarPreviews();
    $description.value = '';
    $images.value = '';
    $documents.value = '';
}

// --- addSeccion ---
function addSeccion() {
    $formTitle.textContent = "Crear publicación";

    $addButton.classList.add('user-selection');
    $editButton.classList.remove('user-selection');
    $deleteButton.classList.remove('user-selection');

    $selectWrapper.innerHTML = `
        <label for="title">Título</label>
        <input id="title" class="input__field" type="text" required>
    `;
    $title = document.querySelector('#title');

    resetFormState(true);

    $description.disabled = false;
    $images.disabled = false;
    $documents.disabled = false;

    $save.textContent = "Crear";
    $save.id = "save";
    $save.onclick = function (e) {
        e.preventDefault();

        const titulo = ($title ? $title.value.trim() : '');
        const descripcion = $description.value.trim();

        if (!titulo) {
            alert('El título es obligatorio');
            return;
        }

        const formData = new FormData();
        formData.append('title', titulo);
        formData.append('description', descripcion);

        // adjuntar imágenes nuevas (obj.file)
        imagenesAcumuladas.forEach(obj => formData.append('images[]', obj.file));
        documentosAcumulados.forEach(obj => formData.append('documents[]', obj.file));

        fetch('agregar-publicacion.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert('Publicación creada');
                // reset y mostrar previews vacíos
                resetFormState(true);
                addSeccion(); // deja el formulario listo para otra creación
            } else {
                alert('Error: ' + (res.error || 'Sin detalle'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error de conexión al crear publicación');
        });
    };

    // Cancelar: vacía todo
    $cancel.onclick = function () {
        resetFormState(true);
        if ($title) $title.value = '';
    };
}

// --- editSeccion ---
function editSeccion() {
    $formTitle.textContent = "Editar publicación";

    $editButton.classList.add('user-selection');
    $addButton.classList.remove('user-selection');
    $deleteButton.classList.remove('user-selection');

    resetFormState(true);

    // Cargar publicaciones
    fetch('obtener-publicacion.php')
        .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(data => {
            publicaciones = Array.isArray(data) ? data : [];

            let html = `
                <label for="title-select">Selecciona la publicación</label>
                <select id="title-select" class="input__field">
                    <option value="">Selecciona una publicación</option>
                    ${publicaciones.map(pub => `<option value="${pub.id_publicacion}">${pub.titulo_publicacion}</option>`).join('')}
                </select>
                <label for="title-edit" id="label-title-edit" style="display:none;">Título editable</label>
                <input id="title-edit" class="input__field" type="text" style="display:none;">
            `;
            $selectWrapper.innerHTML = html;

            const $titleEdit = document.querySelector('#title-edit');
            const $labelTitleEdit = document.querySelector('#label-title-edit');
            const $select = document.querySelector('#title-select');

            $description.disabled = false;
            $images.disabled = false;
            $documents.disabled = false;

            $save.textContent = "Guardar";
            $save.id = "save";

            $select.addEventListener('change', () => {
                const id = $select.value;
                if (!id) {
                    $titleEdit.value = '';
                    $titleEdit.style.display = 'none';
                    $labelTitleEdit.style.display = 'none';
                    resetFormState(true);
                    $save.removeAttribute('data-id');
                    return;
                }

                const pub = publicaciones.find(p => String(p.id_publicacion) === String(id));
                if (!pub) { alert('Publicación no encontrada'); return; }

                // mostrar input editable y llenar campos
                $titleEdit.style.display = '';
                $labelTitleEdit.style.display = '';
                $titleEdit.value = pub.titulo_publicacion;
                $description.value = pub.descripcion_publicacion;

                // reset arrays pero no previews aún (render from pub)
                imagenesAcumuladas.forEach(obj => { try { URL.revokeObjectURL(obj.url); } catch(e){} });
                imagenesAcumuladas = [];
                documentosAcumulados = [];
                imagenesEliminar = [];
                documentosEliminar = [];
                limpiarPreviews();

                const existingImgs = Array.isArray(pub.imagenes) ? pub.imagenes : [];
                const existingDocs = Array.isArray(pub.documentos) ? pub.documentos : [];

                renderAllImagenes(existingImgs);
                renderAllDocumentos(existingDocs);

                $save.setAttribute('data-id', pub.id_publicacion);

                $save.onclick = function (e) {
                    e.preventDefault();
                    submitEditarPublicacion(pub.id_publicacion, $titleEdit.value.trim());
                };

                // Cancelar en editar: vaciar arrays y recargar la selección actual (no borra la DB)
                $cancel.onclick = function () {
                    imagenesAcumuladas.forEach(obj => { try { URL.revokeObjectURL(obj.url); } catch(e){} });
                    imagenesAcumuladas = [];
                    documentosAcumulados = [];
                    imagenesEliminar = [];
                    documentosEliminar = [];
                    // volver a renderizar desde pub original (recargar la publicación seleccionada desde publicaciones)
                    const refreshedPub = publicaciones.find(p => String(p.id_publicacion) === String($select.value));
                    const imgs = refreshedPub && Array.isArray(refreshedPub.imagenes) ? refreshedPub.imagenes : [];
                    const docs = refreshedPub && Array.isArray(refreshedPub.documentos) ? refreshedPub.documentos : [];
                    renderAllImagenes(imgs);
                    renderAllDocumentos(docs);
                };
            });
        })
        .catch(err => {
            console.error('Error al obtener publicaciones', err);
            alert('No se pudieron cargar las publicaciones');
        });
}

// --- deleteSeccion ---
function deleteSeccion() {
    $formTitle.textContent = "Eliminar evento";

    $deleteButton.classList.add('user-selection');
    $addButton.classList.remove('user-selection');
    $editButton.classList.remove('user-selection');

    resetFormState(true);

    fetch('obtener-publicacion.php')
        .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(data => {
            publicaciones = Array.isArray(data) ? data : [];

            let html = `
                <label for="title-select">Selecciona la publicación</label>
                <select id="title-select" class="input__field">
                    <option value="">Selecciona una publicación</option>
                    ${publicaciones.map(pub => `<option value="${pub.id_publicacion}">${pub.titulo_publicacion}</option>`).join('')}
                </select>
            `;
            $selectWrapper.innerHTML = html;

            $description.disabled = true;
            $images.disabled = true;
            $documents.disabled = true;

            const $select = document.querySelector('#title-select');

            $save.textContent = "Eliminar";
            $save.id = "erase";

            $select.addEventListener('change', () => {
                const id = $select.value;
                if (!id) {
                    $title = document.querySelector('#title');
                    if ($title) $title.value = '';
                    $description.value = '';
                    limpiarPreviews();
                    $save.removeAttribute('data-id');
                    return;
                }

                const pub = publicaciones.find(p => String(p.id_publicacion) === String(id));
                if (!pub) return;

                $title = document.querySelector('#title');
                if ($title) $title.value = pub.titulo_publicacion;
                $description.value = pub.descripcion_publicacion;

                limpiarPreviews();
                const existingImgs = Array.isArray(pub.imagenes) ? pub.imagenes : [];
                const existingDocs = Array.isArray(pub.documentos) ? pub.documentos : [];

                renderAllImagenes(existingImgs);
                renderAllDocumentos(existingDocs);

                $save.setAttribute('data-id', pub.id_publicacion);

                $save.onclick = function (e) {
                    e.preventDefault();
                    const confirmar = confirm('¿Eliminar la publicación seleccionada? Esta acción es irreversible.');
                    if (!confirmar) return;

                    const formData = new FormData();
                    formData.append('id', pub.id_publicacion);

                    fetch('eliminar-publicacion.php', { method: 'POST', body: formData })
                    .then(r => r.json())
                    .then(resp => {
                        if (resp.success) {
                            alert('Publicación eliminada');
                            deleteSeccion();
                        } else {
                            alert('Error: ' + (resp.error || 'Sin detalle'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Error en conexión al eliminar');
                    });
                };

                // Cancelar en eliminar: limpiar selección visual
                $cancel.onclick = function () {
                    limpiarPreviews();
                    $select.value = '';
                    $save.removeAttribute('data-id');
                };
            });
        })
        .catch(err => {
            console.error('Error al obtener publicaciones', err);
            alert('No se pudieron cargar las publicaciones');
        });
}

// === Submit edición ===
function submitEditarPublicacion(id, tituloDesdeInput) {
    const titulo = tituloDesdeInput || '';
    const descripcion = $description.value.trim();

    if (!titulo) {
        alert('El título es obligatorio');
        return;
    }

    const formData = new FormData();
    formData.append('id', id);
    formData.append('title', titulo);
    formData.append('description', descripcion);

    // adjuntar nuevos archivos (usar .file en los objetos)
    imagenesAcumuladas.forEach(obj => formData.append('images[]', obj.file));
    documentosAcumulados.forEach(obj => formData.append('documents[]', obj.file));

    // listas de eliminación (nombres)
    imagenesEliminar.forEach(name => formData.append('imagenes_eliminar[]', name));
    documentosEliminar.forEach(name => formData.append('documentos_eliminar[]', name));

    fetch('editar-publicacion.php', { method: 'POST', body: formData })
    .then(r => r.json())
    .then(resp => {
        if (resp.success) {
            alert('Publicación actualizada');
            editSeccion(); // recargar modo editar
        } else {
            alert('Error: ' + (resp.error || 'Sin detalle'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error en conexión al editar');
    });
}

// === Inicialización ===
$addButton.addEventListener('click', addSeccion);
$editButton.addEventListener('click', editSeccion);
$deleteButton.addEventListener('click', deleteSeccion);


// iniciar en modo crear
addSeccion();