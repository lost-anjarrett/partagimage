<?php
session_start();
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;


/**
 * Définition des routes :
 */

// INDEX
$app->get('/', 'Projet\Controllers\PageController::index'); // quand on charge index.php sans route définie
$app->match('home', 'Projet\Controllers\PageController::index');

// AUTHENTIFICATION
$app->match('register', 'Projet\Controllers\AuthController::register');
$app->match('login', 'Projet\Controllers\AuthController::login');
$app->match('logout', 'Projet\Controllers\AuthController::logout');

// POSTS
$app->match('post/create', 'Projet\Controllers\PostController::create');
$app->post('post/{id}/delete','Projet\Controllers\PostController::destroy')
    ->assert('id','\d+');  // La méthode destroy ne pourra etre appelée que via un envoi de formulaire
$app->post('post/{id}/edit','Projet\Controllers\PostController::update')
    ->assert('id','\d+');
$app->match('post/{id}','Projet\Controllers\PostController::show')
    ->assert('id','\d+');

// COMMENTS
$app->post('post/{id}/comment', 'Projet\Controllers\CommentController::create')
    ->assert('id','\d+');

// RATINGS
$app->post('post/{id}/rate', 'Projet\Controllers\RatingController::rate')
    ->assert('id','\d+');

// USER
$app->match('user/{id}', 'Projet\Controllers\UserController::show')
    ->assert('id','\d+');
$app->post('user/{id}/edit', 'Projet\Controllers\UserController::update')
    ->assert('id','\d+');


// RUN
$app->run();
