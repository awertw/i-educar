<<<<<<< HEAD
<?php

class Educacenso_Model_OrgaoRegional extends CoreExt_Entity
{
    protected $_data = [
        'sigla_uf' => null,
        'codigo' => null,
    ];

    protected $_dataTypes = [
        'sigla_uf' => 'string',
        'codigo' => 'string',
    ];

    public function getDefaultValidatorCollection()
    {
        return [];
    }

    public function __toString()
    {
        return $this->codigo;
    }
}
=======
<?php

class Educacenso_Model_OrgaoRegional extends CoreExt_Entity implements \Stringable
{
    protected $_data = [
        'sigla_uf' => null,
        'codigo' => null,
    ];

    protected $_dataTypes = [
        'sigla_uf' => 'string',
        'codigo' => 'string',
    ];

    public function getDefaultValidatorCollection()
    {
        return [];
    }

    public function __toString(): string
    {
        return $this->codigo;
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
