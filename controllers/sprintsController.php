<?php
require_once dirname(dirname(__FILE__)) . '/models/sprint.php';
require_once dirname(dirname(__FILE__)) . '/models/retroItem.php';

class SprintsController 
{
    protected Sprint $sprintModel;
    protected RetroItem $retroItemModel;

    public function __construct()
    {
        $this->sprintModel = new Sprint();
        $this->retroItemModel = new RetroItem();        
    }

    /**
     * Mostrar todos los sprints
     */
    public function showAllSprints(): array {
        return $this->sprintModel->getAll();
    }


    public function createSprint(array $params): string {
        if (empty($params['nombre'])) {
            return 'El nombre no puede estar vacío';
        }
        if (empty($params['fecha_inicio'])) {
            return 'La fecha de inicio no puede estar vacía';
        }
        if (empty($params['fecha_fin'])) {
            return 'La fecha de fin no puede estar vacía';
        }

        $ok = $this->sprintModel->create($params['nombre'], $params['fecha_inicio'], $params['fecha_fin']);
        return $ok ? 'Sprint creado con éxito' : 'Error al crear el sprint';
    }


    public function createRetroItem(array $params): string {
        if (empty($params['sprint_id'])) {
            return 'El sprint_id no puede estar vacío';
        }
        if (empty($params['categoria'])) {
            return 'La categoría no puede estar vacía';
        }
        if (empty($params['descripcion'])) {
            return 'La descripción no puede estar vacía';
        }

        $ok = $this->retroItemModel->create($params['sprint_id'], $params['categoria'], $params['descripcion']);
        return $ok ? 'Retro item creado con éxito' : 'Error al crear el retro item';
    }
}
?>