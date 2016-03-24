<?php

namespace Sokil\Vast\Ad\InLine\Creative;

abstract class Base
{
    /**
     *
     * @var \DomElement
     */
    protected $domElement;
    
    public function __construct(\DomElement $domElement) 
    {
        $this->domElement = $domElement;
    }
}