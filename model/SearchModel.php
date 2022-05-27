<?php


class SearchModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    //Consulta de ejemplo: Luna hasta ISS
    public function getDatosPor($origen, $destino){
        $query = "select dd.descripcion as origen, d.descripcion as destino, t.FechaSalida as salida, t.FechaLlegada as llegada
        from destino d join 
        tramo t on d.id=t.DestinoID join
        destino dd on dd.id=t.OrigenID
        where d.nombre= \"$destino\" AND dd.nombre= \"$origen\" AND
        t.FechaSalida BETWEEN CURDATE() AND '2022-05-30 23:00:00'";

        return $this->database->query($query);
    }

    //Consulta de ejemplo: Bs.AS hasta la ISS, 18-05-22, turista
    public function getDatos($origen, $destino, $fecha, $servicio, $cabina, $nivelPasajero){

        $query = "SELECT DISTINCT dd.nombre AS origen, d.nombre AS destino, t.FechaSalida AS salida, t.FechaLlegada AS llegada,
		sb.nombre AS servicio, c.nombre AS cabina, t.precio AS precio, tv.nombre AS tipoVuelo, nv.nombre AS nivelVuelo
        FROM destino d JOIN
        tramo t ON d.id=t.DestinoID JOIN
        destino dd ON dd.id=t.OrigenID JOIN
        servicioabordo sb ON dd.id=sb.id JOIN
        equipo e ON sb.id=e.id JOIN
        capacidadcabina cap ON e.id=cap.CabinaID JOIN
        cabina c ON cap.CabinaID=c.id JOIN
        tipovuelo tv ON c.id=tv.id JOIN
        nivelvuelo nv ON tv.id=nv.id
        WHERE dd.nombre=\"$origen\" AND d.nombre=\"$destino\" AND DATE(t.fechaSalida)= \"$fecha\"
        AND c.nombre=\"$cabina\" ";

        return $this->database->query($query);
    }
}
/*
 *La consulta que pruebo desde MySQL y funciona:
 *SELECT DISTINCT dd.nombre AS origen, d.descripcion AS destino, t.FechaSalida AS salida, t.FechaLlegada AS llegada,
		sb.nombre AS servicio, c.nombre AS cabina, t.precio AS precio, tv.nombre AS tipoVuelo, nv.nombre AS nivelVuelo
        FROM destino d JOIN
        tramo t ON d.id=t.DestinoID JOIN
        destino dd ON dd.id=t.OrigenID JOIN
        servicioabordo sb ON dd.id=sb.id JOIN
        equipo e ON sb.id=e.id JOIN
        capacidadcabina cap ON e.id=cap.CabinaID JOIN
        cabina c ON cap.CabinaID=c.id JOIN
        tipovuelo tv ON c.id=tv.id JOIN
        nivelvuelo nv ON tv.id=nv.id
        WHERE d.nombre='ISS' AND dd.nombre='Buenos Aires' AND DATE(t.fechaSalida)='2022-05-18'
        AND sb.nombre='standard' AND c.nombre='turista' AND nv.nombre= 'NIVEL 1';
 * */
