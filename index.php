<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require 'classes/User.php';
require 'classes/Diagben.php';

$users = new Users();

$diag = new Diagben();
//Apis Relacionadas con la tabla Users
Flight::route('GET /users', [$users,'getAll'] );
Flight::route('GET /users/@id', [$users,'getID']);
Flight::route('POST /users', [$users,'new']);
Flight::route('PUT /users', [$users,'edit']);
Flight::route('DELETE /users/@username', [$users,'delete']);
Flight::route('POST /auth', [$users,'auth']);

//Apis Relacionadas con la tabla tbdiagben
Flight::route('GET /diag',[$diag,'getAll']);


Flight::start();
