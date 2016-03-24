<?php

namespace Sokil\Vast;

abstract class Ad
{    
    /**
     *
     * @var \DomNode
     */
    protected $domElement;
    
    /**
     * 
     * @param \Sokil\Vast\DomElement|string $domElement
     */
    public function __construct(\DomElement $domElement) 
    {
        $this->domElement = $domElement;
    }
    
    public function getId()
    {
        return $this->domElement->getAttribute('id');
    }
    
    /**
     * 
     * @param type $id
     * @return \Sokil\Vast\Ad
     */
    public function setId($id)
    {
        $this->domElement->setAttribute('id', $id);
        return $this;
    }


    /**
     *
     * @param string $adSystem
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdSystem($adSystem)
    {
        $adSystemDomElement = $this->domElement->getElementsByTagName('AdSystem')->item(0);
        if($adSystemDomElement) {
            $adSystemDomElement->nodeValue = $adSystem;
        }
        else {
            $adSystemDomElement = $this->domElement->ownerDocument->createElement('AdSystem', $adSystem);
            $this->domElement->firstChild->appendChild($adSystemDomElement);
        }

        return $this;
    }
}