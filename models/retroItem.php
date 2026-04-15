<?php
class RetroItem {
    public $id;
    public $sprint_id;
    public $categoria;
    public $descripcion;

    public function __construct($id, $sprint_id, $categoria, $descripcion) {
        $this->id = $id;
        $this->sprint_id = $sprint_id;
        $this->categoria = $categoria;
        $this->descripcion = $descripcion;
    }
}
?>