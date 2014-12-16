<?php
namespace Application\Services;

use Application\mapper;
class Timelines
{
    public function GET($params = null)
    {
        if(!isset($params['id']))
        {
            $mapper = new mapper\Timelines();
            $timelines = $mapper->getAdapter()->fetchAll();
            return json_encode($timelines);
        }
        else 
            $this->GetONE($params);
    }
    
    private function GetONE($params) {
        $mapper = new mapper\Timelines();
        $id = array('idevent' => $params['id']);
        $timeline = $mapper->getAdapter()->fetch($id);
        
        echo json_encode($timeline);die;
        
    }
    
    public function POST()
    {
        print_r($_POST);
    }
    
    public function PUT($id, $data)
    {
    
    }
    
    public function DELETE($id)
    {
    
    }
}