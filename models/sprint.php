<?php
class Sprint {
    public $id;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct($id, $nombre, $fecha_inicio, $fecha_fin) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }
}
?>