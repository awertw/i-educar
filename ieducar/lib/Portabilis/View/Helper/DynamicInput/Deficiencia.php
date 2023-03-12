<?php

class Portabilis_View_Helper_DynamicInput_Deficiencia extends Portabilis_View_Helper_DynamicInput_CoreSelect
{    
    protected function inputOptions($options)
    {
        $resources = $options['resources'];

        $sql = 'select cod_deficiencia, nm_deficiencia from cadastro.deficiencia';

        $resources = Portabilis_Utils_Database::fetchPreparedQuery($sql);
        $resources = Portabilis_Array_Utils::setAsIdValue($resources, 'cod_deficiencia', 'nm_deficiencia');

        return $this->insertOption(null, 'Selecione', $resources);
    }

    protected function defaultOptions()
    {
        return ['options' => ['label' => 'Deficiência']];
    }

    public function deficiencia($options = [])
    {
        parent::select($options);
    }
}