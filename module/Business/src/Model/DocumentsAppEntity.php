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
    public $DESCRIPTION_DOC;
    public $STATUS;
    public $EXPIRATION_DATE;
    public $REGISTERED_USER;
    public $DOCUMENT_PDF;
    public $TYPE_DOCUMENTS;

    public function exchangeArray(array $data)
    {
        $this->ID_DOC = $data['ID_DOC'] ?? null;
        $this->NAME_DOC = $data['NAME_DOC'] ?? null;
        $this->DESCRIPTION_DOC = $data['DESCRIPTION_DOC'] ?? null;
        $this->STATUS = $data['STATUS'] ?? null;
        $this->EXPIRATION_DATE = $data['EXPIRATION_DATE'] ?? null;
        $this->REGISTERED_USER = $data['REGISTERED_USER'] ?? null;
        $this->DOCUMENT_PDF = $data['DOCUMENT_PDF'] ?? null;
        $this->TYPE_DOCUMENTS = $data['TYPE_DOCUMENTS'] ?? null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
