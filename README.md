# api-publications
Api de gestión de usuarios y publicaciones

En los archivos config/config.php y config/database.php están las credenciales de la base de datos

Para el registro de usuarios, nos dirigimos al archivo create_user.php con los siguientes parámetros

{<br>
    "firstname": "John",<br>
    "lastname": "Doe",<br>
    "email": "john.doe@example.com",<br>
    "password": "example_pass",<br>
    "access_level": "4"<br>
}

Parámetros "access_level"

0 - Rol Básico // Permiso de acceso<br>
1 - Rol Medio // Permiso de acceso y consulta<br>
2 - Rol Medio alto // Permiso de acceso, consulta y agregar<br>
3 - Rol Alto medio // Permiso de acceso, consulta, agregar y actualizar<br>
4 - Rol Alto // Permiso de acceso, consulta, agregar, actualizar y eliminar<br>

Obtendremos el mensaje

{<br>
    "message": "User was created."<br>
}

En el archivo login.php, iniciamos sesión con nuestro usuario con nuestro email y password

{<br>
    "email": "john.doe@example.com",<br>
    "password": "example_pass"<br>
}

Obtendremos la siguiente información

{<br>
    "message": "Successful login.",<br>
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"<br>
}

Con el token generado lo usaremos en todos los siguientes archivos para generar la consulta.

Dentro de request.php, están las solicitudes de Nueva publicación, Modificar publicación, Eliminar publicación y Listado de publicaciones

Método POST / Nueva Publicación
{<br>
    "title": "Título de publicación",<br>
    "content": "Descripción de la publicación",<br>
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"<br>
}


Mensaje de respuesta

{<br>
    "message": "Post creado."<br>
}

Método GET / Detalles de Publicación
Si mandamos solo el token mostrará todas las publicaciones
{<br>
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"<br>
}

Mensaje de respuesta
{<br>
    "id": "1",<br>
    "title": "Título de publicación",<br>
    "content": "Descripción de la publicación",<br>
    "created": "2021-10-10 20:51:31",<br>
    "modified": "0000-00-00 00:00:00",<br>
    "disabled": "0000-00-00 00:00:00",<br>
    "user_id": "5",<br>
    "status": "0"<br>
}

Si queremos la información de una publicación en específico, mandamos su id
{<br>
    "id": "1",<br>
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"<br>
}

Método PUT / Modificar Publicación
{<br>
    "id": "9",<br>
    "title": "Título de publicación",<br>
    "content": "Descripcion de la publicacion",<br>
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"<br>
}

Mensaje de respuesta
{<br>
    "message": "El post fué actualizado."<br>
}

Metodo DELETE / Eliminar Publicación
{<br>
    "id": "9",<br>
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"<br>
}

Mensaje de respuesta
{<br>
    "message": "El post fue eliminado."<br>
}

En publications.php, se muestra un listado de publicaciones con una Título - Descripción - Fecha de creación - Nombre - Rol

{<br>
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MzM4OTg3MDMsImV4cCI6MTYzMzkwMjMwMywiaXNzIjoiaHR0cHM6XC9cL3VhbGsubXhcL2luZ2VuaWF0XC9yZXN0LWFwaS1hdXRoZW50aWNhdGlvbi1leGFtcGxlXC8iLCJkYXRhIjp7ImlkIjoiNSIsImZpcnN0bmFtZSI6ImluZ2VuaWF0IiwibGFzdG5hbWUiOiJtZXhpY28iLCJlbWFpbCI6ImluZ2VuaWF0QGV4YW1wbGUuY29tIiwibml2ZWxfZGVfYWNjZXNvIjoiNCJ9fQ.QZihSysNOUQ8kCH4wJfzcJ9wiFVQ2nF9GdIUlzOCRWU"<br>
}

Mensaje de respuesta

[<br>
    {<br>
        "id": "1",<br>
        "title": "Título de publicación",<br>
        "content": "Descripción de la publicación",<br>
        "created": "2021-10-10 20:51:31",<br>
        "firstname": "ingeniat",<br>
        "access_level": "4"<br>
    }<br>
]

