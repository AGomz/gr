<?php

class SearchController
{
    private $printer;
    private $searchModel;

    public function __construct($searchModel, $printer){
        $this->searchModel = $searchModel;
        $this->printer = $printer;
    }

    public function show($data = [])
    {
        echo $this->printer->render("view/searchView.html", $data);
    }

    public function execute()
    {
        //Este campo representa la opción de ida y vuelta
       // $tipoViaje = isset($_POST["tipoDeViaje"]) ? $_POST["tipoDeViaje"] : "";
        $origen = isset($_POST["origen"]) ? $_POST["origen"] : "";
        $destino = isset($_POST["destino"]) ? $_POST["destino"] : "";
        $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
        $nivelPasajero = isset($_POST["nivelPasajero"]) ? $_POST["nivelPasajero"] : "";
        $cabina = isset($_POST["cabina"]) ? $_POST["cabina"] : "";
        $servicio = isset($_POST["servicio"]) ? $_POST["servicio"] : "";

        if($origen && $destino){
            $datos = $this->searchModel->getDatosPor($origen, $destino);
        }
        if($origen && $destino && $fecha && $cabina){
            $datos = $this->searchModel->getDatos($origen, $destino, $fecha, $nivelPasajero, $cabina, $servicio);
        }

        $data = ["datos" => $datos];
        $this->show($data);

    }
}