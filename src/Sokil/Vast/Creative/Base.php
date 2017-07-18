<?php

namespace Sokil\Vast\Creative;

abstract class Base
{
    /**
     *
     * @var \DomElement
     */
    protected $domElement;

    /**
     * Base constructor.
     *
     * @param \DomElement $domElement
     */
    public function __construct(\DomElement $domElement) 
    {
        $this->domElement = $domElement;
    }
}