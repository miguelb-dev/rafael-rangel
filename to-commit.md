# CHANGELOG

## Cosas que hice

- Saqué el mensaje de error del formulario de editar docente para que no apareciera el Bug de que la información no cargara otra vez en el formulario.

- En el módulo de Gestión de Estudiantes desde la perspectiva del docente, ahora aparecen en el filtro únicamente las asignaturas y año/sección que tiene el docente logueado.

- Eliminé imágenes que no se estaban utilizando.

- Cambié las restricciones de las claves foráneas de id_docente y id_administrador en las tablas de publicacion y calendario escolar, de manera que al borrar un docente o un administrador, ya no se borran también las publicaciones y/o eventos que hayan hecho esos usuarios.

- Corregí un problema en professors-management.js, donde si al intentar eliminar un registro/s y en el mensaje de confirm le daba a cancelar, aún así se eliminan los registros. Ahora ya no pasa, se cancela correctamente.

- Añadí la ventana de diálogo en el sign-up, que pregunta si es estudiante o docente. De ser estudiante, muestra el formulario de registro, de ser docente, le muestra el mensaje de que no debe registrarse sino enviar un correo al administrador para que sea él el que le asigne una cuenta

- Corregí los problemas de responsividad en toda la aplicación
