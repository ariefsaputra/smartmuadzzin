<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Tv::index');                // layar TV publik
$routes->get('tv/overlay/(:segment)', 'Tv::overlay/$1'); // overlay adzan/iqamah

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {

    // Pengumuman
    $routes->get('pengumuman',                'Pengumuman::index');
    $routes->get('pengumuman/create',         'Pengumuman::create');
    $routes->post('pengumuman/store',         'Pengumuman::store');

    $routes->get('pengumuman/edit/(:num)',    'Pengumuman::edit/$1');
    $routes->post('pengumuman/update/(:num)', 'Pengumuman::update/$1');

    $routes->get('pengumuman/delete/(:num)',  'Pengumuman::delete/$1');

});

$routes->get('admin', 'Admin::dashboard');     // panel admin minimal
$routes->match(['get', 'post'], 'admin/jadwal', 'Admin::jadwal');
$routes->get('admin/jadwal/sync', 'Admin::syncJadwal');

$routes->get('api/sync', 'ApiSync::sync');     // cron / manual sync
$routes->get('api/jadwal/(:segment)', 'Tv::jadwalJson/$1'); // json jadwal date
$routes->post('admin/api/check', 'Admin::checkApi');

//admin Pengaturan
$routes->get('admin/pengaturan', 'Admin::pengaturan');
$routes->post('admin/pengaturan/save', 'Admin::savePengaturan');

// admin media slider
$routes->group('admin/media', function ($r) {
    $r->get('/', 'Media::index');
    $r->get('create', 'Media::create');
    $r->post('store', 'Media::store');
    $r->get('edit/(:num)', 'Media::edit/$1');
    $r->post('update/(:num)', 'Media::update/$1');
    $r->get('delete/(:num)', 'Media::delete/$1');
    $r->post('reorder', 'Media::reorder'); // drag & drop
});
