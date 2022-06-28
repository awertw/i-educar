<<<<<<< HEAD
<?php

return new class extends clsCadastro {
    public $cod_rota;

    public function Inicializar()
    {
        $retorno = 'Novo';

        $this->cod_rota=$_GET['cod_rota'];

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(578, $this->pessoa_logada, 7, "transporte_itinerario_cad.php?cod_rota={$this->cod_rota}");

        $obj  = new clsModulesItinerarioTransporteEscolar();
        $excluiu = $obj->excluirTodos($this->cod_rota);

        if ($excluiu) {
            echo "<script>
                window.location='transporte_rota_det.php?cod_rota={$this->cod_rota}';
                </script>";
        }

        die();

        return;
    }

    public function Gerar()
    {
    }

    public function Novo()
    {
    }

    public function Excluir()
    {
    }

    public function Formular()
    {
        $this->title = 'Itinerário';
        $this->processoAp = '21238';
    }
};
=======
<?php

return new class extends clsCadastro {
    public $cod_rota;

    public function Inicializar()
    {
        $this->cod_rota=$_GET['cod_rota'];

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(578, $this->pessoa_logada, 7, "transporte_itinerario_cad.php?cod_rota={$this->cod_rota}");

        $obj  = new clsModulesItinerarioTransporteEscolar();
        $excluiu = $obj->excluirTodos($this->cod_rota);

        if ($excluiu) {
            echo "<script>
                window.location='transporte_rota_det.php?cod_rota={$this->cod_rota}';
                </script>";
        }
        die();
    }

    public function Gerar()
    {
    }

    public function Novo()
    {
    }

    public function Excluir()
    {
    }

    public function Formular()
    {
        $this->title = 'Itinerário';
        $this->processoAp = '21238';
    }
};
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
