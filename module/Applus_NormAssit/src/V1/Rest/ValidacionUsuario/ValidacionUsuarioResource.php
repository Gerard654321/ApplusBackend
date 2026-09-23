<?php
namespace Applus_NormAssit\V1\Rest\ValidacionUsuario;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Stdlib\Parameters;
use Business\Service\UneApplusService;
use Business\Model\AppUsuariosTable;
use Business\Utility\ApiResponse;

class ValidacionUsuarioResource extends AbstractResourceListener
{
    private $uneApplusService;
    private $appUsuariosTable;

    public function __construct(UneApplusService $uneApplusService, AppUsuariosTable $appUsuariosTable)
    {
        $this->uneApplusService = $uneApplusService;
        $this->appUsuariosTable = $appUsuariosTable;
    }

    /**
     * Create a resource.
     * TIPO 1 = valida usuario y contraseña (login). TIPO 2 = registra un nuevo usuario.
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($arrayData)
    {
        if (is_object($arrayData)) {
            $arrayData = (array) $arrayData;
        }

        $tipo = $arrayData['TIPO'] ?? null;

        if ($tipo == 1) {
            return $this->validarUsuario($arrayData);
        }

        if ($tipo == 2) {
            return $this->registrarUsuario($arrayData);
        }

        $response = new ApiResponse('TIPO invalido. Use 1 para validar o 2 para registrar.', ApiResponse::ERROR);
        return $response->toHttpResponse();
    }

    private function validarUsuario(array $arrayData)
    {
        $codigoUsuario = $arrayData['codigoUsuario'] ?? null;
        $password = $arrayData['password'] ?? null;

        if (!$codigoUsuario || !$password) {
            $response = new ApiResponse('No ingreso usuario y/o contraseña.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $validacion = $this->uneApplusService->validaUsuario($codigoUsuario, $password);

        if ($validacion !== 0) {
            $response = new ApiResponse('Usuario y contraseña incorrectos o invalidos.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $acl = $this->uneApplusService->obtieneAclUsuario($codigoUsuario);

        $response = new ApiResponse('Login exitoso.', ApiResponse::SUCCESS, [
            'Validacion' => $validacion,
            'ACL' => $acl,
        ]);
        return $response->toHttpResponse();
    }

    private function registrarUsuario(array $arrayData)
    {
        $codigoUsuario = $arrayData['codigoUsuario'] ?? null;
        $password = $arrayData['password'] ?? null;
        $nombreUsuario = $arrayData['nombreUsuario'] ?? null;

        if (!$codigoUsuario || !$password || !$nombreUsuario) {
            $response = new ApiResponse('Faltan datos obligatorios para registrar el usuario.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $registro = $this->uneApplusService->registraUsuario(
            $codigoUsuario,
            $password,
            (string) ($arrayData['apellidoPaterno'] ?? ''),
            (string) ($arrayData['apellidoMaterno'] ?? ''),
            $nombreUsuario,
            (string) ($arrayData['numeroCelular'] ?? ''),
            (string) ($arrayData['correoElectronico'] ?? ''),
            (int) ($arrayData['tipoUsuario'] ?? 0)
        );

        if ($registro === 1) {
            $response = new ApiResponse('El usuario ya existe.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        if ($registro !== 0) {
            $response = new ApiResponse('No se pudo registrar el usuario.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $response = new ApiResponse('Usuario registrado exitosamente.', ApiResponse::SUCCESS, [
            'Registro' => $registro
        ]);
        return $response->toHttpResponse();
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $usuario = $this->appUsuariosTable->getByCodigo($id)->current();

        if (!$usuario) {
            return new ApiProblem(404, 'Usuario no encontrado.');
        }

        $data = $usuario->getArrayCopy();
        unset($data['PASSWORD']);

        $response = new ApiResponse('', ApiResponse::SUCCESS, $data);
        return $response->toHttpResponse();
    }

    /**
     * Fetch all or a subset of resources.
     * Devuelve la lista de usuarios con TIPO_USUARIO 0, solo si el "solicitante"
     * (parametro de query, su CODIGO_USUARIO) tiene TIPO_USUARIO 1, 2, 3 o 4.
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $solicitante = $params['solicitante'] ?? null;

        if (!$solicitante) {
            $response = new ApiResponse('Falta el parametro solicitante.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $usuarioSolicitante = $this->appUsuariosTable->getByCodigo($solicitante)->current();

        if (!$usuarioSolicitante) {
            return new ApiProblem(404, 'Usuario solicitante no encontrado.');
        }

        if (!in_array((int) $usuarioSolicitante->TIPO_USUARIO, [1, 2, 3, 4], true)) {
            return new ApiProblem(403, 'No tiene permisos para ver esta lista.');
        }

        $usuarios = [];
        foreach ($this->appUsuariosTable->getByTipoUsuario(0) as $usuario) {
            $data = $usuario->getArrayCopy();
            unset($data['PASSWORD']);
            $usuarios[] = $data;
        }

        $response = new ApiResponse('', ApiResponse::SUCCESS, ['usuarios' => $usuarios]);
        return $response->toHttpResponse();
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource.
     * TIPO 1 = actualiza los datos del usuario. TIPO 2 = actualiza la contraseña.
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        $tipo = $data['TIPO'] ?? null;

        if ($tipo == 1) {
            return $this->actualizarDatosUsuario($id, $data);
        }

        if ($tipo == 2) {
            return $this->actualizarPassword($id, $data);
        }

        $response = new ApiResponse('TIPO invalido. Use 1 para actualizar datos o 2 para actualizar contraseña.', ApiResponse::ERROR);
        return $response->toHttpResponse();
    }

    private function actualizarDatosUsuario($id, array $data)
    {
        $resultado = $this->uneApplusService->actualizaUsuario(
            $id,
            (string) ($data['apellidoPaterno'] ?? ''),
            (string) ($data['apellidoMaterno'] ?? ''),
            (string) ($data['nombreUsuario'] ?? ''),
            (string) ($data['numeroCelular'] ?? ''),
            (string) ($data['correoElectronico'] ?? ''),
            (int) ($data['codigoEstado'] ?? 0),
            (int) ($data['tipoUsuario'] ?? 0)
        );

        if ($resultado === 0) {
            return new ApiProblem(404, 'Usuario no encontrado.');
        }

        $response = new ApiResponse('Datos actualizados correctamente.', ApiResponse::SUCCESS, [
            'Actualizacion' => $resultado
        ]);
        return $response->toHttpResponse();
    }

    private function actualizarPassword($id, array $data)
    {
        $passwordActual = $data['passwordActual'] ?? null;
        $passwordNuevo = $data['passwordNuevo'] ?? null;

        if (!$passwordActual || !$passwordNuevo) {
            $response = new ApiResponse('Falta la contraseña actual y/o la nueva.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $resultado = $this->uneApplusService->actualizaPassword($id, $passwordActual, $passwordNuevo);

        if ($resultado !== 0) {
            $mensajes = [
                1 => 'Usuario no encontrado.',
                2 => 'Usuario inactivo.',
                3 => 'Contraseña actual incorrecta.',
            ];
            $response = new ApiResponse($mensajes[$resultado] ?? 'No se pudo actualizar la contraseña.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $response = new ApiResponse('Contraseña actualizada correctamente.', ApiResponse::SUCCESS, [
            'Actualizacion' => $resultado
        ]);
        return $response->toHttpResponse();
    }
}