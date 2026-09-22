<?php
namespace Applus_NormAssit\V1\Rest\DocumentosApplus;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Stdlib\Parameters;
use Business\Model\DocumentsAppTable;
use Business\Utility\ApiResponse;

class DocumentosApplusResource extends AbstractResourceListener
{
    private $documentsAppTable;

    public function __construct(DocumentsAppTable $documentsAppTable)
    {
        $this->documentsAppTable = $documentsAppTable;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined for collections');
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
     * Fetch all or a subset of resources.
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $userData = $params['userData'] ?? null;
        $typeDocument = $params['typeDocument'] ?? null;

        if ($userData && $typeDocument) {
            $resultSet = $this->documentsAppTable->getByUserDataAndType($userData, $typeDocument);
        } elseif ($typeDocument) {
            $resultSet = $this->documentsAppTable->getByTypeDocument($typeDocument);
        } else {
            $resultSet = $this->documentsAppTable->getAll();
        }

        $documentos = [];
        foreach ($resultSet as $documento) {
            $documentos[] = $documento->getArrayCopy();
        }

        $response = new ApiResponse('', ApiResponse::SUCCESS, ['documentos' => $documentos]);
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
     * Actualiza unicamente la fecha de expiracion del documento.
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

        $expirationDate = $data['expirationDate'] ?? null;

        if (!$expirationDate) {
            $response = new ApiResponse('Falta la fecha de expiracion.', ApiResponse::ERROR);
            return $response->toHttpResponse();
        }

        $resultado = $this->documentsAppTable->updateExpirationDate((int) $id, $expirationDate);

        if ($resultado === 0) {
            return new ApiProblem(404, 'Documento no encontrado.');
        }

        $response = new ApiResponse('Fecha de expiracion actualizada correctamente.', ApiResponse::SUCCESS, [
            'Actualizacion' => $resultado
        ]);
        return $response->toHttpResponse();
    }
}