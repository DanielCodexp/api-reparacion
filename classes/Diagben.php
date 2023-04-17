<?php

require 'vendor/autoload.php';


class Diagben
{
    private $db;
    private$image;
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
        $query = $this->db->prepare("SELECT * FROM tbdiaggen");
        $query->execute();
        $data = $query->fetchAll();
        $array = [];
        foreach ($data as $row) {
            $array[] = [
                "nIdDiag" => $row['nIdDiag'],
                "cCveMec" => $row['cCveMec'],
                "cCveRea" => $row['cCveRea'],
                "cCveSup" => $row['cCveSup'],
                "cDesCar" => $row['cDesCar'],
                "cDesTras" => $row['cDesTras'],
                "cMcaMot" => $row['cMcaMot'],
                "cObsDiag" => $row['cObsDiag'],
                "cDesHP" => $row['cDesHP'],
                "dtFecReg" => $row['dtFecReg'],
                "dtHorReg" => $row['dtHorReg'],
                "cDesFall" => $row['cDesFall'],
                "nCveEmp" => $row['nCveEmp'],
                "nCveSrv" => $row['nCveSrv'],
                "nIdeUni" => $row['nIdeUni'],
                "cTipCar" => $row['cTipCar'],
                "cTipMot" => $row['cTipMot'],
                "nModUni" => $row['nModUni'],
            ];
        }

