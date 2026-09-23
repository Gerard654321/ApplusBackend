<?php

namespace Business\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSetInterface;

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
     * Devuelve todos los documentos.
     *
     * @return ResultSetInterface
     */
    public function getAll(): ResultSetInterface
    {
        return $this->tableGateway->select();
    }

    /**
     * Devuelve un documento en base al ID_DOC.
     *
     * @param int $idDoc
     * @return ResultSetInterface
     */
    public function getById(int $idDoc): ResultSetInterface
    {
        return $this->tableGateway->select(['ID_DOC' => $idDoc]);
    }

    /**
     * Devuelve los documentos de un usuario filtrados por tipo de documento.
     *
     * @param string $userData
     * @param string $typeDocument
     * @return ResultSetInterface
     */
    public function getByUserDataAndType(string $userData, string $typeDocument): ResultSetInterface
    {
        return $this->tableGateway->select([
            'USER_DATA' => $userData,
            'TYPE_DOCUMENT' => $typeDocument,
        ]);
    }

    /**
     * Devuelve todos los documentos de un usuario.
     *
     * @param string $userData
     * @return ResultSetInterface
     */
    public function getByUserData(string $userData): ResultSetInterface
    {
        return $this->tableGateway->select(['USER_DATA' => $userData]);
    }

    /**
     * Devuelve los documentos de un tipo de documento determinado.
     *
     * @param string $typeDocument
     * @return ResultSetInterface
     */
    public function getByTypeDocument(string $typeDocument): ResultSetInterface
    {
        return $this->tableGateway->select(['TYPE_DOCUMENT' => $typeDocument]);
    }

    /**
     * Actualiza unicamente la fecha de expiracion de un documento.
     *
     * @param int $idDoc
     * @param string $expirationDate
     * @return int Filas afectadas
     */
    public function updateExpirationDate(int $idDoc, string $expirationDate): int
    {
        return $this->tableGateway->update(
            ['EXPIRATION_DATE' => $expirationDate],
            ['ID_DOC' => $idDoc]
        );
    }
}