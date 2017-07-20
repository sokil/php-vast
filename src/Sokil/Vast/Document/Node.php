<?php

namespace Sokil\Vast\Document;

abstract class Node
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
