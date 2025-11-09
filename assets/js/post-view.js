document.addEventListener('DOMContentLoaded', function() {
    cargarPublicaciones();
});

// Elementos de la página
const $pageTitle = document.querySelector("title");
const $postTitle = document.querySelector(".post__title");
const $postDate = document.querySelector(".post__date");
const $postDescription = document.querySelector(".post__description");
const $imageContainer = document.querySelector(".post__image-wrapper");
const $documentContainer = document.querySelector(".post__document-wrapper");

function cargarPublicaciones() {
    // Obtener el ID de la URL
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (!id) {
        console.error('No se encontró el parámetro "id" en la URL');
        return;
    }

    // Enviar el ID al backend
    fetch('../../scripts/get-post-view.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
        const publicacion = data.publicacion;
        const imagenes = data.imagenes;
        const documentos = data.documentos;

        if (!publicacion) {
            $postTitle.textContent = 'Publicación no encontrada';
            $postDescription.textContent = 'Lo sentimos, no se pudo cargar la información de esta publicación.';
            return;
        }

        //* Mostrar los datos principales de la publicación
        $pageTitle.textContent = publicacion.titulo_publicacion;
        $postTitle.textContent = publicacion.titulo_publicacion;
        $postDescription.textContent = publicacion.descripcion_publicacion;

        // Formatear la fecha para un estilo más amigable
        const fecha = new Date(publicacion.fecha_publicacion);
        const fechaFormateada = fecha.toLocaleDateString('es-VE', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        $postDate.innerHTML = `<i class="fa-regular fa-calendar-days"></i> ${fechaFormateada}`;


        //* Mostrar imágenes adjuntas si existen
        $imageContainer.innerHTML = ''; // Limpiar contenedor
        imagenes.forEach(img => {
            const imgElement = document.createElement('img');
            imgElement.src = `../../public/uploads/img/${img.nombre_archivo}`;
            imgElement.alt = publicacion.titulo_publicacion;
            imgElement.classList.add('post__image');
            $imageContainer.appendChild(imgElement);
        });


        //* Mostrar documentos adjuntos si existen
        // Mostrar un encabezado para los documentos adjuntos
        if (documentos.length > 0) {
            $documentContainer.textContent = 'Documentos adicionales:';
        }
        // Mostrar documentos adjuntos
        documentos.forEach(doc => {
            const docElement = document.createElement('a');
            docElement.href = `../../public/uploads/doc/${doc.nombre_archivo}`;
            docElement.textContent = doc.nombre_archivo;
            docElement.setAttribute('target', '_blank');
            docElement.classList.add('post__document');
            $documentContainer.appendChild(docElement);
        });
    })
    .catch(error => {
        console.error('Error al cargar los datos de la publicación:', error);
    });
}