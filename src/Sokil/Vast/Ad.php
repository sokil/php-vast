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


    /**
     *
     * @param string $adSystem
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdSystem($adSystem)
    {
        $adSystemDomElement = $this->_domElement->getElementsByTagName('AdSystem')->item(0);
        if($adSystemDomElement) {
            $adSystemDomElement->nodeValue = $adSystem;
        }
        else {
            $adSystemDomElement = $this->_domElement->ownerDocument->createElement('AdSystem', $adSystem);
            $this->_domElement->firstChild->appendChild($adSystemDomElement);
        }

        return $this;
    }
}