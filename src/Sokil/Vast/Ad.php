<?php

namespace Sokil\Vast;

abstract class Ad
{    
    /**
     *
     * @var \DomNode
     */
    protected $_domElement;
    
    /**
     * 
     * @param \Sokil\Vast\DomElement|string $domElement
     */
    public function __construct(\DomElement $domElement) 
    {
        $this->_domElement = $domElement;
    }
    
    public function getId()
    {
        return $this->_domElement->getAttribute('id');
    }
    
    /**
     * 
     * @param type $id
     * @return \Sokil\Vast\Ad
     */
    public function setId($id)
    {
        $this->_domElement->setAttribute('id', $id);
        return $this;
    }
}