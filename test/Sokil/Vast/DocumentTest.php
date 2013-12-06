<?php

namespace Sokil\Vast;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateDocument() 
    {
        // expected document
        $expectedDom = new \DOMDocument('1.0', 'URT-8');
        $expectedDom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <VAST version="2.0">
                <Ad id="ad1">
                    <InLine>
                        <AdSystem>Ad Server Name</AdSystem>
                        <AdTitle>Ad Title</AdTitle>
                        <Impression><![CDATA[http://ad.server.com/getcode?11]]></Impression>
                        <Creatives>
                            <Creative>
                                <Linear>
                                    <Duration>02:08</Duration>
                                    <MediaFiles>
                                        <MediaFile delivery="progressive" type="video/mp4" height="100" width="100">
                                            <![CDATA[http://server.com/media.mp4]]>
                                        </MediaFile>
                                    </MediaFiles>
                                </Linear>
                            </Creative>
                        </Creatives>
                    </InLine>
                </Ad>
                <Ad id="ad2">
                    <Wrapper/>
                </Ad>
            </VAST>');
        
        // create document
        $document = \Sokil\Vast\Document::create('2.0');
        $document->toDomDocument()->formatOutput = true;
        
        // insert Ad section
        $ad1 = $document->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->setImpression('http://ad.server.com/getcode?11');
        
        // create creative for ad section
        $creative = $ad1->createCreative();
        $linearCreative = $creative
            ->addLinear()
            ->setDuration(128);
        
        $linearCreative->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(100)
            ->setWidth(100)
            ->setUrl('http://server.com/media.mp4');
        
        // insert another ad section
        $document->createWrapperAdSection()->setId('ad2');
        
        // die($document);
        
        // test
        $this->assertEqualXMLStructure(
            $expectedDom->firstChild, 
            $document->toDomDocument()->firstChild
        );
    }
    
    public function testLoadDocumentFromString()
    {
        $document = \Sokil\Vast\Document::fromString('<?xml version="1.0" encoding="UTF-8"?>
            <VAST version="2.0">
                <Ad id="ad1">
                    <InLine/>
                </Ad>
                <Ad id="ad2">
                    <Wrapper/>
                </Ad>
            </VAST>
        ');

        $this->assertEquals('ad2', $document->getAdSections()[1]->getId());
    }
}