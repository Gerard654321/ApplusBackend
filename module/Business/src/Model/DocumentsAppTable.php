<?php

namespace Business\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Select;

/**
 * Description of DocumentsAppTable
 *
 * @author gcaldas
 */
class DocumentsAppTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Devuelve todos los documentos
     *
     * @return ResultSetInterface
     */
    public function getAll(): ResultSetInterface
    {
        return $this->tableGateway->select();
    }

    /**
     * Devuelve un documento en base al id del documento
     *
     * @param int $idDoc
     * @return ResultSetInterface
     */
    public function getById(int $idDoc): ResultSetInterface
    {
        return $this->tableGateway->select(['ID_DOC' => $idDoc]);
    }

    /**
     * Devuelve los distintos tipos de documentos registrados
     *
     * @return ResultSetInterface
     */
    public function getTypeDocuments(): ResultSetInterface
    {
        return $this->tableGateway->select(function (Select $select) {
            $select->columns(['TYPE_DOCUMENTS'])
                ->quantifier(Select::QUANTIFIER_DISTINCT);
        });
    }

    /**
     * Edita solo el nombre, la descripcion, el estado y la fecha de expiración de un documento existente
     *
     * @param int $idDoc
     * @param DocumentsAppEntity $documento
     * @return int Filas afectadas
     */
    public function editDocument(int $idDoc, DocumentsAppEntity $documento): int
    {
        $data = [
            'NAME_DOC'        => $documento->NAME_DOC,
            'DESCRIPTION_DOC' => $documento->DESCRIPTION_DOC,
            'STATUS'          => $documento->STATUS,
            'EXPIRATION_DATE' => $documento->EXPIRATION_DATE,
        ];

        return $this->tableGateway->update($data, ['ID_DOC' => $idDoc]);
    }
}