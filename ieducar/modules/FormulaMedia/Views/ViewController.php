<<<<<<< HEAD
<?php

class ViewController extends Core_Controller_Page_ViewController
{
    protected $_dataMapper = 'FormulaMedia_Model_FormulaDataMapper';
    protected $_titulo     = 'Detalhes da fórmula de cálculo de média';
    protected $_processoAp = 948;
    protected $_tableMap   = [
    'Nome' => 'nome',
    'Fórmula de cálculo' => 'formulaMedia',
    'Tipo de fórmula' => 'tipoFormula',
  ];

    protected function _preRender()
    {
        parent::_preRender();

        $this->breadcrumb('Detalhe da f&oacute;rmula de m&eacute;dia', [
        url('intranet/educar_index.php') => 'Escola',
    ]);
    }
}
=======
<?php

class ViewController extends Core_Controller_Page_ViewController
{
    protected $_dataMapper = 'FormulaMedia_Model_FormulaDataMapper';
    protected $_titulo     = 'Detalhes da fórmula de cálculo de média';
    protected $_processoAp = 948;
    protected $_tableMap   = [
    'Nome' => 'nome',
    'Fórmula de cálculo' => 'formulaMedia',
    'Tipo de fórmula' => 'tipoFormula',
  ];

    protected function _preRender()
    {
        parent::_preRender();

        $this->breadcrumb('Detalhe da fórmula de média', [
        url('intranet/educar_index.php') => 'Escola',
    ]);
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
