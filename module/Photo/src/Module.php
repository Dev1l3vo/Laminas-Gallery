<?php 
namespace Photo;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\PhotoTable::class => function($container) {
                    $tableGateway = $container->get(Model\PhotoTableGateway::class);
                    return new Model\PhotoTable($tableGateway);
                },
                Model\PhotoTableGateway::class => function ($container) {
                    $dbAdapter =  new Adapter([ 
                        'driver'   => 'Mysqli',
                        'database' => 'gallery',
                        'username' => 'root',
                        'password' => 'test23']);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Photo());
                    return new TableGateway ('pictures', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\PhotoController::class => function($container) {
                    return new Controller\PhotoController(
                        $container->get(Model\PhotoTable::class)
                    );
                },
            ],
        ];
    }

}