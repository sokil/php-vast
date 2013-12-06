<?php

namespace Sokil\Vast\Ad\InLine\Creative;

abstract class Base
{
    /**
     *
     * @var \DomElement
     */
    protected $_domElement;
    
    public function __construct(\DomElement $domElement) 
    {
        $this->_domElement = $domElement;
    }
}