        Flight::json([
            "reports" => $array,
        ]);
    }

    function createDiagGen()
    {
        $cCveMec = Flight::request()->data->cCveMec;
        $cCveRea = Flight::request()->data->cCveRea;
        $cCveSup = Flight::request()->data->cCveSup;
        $cDesCar = Flight::request()->data->cDesCar;
        $cDesTras = Flight::request()->data->cDesTras;
        $cMcaMot = Flight::request()->data->cMcaMot;
        $cObsDiag = Flight::request()->data->cObsDiag;
        $cDesHP = Flight::request()->data->cDesHP;
        $dtFecReg = Flight::request()->data->dtFecReg;
        $dtHorReg = Flight::request()->data->dtHorReg;
        $cDesFall = Flight::request()->data->cDesFall;
        $nCveEmp = Flight::request()->data->nCveEmp;
        $nCveSrv = Flight::request()->data->nCveSrv;
        $nIdeUni = Flight::request()->data->nIdeUni;
        $cTipMot = Flight::request()->data->cTipMot;
        $cTipCar = Flight::request()->data->cTipCar;
        $nModUni = Flight::request()->data->nModUni;

        $query = $this->db->prepare("INSERT INTO tbdiaggen (cCveMec, cCveRea, cCveSup, cDesCar, cDesTras, cMcaMot, cObsDiag, cDesHP, dtFecReg, dtHorReg, cDesFall, nCveEmp, nCveSrv, nIdeUni, cTipMot, cTipCar, nModUni) 
        VALUES (:cCveMec, :cCveRea, :cCveSup, :cDesCar, :cDesTras, :cMcaMot, :cObsDiag, :cDesHP, :dtFecReg, :dtHorReg, :cDesFall, :nCveEmp, :nCveSrv, :nIdeUni, :cTipMot, :cTipCar, :nModUni)");


        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];

        if (
            $query->execute([
                ":cCveMec" => $cCveMec,
                ":cCveRea" => $cCveRea,
                ":cCveSup" => $cCveSup,
                ":cDesCar" => $cDesCar,
                ":cDesTras" => $cDesTras,
                ":cMcaMot" => $cMcaMot,
                ":cObsDiag" => $cObsDiag,
                ":cDesHP" => $cDesHP,
                ":dtFecReg" => $dtFecReg,
                ":dtHorReg" => $dtHorReg,
                ":cDesFall" => $cDesFall,
                ":nCveEmp" => $nCveEmp,
                ":nCveSrv" => $nCveSrv,
                ":nIdeUni" => $nIdeUni,
                ":cTipMot" => $cTipMot,
                ":cTipCar" => $cTipCar,
                ":nModUni" => $nModUni,


            ])
        ) {
            $array = [
                "data" => [
                    "nIdDiag" => $this->db->lastInsertId(),
                    "cCveMec" => $cCveMec,
                    "cCveRea" => $cCveRea,
                    "cCveSup" => $cCveSup,
                    "cDesCar" => $cDesCar,
                    "cDesTras" => $cDesTras,
                    "cMcaMot" => $cMcaMot,
                    "cObsDiag" => $cObsDiag,
                    "cDesHP" => $cDesHP,
                    "dtFecReg" => $dtFecReg,
                    "dtHorReg" => $dtHorReg,
                    "cDesFall" => $cDesFall,
                    "nCveEmp" => $nCveEmp,
                    "nCveSrv" => $nCveSrv,
                    "nIdeUni" => $nIdeUni,
                    "cTipMot" => $cTipMot,
                    "cTipCar" => $cTipCar,
                    "nModUni" => $nModUni,

                ],
                "status" => "success"
            ];
        }

        Flight::json($array);
    }
    function getByID($nIdDiag)
    {
        
        $query = $this->db->prepare("SELECT * FROM tbdiaggen WHERE nIdDiag = :nIdDiag");
        $query->execute([":nIdDiag" => $nIdDiag]);
        $principal = $query->fetch();

        $array[] = [
            "nIdDiag" => $principal['nIdDiag'],
            "cCveMec" => $principal['cCveMec'],
            "cCveRea" => $principal['cCveRea'],
            "cCveSup" => $principal['cCveSup'],
            "cDesCar" => $principal['cDesCar'],
            "cDesTras" => $principal['cDesTras'],
            "cMcaMot" => $principal['cMcaMot'],
            "cObsDiag" => $principal['cObsDiag'],
            "cDesHP" => $principal['cDesHP'],
            "dtFecReg" => $principal['dtFecReg'],
            "dtHorReg" => $principal['dtHorReg'],
            "cDesFall" => $principal['cDesFall'],
            "nCveEmp" => $principal['nCveEmp'],
            "nCveSrv" => $principal['nCveSrv'],
            "nIdeUni" => $principal['nIdeUni'],
            "cTipCar" => $principal['cTipCar'],
            "cTipMot" => $principal['cTipMot'],
            "nModUni" => $principal['nModUni'],
            //"tbDiagDet" => $this->image
        ];

        Flight::json($array);
        
    }
    
    function edit( $nIdDiag){
        // $nIdDiag = Flight:: request()->data->nIdDiag;
        $cCveMec = Flight::request()->data->cCveMec;
        $cCveRea = Flight::request()->data->cCveRea;
        $cCveSup = Flight::request()->data->cCveSup;
        $cDesCar = Flight::request()->data->cDesCar;
        $cDesTras = Flight::request()->data->cDesTras;
        $cMcaMot = Flight::request()->data->cMcaMot;
        $cObsDiag = Flight::request()->data->cObsDiag;
        $cDesHP = Flight::request()->data->cDesHP;
        $dtFecReg = Flight::request()->data->dtFecReg;
        $dtHorReg = Flight::request()->data->dtHorReg;
        $cDesFall = Flight::request()->data->cDesFall;
        $nCveEmp = Flight::request()->data->nCveEmp;
        $nCveSrv = Flight::request()->data->nCveSrv;
        $nIdeUni = Flight::request()->data->nIdeUni;
        $cTipMot = Flight::request()->data->cTipMot;
        $cTipCar = Flight::request()->data->cTipCar;
        $nModUni = Flight::request()->data->nModUni;

        $query = $this->db->prepare("UPDATE tbdiaggen SET cCveMec = :cCveMec, cCveRea = :cCveRea, cCveSup = :cCveSup, cDesCar = :cDesCar,
        cDesTras = :cDesTras, cMcaMot = :cMcaMot, cObsDiag = :cObsDiag, cDesHP = :cDesHP, dtFecReg = :dtFecReg, dtHorReg = :dtHorReg, 
        cDesFall = :cDesFall, nCveEmp = :nCveEmp, nCveSrv = :nCveSrv, nIdeUni = :nIdeUni, cTipMot = :cTipMot, cTipCar = :cTipCar, nModUni = :nModUni WHERE nIdDiag = :nIdDiag   ");


        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];

        if (
            $query->execute([
                "nIdDiag" => $nIdDiag,
                ":cCveMec" => $cCveMec,
                ":cCveRea" => $cCveRea,
                ":cCveSup" => $cCveSup,
                ":cDesCar" => $cDesCar,
                ":cDesTras" => $cDesTras,
                ":cMcaMot" => $cMcaMot,
                ":cObsDiag" => $cObsDiag,
                ":cDesHP" => $cDesHP,
                ":dtFecReg" => $dtFecReg,
                ":dtHorReg" => $dtHorReg,
                ":cDesFall" => $cDesFall,
                ":nCveEmp" => $nCveEmp,
                ":nCveSrv" => $nCveSrv,
                ":nIdeUni" => $nIdeUni,
                ":cTipMot" => $cTipMot,
                ":cTipCar" => $cTipCar,
                ":nModUni" => $nModUni,
            ])
        ) {
            $array = [
                "data" => [
                    "nIdDiag" =>$nIdDiag,
                    "cCveMec" => $cCveMec,
                    "cCveRea" => $cCveRea,
                    "cCveSup" => $cCveSup,
                    "cDesCar" => $cDesCar,
                    "cDesTras" => $cDesTras,
                    "cMcaMot" => $cMcaMot,
                    "cObsDiag" => $cObsDiag,
                    "cDesHP" => $cDesHP,
                    "dtFecReg" => $dtFecReg,
                    "dtHorReg" => $dtHorReg,
                    "cDesFall" => $cDesFall,
                    "nCveEmp" => $nCveEmp,
                    "nCveSrv" => $nCveSrv,
                    "nIdeUni" => $nIdeUni,
                    "cTipMot" => $cTipMot,
                    "cTipCar" => $cTipCar,
                    "nModUni" => $nModUni,

                ],
                "status" => "success"
            ];
        }

        Flight::json($array);
    }

}
