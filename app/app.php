<?php

use Pagekit\Framework\Application;

$loader = require __DIR__.'/autoload.php';
$config = require __DIR__.'/config.php';

$app = new Application($config);
$app['autoloader'] = $loader;

date_default_timezone_set($app['config']['app.timezone']);

foreach ($app['config']['app.providers'] as $provider) {
    $app->register($provider);
}

try {

    class InstallerException extends RuntimeException {}

    if (!$app['config.file']) {
        throw new InstallerException('No config.');
    }

    $app['db']->connect();

    if (!$app['cache']->fetch('installed')) {

        if (!$app['db']->getSchemaManager()->tablesExist($app['db']->getPrefix().'system_option')) {
            throw new InstallerException('Not installed.');
        }

        $app['cache']->save('installed', true);
    }

    $app['extensions.boot'] = function($app) {
        return array_merge($app['config']->get('extension.core', array()), $app['option']->get('system:extensions', array()));
    };

} catch (InstallerException $e) {

    $requirements = require __DIR__.'/requirements.php';

    if ($failed = $requirements->getFailedRequirements()) {
        require $app['path.extensions'].'/installer/views/requirements.php';
        exit;
    }

    $app['config']->load(__DIR__.'/config/install.php');
    $app['extensions.boot'] = array('installer');

}

return $app;