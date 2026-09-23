<?php
return [
    'Applus_NormAssit\\V1\\Rest\\ValidacionUsuario\\Controller' => [
        'description' => 'Login, registro y mantenimiento básico de los usuarios del app móvil. 
La validación de credenciales, el registro y las actualizaciones se resuelven contra funciones del esquema pkg_app_seguridad en la base de datos.',
        'collection' => [
            'GET' => [
                'description' => 'Devuelve la lista de usuarios con TIPO_USUARIO 0 (usuarios base). Solo pueden verla los usuarios cuyo propio TIPO_USUARIO sea 1, 2, 3 o 4. Como todavía no hay login por token, quien pregunta se identifica con su propio CODIGO_USUARIO en el query param "solicitante" (esto no es seguridad real, es un filtro funcional mientras no exista un mecanismo de sesión).',
                'request' => 'GET /applus/validacion-usuario?solicitante=SPENA',
                'response' => 'Si el solicitante tiene permisos:
{"type": "success", "message": "", "usuarios": [{"ID_USUARIO": 1, "CODIGO_USUARIO": "...", "NOMBRE_USUARIO": "...", "TIPO_USUARIO": 0, ...}]}
(la lista viene sin el campo PASSWORD)

Si falta el parametro solicitante, responde 400:
{"type": "error", "message": "Falta el parametro solicitante."}

Si el solicitante no existe, responde 404 con: "Usuario solicitante no encontrado."

Si el solicitante existe pero su TIPO_USUARIO no es 1, 2, 3 ni 4, responde 403 con: "No tiene permisos para ver esta lista."',
            ],
            'POST' => [
                'description' => 'Según el campo TIPO enviado en el body, valida el login de un usuario (TIPO 1) o registra uno nuevo (TIPO 2). 
La contraseña nunca se guarda ni se compara en texto plano: eso lo hace la función de base de datos correspondiente.',
                'request' => 'TIPO 1 (login):
{
    "TIPO": 1,
    "codigoUsuario": "SPENA",
    "password": "AdminApplus2026"
}

TIPO 2 (registro). codigoUsuario, password y nombreUsuario son obligatorios, el resto es opcional:
{
    "TIPO": 2,
    "codigoUsuario": "NUEVO1",
    "password": "Clave123",
    "nombreUsuario": "Juan Perez",
    "apellidoPaterno": "Perez",
    "apellidoMaterno": "Gomez",
    "numeroCelular": "999999999",
    "correoElectronico": "jperez@applus.com",
    "tipoUsuario": 1
}',
                'response' => 'Login correcto (ACL trae los permisos del usuario: WINDOW, CONTROL y STATUS. Si no tiene credenciales asignadas, ACL viene vacío []):
{"type": "success", "message": "Login exitoso.", "Validacion": 0, "ACL": [{"WINDOW": "...", "CONTROL": "...", "STATUS": "..."}]}

Login incorrecto (no se distingue si el usuario no existe, está inactivo o la contraseña está mal, por seguridad):
{"type": "error", "message": "Usuario y contraseña incorrectos o invalidos."}

Registro correcto:
{"type": "success", "message": "Usuario registrado exitosamente.", "Registro": 0}

Registro fallido porque el CODIGO_USUARIO ya existe:
{"type": "error", "message": "El usuario ya existe."}

Si TIPO no es 1 ni 2, o si faltan campos obligatorios, responde 400 con el mensaje correspondiente.',
            ],
        ],
        'entity' => [
            'GET' => [
                'description' => 'Devuelve los datos de un usuario buscándolo por su código de usuario. 
La contraseña nunca se incluye en la respuesta.',
                'request' => '',
                'response' => '{
    "type": "success",
    "message": "",
    "ID_USUARIO": 7,
    "CODIGO_USUARIO": "SPENA",
    "APELLIDO_PATERNO": "PEÑA",
    "APELLIDO_MATERNO": "BORDON",
    "NOMBRE_USUARIO": "SERGIO PAOLO",
    "NUMERO_CELULAR": null,
    "CORREO_ELECTRONICO": null,
    "CODIGO_ESTADO": 1,
    "TIPO_USUARIO": 1,
    "FECHA_CREACION": "2026-01-01"
}

Si el CODIGO_USUARIO no existe, responde 404 con: {"type": "error", "message": "Usuario no encontrado."}',
            ],
            'PUT' => [
                'description' => 'Según el campo TIPO enviado en el body, actualiza los datos de perfil del usuario (TIPO 1) o su contraseña (TIPO 2). Para cambiar la contraseña hay que mandar la actual, la función de base de datos la valida antes de guardar la nueva.',
                'request' => 'TIPO 1 (actualizar datos):
{
    "TIPO": 1,
    "apellidoPaterno": "PEÑA",
    "apellidoMaterno": "BORDON",
    "nombreUsuario": "SERGIO PAOLO",
    "numeroCelular": "999999999",
    "correoElectronico": "spena@applus.com",
    "codigoEstado": 1,
    "tipoUsuario": 1
}

TIPO 2 (cambiar contraseña):
{
    "TIPO": 2,
    "passwordActual": "AdminApplus2026",
    "passwordNuevo": "NuevaClave2026"
}',
                'response' => 'Datos actualizados:
{"type": "success", "message": "Datos actualizados correctamente.", "Actualizacion": 0}

Contraseña actualizada:
{"type": "success", "message": "Contraseña actualizada correctamente.", "Actualizacion": 0}

Errores posibles según el caso: "Usuario no encontrado.", "Usuario inactivo.", "Contraseña actual incorrecta.", o "TIPO invalido..." si no se manda 1 ni 2.',
            ],
        ],
    ],
    'Applus_NormAssit\\V1\\Rest\\DocumentosApplus\\Controller' => [
        'description' => 'Consulta y actualización de los documentos de la app (tabla DOCUMENTS_APP).',
        'collection' => [
            'GET' => [
                'description' => 'Devuelve documentos, con filtros opcionales por query param. Sin ningun parametro trae todos. Con "userData" filtra por usuario dueño del documento. Con "typeDocument" filtra por tipo de documento. Con ambos juntos filtra por usuario y tipo a la vez.',
                'request' => 'Todos los documentos:
GET /applus/documentos-applus

Por usuario:
GET /applus/documentos-applus?userData=1

Por tipo de documento:
GET /applus/documentos-applus?typeDocument=1

Por usuario y tipo de documento:
GET /applus/documentos-applus?userData=1&typeDocument=1',
                'response' => '{
    "type": "success",
    "message": "",
    "documentos": [
        {
            "ID_DOC": 1,
            "NAME_DOC": "...",
            "EXPIRATION_DATE": "2026-12-31",
            "USER_DATA": "SPENA",
            "DOCUMENT_PDF": "...",
            "ROUTE_DOCUMENT": "...",
            "TYPE_DOCUMENT": "DNI"
        }
    ]
}',
            ],
        ],
        'entity' => [
            'PUT' => [
                'description' => 'Actualiza unicamente la fecha de expiracion (EXPIRATION_DATE) de un documento. No toca ningun otro campo.',
                'request' => '{
    "expirationDate": "2027-06-30"
}',
                'response' => 'Actualizado:
{"type": "success", "message": "Fecha de expiracion actualizada correctamente.", "Actualizacion": 1}

Si falta expirationDate en el body, responde 400 con: "Falta la fecha de expiracion."

Si el ID_DOC no existe, responde 404 con: "Documento no encontrado."',
            ],
        ],
    ],
];