<<<<<<< HEAD
<?php

use iEducar\Modules\Enrollments\Model\EnrollmentStatusFilter;

class Portabilis_View_Helper_DynamicInput_SituacaoMatricula extends Portabilis_View_Helper_DynamicInput_CoreSelect
{
    protected function inputOptions($options)
    {
        $resources = EnrollmentStatusFilter::getDescriptiveValues();

        return $this->insertOption(10, 'Todas', $resources);
    }

    protected function defaultOptions()
    {
        return ['options' => ['label' => 'Situação']];
    }

    public function situacaoMatricula($options = [])
    {
        parent::select($options);
    }
}
=======
<?php

use iEducar\Modules\Enrollments\Model\EnrollmentStatusFilter;

class Portabilis_View_Helper_DynamicInput_SituacaoMatricula extends Portabilis_View_Helper_DynamicInput_CoreSelect
{
    protected function inputOptions($options)
    {
        $resources = EnrollmentStatusFilter::getDescriptiveValues();

        return $this->insertOption(EnrollmentStatusFilter::ALL, 'Todas', $resources);
    }

    protected function defaultOptions()
    {
        return ['options' => ['label' => 'Situação']];
    }

    public function situacaoMatricula($options = [])
    {
        parent::select($options);
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
