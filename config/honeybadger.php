<<<<<<< HEAD
<?php

return [
    'api_key' => env('HONEYBADGER_API_KEY'),
    'environment' => [
        'filter' => [],
        'include' => [],
    ],
    'request' => [
        'filter' => [],
    ],
    // 'version' => trim(exec('git log --pretty="%h" -n1 HEAD')),
    'version' => env('APP_VERSION'),
    'hostname' => gethostname(),
    'project_root' => base_path(),
    'environment_name' => config('app.env'),
    'handlers' => [
        'exception' => true,
        'error' => true,
    ],
    'client' => [
        'timeout' => 0,
        'proxy' => [],
    ],
    'excluded_exceptions' => [],
];
=======
<?php

use iEducar\Support\Exceptions\DisciplinesWithoutInformedHoursException;

return [
    'api_key' => env('HONEYBADGER_API_KEY'),
    'environment' => [
        'filter' => [],
        'include' => [],
    ],
    'request' => [
        'filter' => [],
    ],
    // 'version' => trim(exec('git log --pretty="%h" -n1 HEAD')),
    'version' => env('APP_VERSION'),
    'hostname' => gethostname(),
    'project_root' => base_path(),
    'environment_name' => config('app.env'),
    'handlers' => [
        'exception' => true,
        'error' => true,
    ],
    'client' => [
        'timeout' => 0,
        'proxy' => [],
    ],
    'excluded_exceptions' => [
        App_Model_Exception::class,
        DisciplinesWithoutInformedHoursException::class
    ],
];
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
