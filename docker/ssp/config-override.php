<?php

declare(strict_types=1);

$config['module.enable']['exampleauth'] = true;
$config['module.enable']['oidc'] = true;
// Have preprod warning enabled (though it may not be installed) to ease authproc redirect testing
$config['module.enable']['preprodwarning'] = true;
$config = [
        'secretsalt' => 'testsalt',
        'database.dsn' => 'sqlite:/var/simplesamlphp/data/mydb.sq3',
        'database.username' => 'user',
        'database.password' => 'password',
        'language.i18n.backend' => 'gettext/gettext',
        'logging.level' => 7,
        'usenewui' => false,
    ] + $config;