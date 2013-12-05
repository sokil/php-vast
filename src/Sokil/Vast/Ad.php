<?php

namespace Sokil\Vast;

class Ad
{
    /**
     *
     * @var \DomNode
     */
    private $_domElement;
    
    public function __construct($domElement = null) {
        
        if($domElement) {
            $this->_domElement = $domElement;
        }
    }
    
    public function toDomElement()
    {
        if(!$this->_domElement) {
            $this->_domElement = new \DomElement('Ad');
        }
        
        return $this->_domElement;
    }
    
    public function getId()
    {
        return $this->toDomElement()->getAttribute('id');
    }
    
    public function setId($id)
    {
        $this->toDomElement()->setAttribute('id', $id);
        return $this;
    }
}