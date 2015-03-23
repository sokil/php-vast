<?php

namespace Sokil\Vast;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $document = \Sokil\Vast\Document::create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document', $document);
    }
}
