<?php
require_once dirname(dirname(__FILE__)) . '\models\sprint.php';
require_once dirname(dirname(__FILE__)) . '\models\retroItem.php';

class sprintsController 
{
    protected sprint $sprintModel;
    protected retroItem $retroItemModel;
    public function __construct()
    {
        $this->sprintModel = new sprint();
        $this->retroItemModel = new retroItem();        
    }

    public function CreateSprint(Array $paramters) 
    {
        if(empty($paramters['sprint_id'])){
            return 'No puede estar vacio';
        }
        if(empty($paramters['categoria'])){
            return 'No puede estar vacio';
        }
        if(empty($paramters['descripcion'])){
            return 'No puede estar vacio';
        }
        
           
        $this->retroItemModel->create($paramters['sprint_id'],$paramters['categoria'],$paramters['descripcion']);

        return 'Se creo con exito el dato';
    }    
}
