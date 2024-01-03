<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ShopController::index');
$routes->get('/shop/viewCart', 'ShopController::viewCart');
$routes->get('/shop/checkout', 'ShopController::checkout');
$routes->get('/shop/addProductToCart/(:num)', 'ShopController::addProductToCart/$1');
$routes->get('/shop/removeProductFromCart/(:num)', 'ShopController::removeProductFromCart/$1');
$routes->get('/shop/useVoucher', 'ShopController::useVoucher');
$routes->get('shop/cart', 'ShopController::cart');