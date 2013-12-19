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
                        <Impression><![CDATA[http://ad.server.com/impression]]></Impression>
                        <Creatives>
                            <Creative>
                                <Linear>
                                    <Duration>02:08</Duration>
                                    <VideoClips>
                                        <ClickThrough><![CDATA[http://ad.server.com/videoclips/clickthrough]]></ClickThrough>
                                        <ClickTracking><![CDATA[http://ad.server.com/videoclips/clicktracking]]></ClickTracking>
                                        <CustomClick><![CDATA[http://ad.server.com/videoclips/customclick]]></CustomClick>
                                    </VideoClips>
                                    <TrackingEvents>
                                        <Tracking event="start"><![CDATA[http://ad.server.com/trackingevent/start]]></Tracking>
                                        <Tracking event="stop"><![CDATA[http://ad.server.com/trackingevent/stop]]></Tracking>
                                    </TrackingEvents>
                                    <MediaFiles>
                                        <MediaFile delivery="progressive" type="video/mp4" height="100" width="100">
                                            <![CDATA[http://server.com/media.mp4]]>
                                        </MediaFile>
                                    </MediaFiles>
                                </Linear>
                            </Creative>
                        </Creatives>
                        <Extensions>
                            <Extension type="startTime">
                                <![CDATA[00:01]]>
                            </Extension>
                            <Extension type="skipTime">
                                <![CDATA[05:02]]>
                            </Extension>
                        </Extensions>
                    </InLine>
                </Ad>
                <Ad id="ad2">
                    <Wrapper/>
                </Ad>
            </VAST>');
        
        // create document
        $document = \Sokil\Vast\Document::create('2.0');
        
        // insert Ad section
        $ad1 = $document->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->setImpression('http://ad.server.com/impression');
        
        // create creative for ad section
        $ad1->createLinearCreative()
            ->setDuration(128)
            ->setVideoClipsClickThrough('http://ad.server.com/videoclips/clickthrough')
            ->addVideoClipsClickTracking('http://ad.server.com/videoclips/clicktracking')
            ->addVideoClipsCustomClick('http://ad.server.com/videoclips/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('stop', 'http://ad.server.com/trackingevent/stop')
            ->createMediaFile()
                ->setProgressiveDelivery()
                ->setType('video/mp4')
                ->setHeight(100)
                ->setWidth(100)
                ->setUrl('http://server.com/media.mp4');
        
        $ad1
            ->addExtension('startTime', '00:01')
            ->addExtension('skipTime', '00:02');
        
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