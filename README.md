# api-publications
Api de gestión de usuarios y publicaciones

En los archivos config/config.php y config/database.php están las credenciales de la base de datos

Para el registro de usuarios, nos dirigimos al archivo create_user.php con los siguientes parámetros

{
    "firstname": "John",
    "lastname": "Doe",
    "email": "john.doe@example.com",
    "password": "example_pass",
    "access_level": "4"
}

Parámetros "access_level"

0 - Rol Básico // Permiso de acceso
1 - Rol Medio // Permiso de acceso y consulta
2 - Rol Medio alto // Permiso de acceso, consulta y agregar
3 - Rol Alto medio // Permiso de acceso, consulta, agregar y actualizar
4 - Rol Alto // Permiso de acceso, consulta, agregar, actualizar y eliminar

Obtendremos el mensaje

{
    "message": "User was created."
}

En el archivo login.php, iniciamos sesión con nuestro usuario con nuestro email y password

{
    "email": "john.doe@example.com",
    "password": "example_pass"
}

Obtendremos la siguiente información

{
    "message": "Successful login.",
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"
}

Con el token generado lo usaremos en todos los siguientes archivos para generar la consulta.

Dentro de request.php, están las solicitudes de Nueva publicación, Modificar publicación, Eliminar publicación y Listado de publicaciones

Método POST / Nueva Publicación
{
    "title": "Título de publicación",
    "content": "Descripción de la publicación",
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"
}


Mensaje de respuesta

{
    "message": "Post creado."
}

Método GET / Detalles de Publicación
Si mandamos solo el token mostrará todas las publicaciones
{
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"
}

Mensaje de respuesta
{
    "id": "1",
    "title": "Título de publicación",
    "content": "Descripción de la publicación",
    "created": "2021-10-10 20:51:31",
    "modified": "0000-00-00 00:00:00",
    "disabled": "0000-00-00 00:00:00",
    "user_id": "5",
    "status": "0"
}

Si queremos la información de una publicación en específico, mandamos su id
{
    "id": "1",
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"
}

Método PUT / Modificar Publicación
{
    "id": "9",
    "title": "Título de publicación",
    "content": "Descripcion de la publicacion",
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"
}

Mensaje de respuesta
{
    "message": "El post fué actualizado."
}

Metodo DELETE / Eliminar Publicación
{
    "id": "9",
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"
}

Mensaje de respuesta
{
    "message": "El post fue eliminado."
}

En publications.php, se muestra un listado de publicaciones con una Título - Descripción - Fecha de creación - Nombre - Rol

{
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"
}

Mensaje de respuesta

[
    {
        "id": "1",
        "title": "Título de publicación",
        "content": "Descripción de la publicación",
        "created": "2021-10-10 20:51:31",
        "firstname": "ingeniat",
        "access_level": "4"
    }
]

