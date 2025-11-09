document.addEventListener('DOMContentLoaded', function() {
    cargarPublicaciones();
});


// Detecta el usuario para redirigir correctamente
const currentPage = window.location.pathname.split('/').pop();
    if (currentPage === 'inicio-docente.php') {
        postRoot = 'post-docente.php'
        mainRoot = '../../scripts/get-posts.php'
        imgDefault = 'assets/img/extras/default-img.png'
    }
    else if (currentPage === 'inicio-admin.php') {
        postRoot = 'post-admin.php'
        mainRoot = '../../scripts/get-posts.php'
        imgDefault = '../../assets/img/extras/default-img.png'
    } else if (currentPage == 'inicio-estudiante.php') {
        postRoot = 'post-estudiante.php'
        mainRoot = '../../scripts/get-posts.php'
        imgDefault = '../../assets/img/extras/default-img.png'
    } else {
        postRoot = 'public/views/post-view.php'
        mainRoot = 'scripts/get-posts.php'
        imgDefault = '../../assets/img/extras/default-img.png'
    }


function cargarPublicaciones() {
    fetch(mainRoot)
        .then(response => response.json())
        .then(publicaciones => {
            const container = document.querySelector('#post-container');
            
            if (publicaciones.length === 0) {
                container.innerHTML = '<p id="no-post">No hay publicaciones disponibles</p>';
                return;
            }


            let html = '';
            publicaciones.forEach(publicacion => {

                // Detecta el usuario para redirigir correctamente
                const currentPage = window.location.pathname.split('/').pop();
                if (currentPage === 'inicio-docente.php') {
                    postRoot = 'post-docente.php'
                    mainRoot = '../../scripts/get-posts.php'
                    imgDefault = '../../assets/img/extras/default-img.png'
                    imgPost = '../../public/uploads/img/'
                }
                else if (currentPage === 'inicio-admin.php') {
                    postRoot = 'post-admin.php'
                    mainRoot = '../../scripts/get-posts.php'
                    imgDefault = '../../assets/img/extras/default-img.png'
                    imgPost = '../../public/uploads/img/'
                } else if (currentPage == 'inicio-estudiante.php') {
                    postRoot = 'post-estudiante.php'
                    mainRoot = '../../scripts/get-posts.php'
                    imgDefault = '../../assets/img/extras/default-img.png'
                    imgPost = '../../public/uploads/img/'
                } else {
                    postRoot = 'public/views/post-view.php'
                    mainRoot = 'scripts/get-posts.php'
                    imgDefault = 'assets/img/extras/default-img.png'
                    imgPost = 'public/uploads/img/'
                }

                // Si nombre_archivo es null o vacío, se usará una imagen por defecto
                let imagenSrc = publicacion.nombre_archivo ? `${imgPost}${publicacion.nombre_archivo}` : imgDefault;


                html += `
                    <div class="post">
                        <a class="post__link" href="${postRoot}?id=${publicacion.id_post}">
                            <div class="post__container-image">
                                <img class="post__image" src="${imagenSrc}">
                            </div>
                            <h2 class="post__title">${publicacion.titulo_publicacion}</h2>
                        </a>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        })
        .catch(error => {
            console.error('Error al cargar las publicaciones:', error);
            document.querySelector('#post-container').innerHTML = '<div id="error-post">Error al cargar las publicaciones</div>';
        });
}