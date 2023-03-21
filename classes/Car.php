<?php

require 'vendor/autoload.php';



class Car
{
    private $db;
    function __construct()
    {
        Flight::register(
            'db',
            'PDO',
            array('mysql:host=' . $_ENV["DB_HOST"] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'])
        );
        $this->db = Flight::db();
    }

    function getAll () {
        $query = $this->db->prepare("SELECT * FROM tbcarunidad");
        $query->execute();
        $data = $query->fetchAll();
        $array = [];
        foreach ($data as $row) {
            $array[] = [
                "nCveReg" => $row['nCveReg'],
                "nIdeUni" => $row['nIdeUni'],
                "nCveSrv" => $row['nCveSrv'],
                "nCveEmpPer" => $row['nCveEmpPer'],
                "nCveEmp" => $row['nCveEmp'],
                "cCveUniAnt" => $row['cCveUniAnt'],
                "cCveUni" => $row['cCveUni'],
                "dtFecAdq" => $row['dtFecAdq'],
                "cDesZon" => $row['cDesZon'],
                "cCodRut" => $row['cCodRut'],
                "nEdoUni" => $row['nEdoUni'],
                "nModUni" => $row['nModUni'],
                "cSerUni" => $row['cSerUni'],
                "cMotor" => $row['cMotor'],
                "cMcaMot" => $row['cMcaMot'],
                "cTipMot" => $row['cTipMot'],
                "cDesHP" => $row['cDesHP'],
                "cDesCar" => $row['cDesCar'],
                "cTipCar" => $row['cTipCar'],
            ];
        }
        Flight::json([
            "total_rows" => $query->rowCount(),
            "cars" => $array,
        ]);
    }

    function getID($nIdeUni) {
        $query = $this->db->prepare("SELECT * FROM tbcarunidad WHERE nIdeUni = :nIdeUni");
        $query->execute([":nIdeUni" => $nIdeUni]);
        $data = $query->fetch();
        $array[] = [
            "nCveReg" => $data['nCveReg'],
            "nIdeUni" => $data['nIdeUni'],
            "nCveSrv" => $data['nCveSrv'],
            "nCveEmpPer" => $data['nCveEmpPer'],
            "nCveEmp" => $data['nCveEmp'],
            "cCveUniAnt" => $data['cCveUniAnt'],
            "cCveUni" => $data['cCveUni'],
            "dtFecAdq" => $data['dtFecAdq'],
            "cDesZon" => $data['cDesZon'],
            "cCodRut" => $data['cCodRut'],
            "nEdoUni" => $data['nEdoUni'],
            "nModUni" => $data['nModUni'],
            "cSerUni" => $data['cSerUni'],
            "cMotor" => $data['cMotor'],
            "cMcaMot" => $data['cMcaMot'],
            "cTipMot" => $data['cTipMot'],
            "cDesHP" => $data['cDesHP'],
            "cDesCar" => $data['cDesCar'],
            "cTipCar" => $data['cTipCar'],
        ];
        Flight::json($array);
    }



}

