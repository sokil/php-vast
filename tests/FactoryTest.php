<?php

namespace Sokil\Vast;

class FactoryTest extends AbstractTestCase
{
    public function testFromFile()
    {
        $factory = new Factory();
        $vastDocument = $factory->fromFile(__DIR__ . '/data/vast.xml');

        // check if loaded
        $this->assertInstanceOf(
            'Sokil\Vast\Document',
            $vastDocument
        );

        // get first ad section
        $adSections = $vastDocument->getAdSections();
        $adSection = $adSections[0];

        // get scalar node
        $adSystem = $adSection->getAdSystem();
        $this->assertSame('Ad Server Name', $adSystem);

        // get multi-nodes

        $this->assertEquals(
            array(
                'http://ad.server.com/impression1',
                'http://ad.server.com/impression2',
                'http://ad.server.com/impression3',
            ),
            $adSection->getImpressions()
        );
    }

    public function testFromString()
    {
        $factory = new Factory();
        $vastDocument = $factory->fromString(file_get_contents(__DIR__ . '/data/vast.xml'));

        $this->assertInstanceOf(
            'Sokil\Vast\Document',
            $vastDocument
        );
    }
}
