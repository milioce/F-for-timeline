<?php
namespace Application\mapper;
use Core\Application\application;

class Timelines
{
    protected $entity;
    protected $adapter;
    
    public function __construct()
    {
        $config = application::getConfig();
		$adapter = $config['adapter'];

        $adapter = new $adapter();        
        $adapter->setTable('events');
        $adapter->connect($config);
        
        $this->setAdapter($adapter);
    }
         
    /**
     * @return the $adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param field_type $adapter
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return the $entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param field_type $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    
    
}