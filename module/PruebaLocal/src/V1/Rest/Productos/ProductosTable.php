<?php
namespace PruebaLocal\V1\Rest\Productos;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class ProductosTable
{
    /** @var TableGatewayInterface */
    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll(array $where = [])
    {
        return $this->tableGateway->select($where);
    }

    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(['id' => (int) $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('No se encontró el producto con id %d', $id));
        }

        return $row;
    }

    public function save(ProductosEntity $producto)
    {
        $data = [
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
        ];

        $id = $producto->getId();

        if (! $id) {
            $this->tableGateway->insert($data);
            $producto->exchangeArray(
                ['id' => $this->tableGateway->getLastInsertValue()] + $data
            );
            return $producto;
        }

        $this->fetch($id);
        $this->tableGateway->update($data, ['id' => (int) $id]);

        return $this->fetch($id);
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
