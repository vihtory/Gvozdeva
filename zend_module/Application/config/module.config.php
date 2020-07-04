<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\OrderProductTable;
use Application\Model\OrderTable;
use Application\Model\SalerTable;
use Application\Model\StoreTable;
use Application\Model\ProductTable;
use Application\Model\StoreProductTable;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'index' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => 'index',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'magento' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '[/]magento[/:action]',
                    'defaults' => [
                        'controller' => Controller\MagentoController::class,
                        'action'     => 'store',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => function($container) {
                return new Controller\IndexController(
                    $container->get(SalerTable::class),
                    $container->get(StoreTable::class),
                    $container->get(ProductTable::class),
                    $container->get(StoreProductTable::class),
                    $container->get(OrderTable::class),
                    $container->get(OrderProductTable::class)
                );
            },
            Controller\MagentoController::class => function($container) {
                return new Controller\MagentoController(
                    $container->get(SalerTable::class),
                    $container->get(StoreTable::class),
                    $container->get(ProductTable::class),
                    $container->get(StoreProductTable::class),
                    $container->get(OrderTable::class),
                    $container->get(OrderProductTable::class)
                );
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
