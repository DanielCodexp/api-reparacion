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

    function getAll()
    {
        $query = $this->db->prepare("SELECT * FROM tbCarUnidad");
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

    function getID($cCveUni)
    {
        $query = $this->db->prepare("SELECT * FROM tbCarUnidad WHERE cCveUni = :cCveUni");
        $query->execute([":cCveUni" => $cCveUni]);
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

    function newCar()
    {

        $nIdeUni = Flight::request()->data->nIdeUni;
        $nCveSrv = Flight::request()->data->nCveSrv;
        $nCveEmpPer = Flight::request()->data->nCveEmpPer;
        $nCveEmp = Flight::request()->data->nCveEmp;
        $cCveUniAnt = Flight::request()->data->cCveUniAnt;
        $cCveUni = Flight::request()->data->cCveUni;
        $dtFecAdq = Flight::request()->data->dtFecAdq;
        $cDesZon = Flight::request()->data->cDesZon;
        $cCodRut = Flight::request()->data->cCodRut;
        $nEdoUni = Flight::request()->data->nEdoUni;
        $nModUni = Flight::request()->data->nModUni;
        $cSerUni = Flight::request()->data->cSerUni;
        $cMotor = Flight::request()->data->cMotor;
        $cMcaMot = Flight::request()->data->cMcaMot;
        $cTipMot = Flight::request()->data->cTipMot;
        $cDesHP = Flight::request()->data->cDesHP;
        $cDesCar = Flight::request()->data->cDesCar;
        $cTipCar = Flight::request()->data->cTipCar;

        $query = $this->db->prepare("INSERT INTO tbCarUnidad
        (nIdeUni,nCveSrv,nCveEmpPer,nCveEmp,cCveUniAnt,cCveUni,dtFecAdq,cDesZon,cCodRut,nEdoUni,nModUni,cSerUni,cMotor,cMcaMot,cTipMot,cDesHP,cDesCar,cTipCar )
        values (:nIdeUni,:nCveSrv,:nCveEmpPer,:nCveEmp,:cCveUniAnt,:cCveUni,:dtFecAdq,:cDesZon,:cCodRut,:nEdoUni,:nModUni,:cSerUni,:cMotor,:cMcaMot,:cTipMot,:cDesHP,:cDesCar,:cTipCar)
        ");

        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];

        if($query->execute([":nIdeUni" => $nIdeUni,":nCveSrv" => $nCveSrv,":nCveEmpPer" => $nCveEmpPer,":nCveEmp" => $nCveEmp,":cCveUniAnt" => $cCveUniAnt,":cCveUni" => $cCveUni,":dtFecAdq" => $dtFecAdq,":cDesZon" => $cDesZon,":cCodRut" => $cCodRut,":nEdoUni" => $nEdoUni,":nModUni" => $nModUni,":cSerUni" => $cSerUni,":cMotor" => $cMotor,":cMcaMot" => $cMcaMot,":cTipMot"=>$cTipMot,":cDesHP"=>$cDesHP,":cDesCar" => $cDesCar,":cTipCar" => $cTipCar])) {


        $array = [
            "data" => [
                "nCveReg" =>$this->db->lastInsertId(),
                "nIdeUni" =>$nIdeUni,
                "nCveSrv" =>$nCveSrv,
                "nCveEmpPer" =>$nCveEmpPer,
                "nCveEmp" =>$nCveEmp,
                "cCveUniAnt" =>$cCveUniAnt,
                "cCveUni" =>$cCveUni,
                "dtFecAdq" =>$dtFecAdq,
                "cDesZon" =>$cDesZon,
                "cCodRut" =>$cCodRut,
                "nEdoUni" =>$nEdoUni,
                "nModUni" =>$nModUni,
                "cSerUni" =>$cSerUni,
                "cMotor" =>$cMotor,
                "cMcaMot" =>$cMcaMot,
                "cTipMot" =>$cTipMot,
                "cDesHP" =>$cDesHP,
                "cDesCar" =>$cDesCar,
                "cTipCar" =>$cTipCar,
            ],
            "status" => "success"
        ];
    }
    Flight::json($array);
    }
    
}
