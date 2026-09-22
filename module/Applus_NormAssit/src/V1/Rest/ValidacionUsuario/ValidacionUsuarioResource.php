<?php
namespace Applus_NormAssit\V1\Rest\ValidacionUsuario;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Stdlib\Parameters;
use Business\Service\UneApplusService;
use Business\Utility\ApiResponse;

class ValidacionUsuarioResource extends AbstractResourceListener
{
    private $uneApplusService;

    public function __construct(UneApplusService $uneApplusService)
    {
        $this->uneApplusService = $uneApplusService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($arrayData)
    {
        if (is_object($arrayData)) {
            $arrayData = (array) $arrayData;
        }

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

        $response = new ApiResponse('Login exitoso.', ApiResponse::SUCCESS, [
            'Validacion' => $validacion
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
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
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
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}