<?php

namespace Sokil\Vast;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateDocument() 
    {
        $document = \Sokil\Vast\Document::create('2.0');
        
        $document->createAdSection()->setId('ad1');
        $document->createAdSection()->setId('ad2');
        
        $this->assertEquals(
            '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"/><Ad id="ad2"/></VAST>', 
            str_replace(array("\n", "\r"), '', (string) $document)
        );
    }
    
    public function testLoadDocumentFromString()
    {
        $document = \Sokil\Vast\Document::fromString('<?xml version="1.0" encoding="UTF-8"?>
            <VAST version="2.0">
                <Ad id="ad1"/>
                <Ad id="ad2"/>
            </VAST>
        ');

        $this->assertEquals('ad2', $document->getAdSections()[1]->getId());
    }
}