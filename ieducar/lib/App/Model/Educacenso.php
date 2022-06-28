<<<<<<< HEAD
<?php

class App_Model_Educacenso
{
    public static function etapas_multisseriadas()
    {
        return [3, 22, 23, 56, 64, 72];
    }

    public static function etapasEnsinoUnificadas()
    {
        return [3];
    }

    public static function etapasDaTurma($etapaEnsino)
    {
        $etapas = [];

        switch ($etapaEnsino) {
            case '3':
                $etapas = [1, 2];
                break;

            case '22':
            case '23':
                $etapas = [14, 15, 16, 17, 18, 19, 20, 21, 41];
                break;

            case '56':
                $etapas = [1, 2, 14, 15, 16, 17, 18, 19, 20, 21, 41];
                break;

            case '64':
                $etapas = [30, 40];
                break;

            case '72':
                $etapas = [69, 70];
                break;
        }

        return $etapas;
    }
}
=======
<?php

class App_Model_Educacenso
{
    public static function etapas_multisseriadas()
    {
        return [3, 22, 23, 56, 64, 72];
    }

    public static function etapasEnsinoUnificadas()
    {
        return [3];
    }

    public static function etapasDaTurma($etapaEnsino)
    {
        return match ((string)$etapaEnsino) {
            '3' => [1, 2],
            '22', '23' => [14, 15, 16, 17, 18, 19, 20, 21, 41],
            '56' => [1, 2, 14, 15, 16, 17, 18, 19, 20, 21, 41],
            '64' => [30, 40],
            '72' => [69, 70],
            default => [],
        };
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
