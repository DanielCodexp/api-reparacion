<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require 'classes/User.php';
require 'classes/Diagben.php';
require 'classes/Car.php';
require 'classes/Img.php';

$users = new Users();
$diag = new Diagben();
$car = new Car();
$img = new Img();

//Apis Relacionadas con la tabla Users
Flight::route('GET /users', [$users,'getAll'] );
Flight::route('GET /users/@id', [$users,'getID']);
Flight::route('POST /users', [$users,'new']);
Flight::route('PUT /users', [$users,'edit']);
Flight::route('DELETE /users/@username', [$users,'delete']);
Flight::route('POST /auth', [$users,'auth']);

//Apis Relacionadas con la tabla tbdiagben
Flight::route('GET /diag',[$diag,'getAll']);
Flight::route('POST /DiagGen',[$diag,'createDiagGen']);
Flight::route('POST /DiagDet',[$diag,'createDiagDet']);
Flight::route('GET /id/@id',[$diag, 'getByID']);
Flight::route('PUT /DiagGen/@nIdDiag',[$diag, 'edit']);

//Apis Relacionadas con la taba tbCarUnidad
Flight::route('GET /car',[$car,'getAll']);
Flight::route('GET /car/@id',[$car,'getID']);
Flight::route('POST /car',[$car,'newCar']);

//Api Relacionada con la tabla de tbImg
// Flight::route('POST /image',[$img,'guardar']);

Flight::route('POST /image',[$img,'guardar_imagenes']);

Flight::route('POST /img',[$img,'insert']);
Flight::route('GET /idDes',[$img, 'idDes']);
Flight::route('PUT /image',[$img,'edit']);
Flight::route('GET /image/@id', [$img, 'getByID']);

Flight::start();
