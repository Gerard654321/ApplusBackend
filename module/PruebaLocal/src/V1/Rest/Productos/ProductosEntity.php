<?php
namespace PruebaLocal\V1\Rest\Productos;

class ProductosEntity
{
    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $nombre;

    /** @var float|null */
    protected $precio;

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
        return $this;
    }

    public function exchangeArray(array $data)
    {
        $this->id     = $data['id'] ?? null;
        $this->nombre = $data['nombre'] ?? null;
        $this->precio = isset($data['precio']) ? (float) $data['precio'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
        ];
    }
}
