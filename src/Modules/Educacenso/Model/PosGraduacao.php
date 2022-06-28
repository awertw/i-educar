<<<<<<< HEAD
<?php

namespace iEducar\Modules\Educacenso\Model;

class PosGraduacao
{
    public const ESPECIALIZACAO = 1;
    public const MESTRADO = 2;
    public const DOUTORADO = 3;
    public const NAO_POSSUI = 4;

    public static function getDescriptiveValues()
    {
        return [
            self::ESPECIALIZACAO => 'Especialização',
            self::MESTRADO => 'Mestrado',
            self::DOUTORADO => 'Doutorado',
            self::NAO_POSSUI => 'Não tem pós-graduação concluída',
        ];
    }
}
=======
<?php

namespace iEducar\Modules\Educacenso\Model;

class PosGraduacao
{
    public const ESPECIALIZACAO = 1;
    public const MESTRADO = 2;
    public const DOUTORADO = 3;

    public static function getDescriptiveValues()
    {
        return [
            self::ESPECIALIZACAO => 'Especialização',
            self::MESTRADO => 'Mestrado',
            self::DOUTORADO => 'Doutorado',
        ];
    }
}
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
