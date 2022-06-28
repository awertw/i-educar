<<<<<<< HEAD
<?php

class Portabilis_View_Helper_DynamicInput_Transferido extends Portabilis_View_Helper_DynamicInput_CoreSelect
{
    protected function inputName()
    {
        return 'ref_cod_matricula';
    }

    protected function inputOptions($options)
    {
        return $this->insertOption(null, 'Selecione uma matr&iacute;cula', $resources);
    }

    protected function defaultOptions()
    {
        return ['options' => ['label' => 'Matr&iacute;cula']];
    }

    public function transferido($options = [])
    {
        parent::select($options);
    }
}
=======
<?php

class Portabilis_View_Helper_DynamicInput_Transferido extends Portabilis_View_Helper_DynamicInput_CoreSelect
{
    protected function inputName()
    {
        return 'ref_cod_matricula';
    }

    protected function inputOptions($options)
    {
        return $this->insertOption(null, 'Selecione uma matrícula', $resources);
    }

    protected function defaultOptions()
    {
        return ['options' => ['label' => 'Matrícula']];
    }

    public function transferido($options = [])
    {
        parent::select($options);
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
