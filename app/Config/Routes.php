<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Tv::index');                // layar TV publik
$routes->post('api/sync', 'ApiSync::sync');    // cron: requires X-Sync-Token

$routes->get('admin/login', 'AdminAuth::login');
$routes->post('admin/login', 'AdminAuth::authenticate');

$routes->group('admin', ['filter' => 'adminauth'], function($routes) {
    $routes->get('', 'Admin::dashboard');
    $routes->post('logout', 'AdminAuth::logout');
    $routes->post('mode/(:segment)', 'Admin::changeMode/$1');
    $routes->match(['get', 'post'], 'jadwal', 'Admin::jadwal');
    $routes->post('jadwal/sync', 'Admin::syncJadwal');
    $routes->post('api/check', 'Admin::checkApi');
    $routes->get('pengaturan', 'Admin::pengaturan');
    $routes->post('pengaturan/save', 'Admin::savePengaturan');

    $routes->group('pengumuman', ['namespace' => 'App\Controllers\Admin'], function($routes) {
        $routes->get('',                'Pengumuman::index');
        $routes->get('create',         'Pengumuman::create');
        $routes->post('store',         'Pengumuman::store');
        $routes->get('edit/(:num)',    'Pengumuman::edit/$1');
        $routes->post('update/(:num)', 'Pengumuman::update/$1');
        $routes->post('delete/(:num)', 'Pengumuman::delete/$1');
    });

    $routes->group('media', function ($routes) {
        $routes->get('', 'Media::index');
        $routes->get('create', 'Media::create');
        $routes->post('store', 'Media::store');
        $routes->get('edit/(:num)', 'Media::edit/$1');
        $routes->post('update/(:num)', 'Media::update/$1');
        $routes->post('delete/(:num)', 'Media::delete/$1');
        $routes->post('reorder', 'Media::reorder');
    });
});

// Cron endpoint should be protected separately before enabling it in production.
