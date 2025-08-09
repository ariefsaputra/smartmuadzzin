<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('pengaturan', function($routes) {
    $routes->get('load', 'PengaturanController::load');
    $routes->post('save', 'PengaturanController::save');
});

$routes->group('jadwal', function($routes) {
    $routes->get('sync/harian', 'JadwalController::syncHarian');
    $routes->get('sync/bulanan', 'JadwalController::syncBulanan');
    $routes->get('sync/tahunan', 'JadwalController::syncTahunan');
});

$routes->get('/sync-jadwal/(:segment)', 'Home::syncJadwal/$1');

$routes->group('admin', function($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->post('save-masjid', 'AdminController::saveMasjid');
    $routes->post('save-running-text', 'AdminController::saveRunningText');
    $routes->post('upload-slider', 'AdminController::uploadSlider');
    $routes->get('delete-slider/(:num)', 'AdminController::deleteSlider/$1');
});


