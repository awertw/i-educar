<<<<<<< HEAD
<?php

namespace iEducar\Modules\Educacenso\Model;

class Equipamentos
{
    public const COMPUTADORES = 1;
    public const IMPRESSORAS = 2;
    public const IMPRESSORAS_MULTIFUNCIONAIS = 3;
    public const COPIADORA = 4;
    public const SCANNER = 5;
    public const ANTENA_PARABOLICA = 6;

    public static function getDescriptiveValues()
    {
        return [
            self::COMPUTADORES => 'Computadores',
            self::IMPRESSORAS => 'Impressoras',
            self::IMPRESSORAS_MULTIFUNCIONAIS => 'Impressoras multifuncionais',
            self::COPIADORA => 'Copiadora',
            self::SCANNER => 'Scanner',
            self::ANTENA_PARABOLICA => 'Antena parabólica',
        ];
    }
}
=======
<?php

namespace iEducar\Modules\Educacenso\Model;

class Equipamentos
{
    public const COMPUTADORES = 1;
    public const IMPRESSORAS = 2;
    public const IMPRESSORAS_MULTIFUNCIONAIS = 3;
    public const COPIADORA = 4;
    public const SCANNER = 5;
    public const ANTENA_PARABOLICA = 6;
    public const NENHUM_EQUIPAMENTO_LISTADO = 7;

    public static function getDescriptiveValues()
    {
        return [
            self::COMPUTADORES => 'Computadores',
            self::IMPRESSORAS => 'Impressoras',
            self::IMPRESSORAS_MULTIFUNCIONAIS => 'Impressoras multifuncionais',
            self::COPIADORA => 'Copiadora',
            self::SCANNER => 'Scanner',
            self::ANTENA_PARABOLICA => 'Antena parabólica',
            self::NENHUM_EQUIPAMENTO_LISTADO => 'Nenhum dos equipamentos listados',
        ];
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
