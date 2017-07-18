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
     * Ad constructor.
     *
     * @param \DomElement $domElement
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
     * Set `id' attribute of 'ad' element
     *
     * @param string $id
     *
     * @return \Sokil\Vast\Ad\InLine|\Sokil\Vast\Ad\Wrapper
     */
    public function setId($id)
    {
        $this->domElement->setAttribute('id', $id);

        return $this;
    }


    /**
     * Add `AdSystem` element to `Ad' element
     *
     * @param string $adSystem
     *
     * @return \Sokil\Vast\Ad\InLine|\Sokil\Vast\Ad\Wrapper
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