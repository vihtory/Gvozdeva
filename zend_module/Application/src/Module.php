<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\SalerTable;
use Application\Model\SalerTableGateway;
use Application\Model\Saler;
use Application\Model\StoreTable;
use Application\Model\StoreTableGateway;
use Application\Model\Store;
use Application\Model\OrderTable;
use Application\Model\OrderTableGateway;
use Application\Model\Order;
use Application\Model\ProductTable;
use Application\Model\ProductTableGateway;
use Application\Model\Product;
use Application\Model\StoreProductTable;
use Application\Model\StoreProductTableGateway;
use Application\Model\StoreProduct;
use Application\Model\OrderProductTable;
use Application\Model\OrderProductTableGateway;
use Application\Model\OrderProduct;
use Application\Controller\IndexController;
use Application\Controller\MagentoController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    const VERSION = '3.1.3';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                SalerTable::class => function($container) {
                    $tableGateway = $container->get(SalerTableGateway::class);
                    return new SalerTable($tableGateway);
                },
                SalerTableGateway::class => function ($container) {
                    $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Saler());
                    return new TableGateway('salers', $dbAdapter, null, $resultSetPrototype);
                },
                StoreTable::class => function($container) {
                        $tableGateway = $container->get(StoreTableGateway::class);
                        return new StoreTable($tableGateway);
                },
                StoreTableGateway::class => function ($container) {
                        $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Store());
                        return new TableGateway('stores', $dbAdapter, null, $resultSetPrototype);
                },
                ProductTable::class => function($container) {
                    $tableGateway = $container->get(ProductTableGateway::class);
                    return new ProductTable($tableGateway);
                },
                ProductTableGateway::class => function ($container) {
                    $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Product());
                    return new TableGateway('products', $dbAdapter, null, $resultSetPrototype);
                },
                StoreProductTable::class => function($container) {
                    $tableGateway = $container->get(StoreProductTableGateway::class);
                    return new StoreProductTable($tableGateway);
                },
                StoreProductTableGateway::class => function ($container) {
                    $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new StoreProduct());
                    return new TableGateway('store_product', $dbAdapter, null, $resultSetPrototype);
                },
                OrderProductTable::class => function($container) {
                    $tableGateway = $container->get(OrderProductTableGateway::class);
                    return new OrderProductTable($tableGateway);
                },
                OrderProductTableGateway::class => function ($container) {
                    $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new OrderProduct());
                    return new TableGateway('order_product', $dbAdapter, null, $resultSetPrototype);
                },
                OrderTable::class => function($container) {
                    $tableGateway = $container->get(OrderTableGateway::class);
                    return new OrderTable($tableGateway);
                },
                OrderTableGateway::class => function ($container) {
                    $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Order());
                    return new TableGateway('orders', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                IndexController::class => function($container) {
                    return new IndexController(
                        $container->get(SalerTable::class),
                        $container->get(StoreTable::class),
                        $container->get(ProductTable::class),
                        $container->get(StoreProductTable::class),
                        $container->get(OrderTable::class),
                        $container->get(OrderProductTable::class)
                    );
                },
                MagentoController::class => function($container) {
                    return new IndexController(
                        $container->get(SalerTable::class),
                        $container->get(StoreTable::class),
                        $container->get(ProductTable::class),
                        $container->get(StoreProductTable::class),
                        $container->get(OrderTable::class),
                        $container->get(OrderProductTable::class)
                    );
                },
            ],
        ];
    }

}
