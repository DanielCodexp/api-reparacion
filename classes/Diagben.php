<?php

require 'vendor/autoload.php';


class Diagben
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
        $query = $this->db->prepare("SELECT * FROM tbDiagDet");
        $query->execute();
        $data = $query->fetchAll();
        $tbDiagDet = [];
        foreach ($data as $row) {
            $tbDiagDet[] = [
                "nIntDiag" => $row['nIntDiag'],
                "nFotDiag" => $row['nFotDiag'],
                "cNomDiag" => $row['cNomDiag'],
                "cObsDiag" => $row['cObsDiag'],
                "nIdDiag" => $row['nIdDiag'],
            ];
        }


        $query = $this->db->prepare("SELECT * FROM tbDiagGen");
        $query->execute();
        $data = $query->fetchAll();
        $array = [];
        foreach ($data as $row) {
            $array[] = [
                "nIdDiag" => $row['nIdDiag'],
                "nCveEmp" => $row['nCveEmp'],
                "nCveSrv" => $row['nCveSrv'],
                "nIdUni" => $row['nIdUni'],
                "cCveUni" => $row['cCveUni'],
                "cObsDiag" => $row['cObsDiag'],
                "cCveRea" => $row['cCveRea'],
                "cCveMec" => $row['cCveMec'],
                "cCveSup" => $row['cCveSup'],
                "dtFecReg" => $row['dtFecReg'],
                "nEdoDig" => $row['nEdoDig'],
                "tbDiagDet" => $tbDiagDet
            ];
        }

        Flight::json([
            "total_rows" => $query->rowCount(),
            "rows" => $array,
        ]);

    }

    function createReport()
    {
        $nCveEmp = Flight::request()->data->nCveEmp;
        $nCveSrv = Flight::request()->data->nCveSrv;
        $nIdUni = Flight::request()->data->nIdUni;
        $cCveUni = Flight::request()->data->cCveUni;
        $cObsDiag = Flight::request()->data->cObsDiag;
        $cCveRea = Flight::request()->data->cCveRea;
        $cCveMec = Flight::request()->data->cCveMec;
        $cCveSup = Flight::request()->data->cCveSup;
        $dtFecReg = Flight::request()->data->dtFecReg;
        $nEdoDig = Flight::request()->data->nEdoDig;

        $query = $this->db->prepare("INSERT INTO tbDiagGen (nCveEmp, nCveSrv, nIdUni, cCveUni, cObsDiag, cCveRea, cCveMec, cCveSup, dtFecReg, nEdoDig) 
        VALUES (:nCveEmp, :nCveSrv, :nIdUni, :cCveUni, :cObsDiag, :cCveRea, :cCveMec, :cCveSup, :dtFecReg, :nEdoDig)");


        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];

        if (
            $query->execute([
                ":nCveEmp" => $nCveEmp,
                ":nCveSrv" => $nCveSrv,
                ":nIdUni" => $nIdUni,
                ":cCveUni" => $cCveUni,
                ":cObsDiag" => $cObsDiag,
                ":cCveRea" => $cCveRea,
                ":cCveMec" => $cCveMec,
                ":cCveSup" => $cCveSup,
                ":dtFecReg" => $dtFecReg,
                ":nEdoDig" => $nEdoDig
            ])
        ) {
            $array = [
                "data" => [
                    "nIdDiag" => $this->db->lastInsertId(),
                    "nCveEmp" => $nCveEmp,
                    "nCveSrv" => $nCveSrv,
                    "nIdUni" => $nIdUni,
                    "cCveUni" => $cCveUni,
                    "cObsDiag" => $cObsDiag,
                    "cCveRea" => $cCveRea,
                    "cCveMec" => $cCveMec,
                    "cCveSup" => $cCveSup,
                    "dtFecReg" => $dtFecReg,
                    "nEdoDig" => $nEdoDig,

                ],
                "status" => "success"
            ];
        }

        Flight::json($array);

    }


}