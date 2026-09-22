<?php

/*
 *  Copyright (C) 2026 - GCode Software.
 *  Departamento de tecnologias de Informacion - TI
 *  gcaldas - 22 sept. 2026
 */

namespace Business\Model;

class DocumentsAppEntity
{
    public $ID_DOC;
    public $NAME_DOC;
    public $EXPIRATION_DATE;
    public $USER_DATA;
    public $DOCUMENT_PDF;
    public $ROUTE_DOCUMENT;
    public $TYPE_DOCUMENT;

    public function exchangeArray(array $data)
    {
        $this->ID_DOC = $data['ID_DOC'] ?? null;
        $this->NAME_DOC = $data['NAME_DOC'] ?? null;
        $this->EXPIRATION_DATE = $data['EXPIRATION_DATE'] ?? null;
        $this->USER_DATA = $data['USER_DATA'] ?? null;
        $this->DOCUMENT_PDF = $data['DOCUMENT_PDF'] ?? null;
        $this->ROUTE_DOCUMENT = $data['ROUTE_DOCUMENT'] ?? null;
        $this->TYPE_DOCUMENT = $data['TYPE_DOCUMENT'] ?? null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}