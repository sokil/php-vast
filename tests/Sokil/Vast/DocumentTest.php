<?php

namespace Sokil\Vast;

class DocumentTest extends AbstractTestCase
{
    /**
     * Test for inline ad
     */
    public function testCreateInLineAdSection()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document', $document);

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->setImpression('http://ad.server.com/impression');

        // create creative for ad section
        $ad1->createLinearCreative()
            ->setDuration(128)
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
            ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
            ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop')
            ->createMediaFile()
                ->setProgressiveDelivery()
                ->setType('video/mp4')
                ->setHeight(100)
                ->setWidth(100)
                ->setUrl('http://server.com/media.mp4');

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><InLine><AdSystem>Ad Server Name</AdSystem><AdTitle><![CDATA[Ad Title]]></AdTitle><Impression><![CDATA[http://ad.server.com/impression]]></Impression><Creatives><Creative><Linear><Duration>00:02:08</Duration><VideoClicks><ClickThrough><![CDATA[http://entertainmentserver.com/landing]]></ClickThrough><ClickTracking><![CDATA[http://ad.server.com/videoclicks/clicktracking]]></ClickTracking><CustomClick><![CDATA[http://ad.server.com/videoclicks/customclick]]></CustomClick></VideoClicks><TrackingEvents><Tracking event="start"><![CDATA[http://ad.server.com/trackingevent/start]]></Tracking><Tracking event="pause"><![CDATA[http://ad.server.com/trackingevent/stop]]></Tracking></TrackingEvents><MediaFiles><MediaFile delivery="progressive" type="video/mp4" height="100" width="100"><![CDATA[http://server.com/media.mp4]]></MediaFile></MediaFiles></Linear></Creative></Creatives></InLine></Ad></VAST>';
        $this->assertVastXmlEquals($expectedXml, $document);
    }

    /**
     * Test for wrapper ad
     */
    public function testCreateWrapperAdSection()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document', $document);

        // insert Ad section
        $document
            ->createWrapperAdSection()
            ->setId('ad1')
            ->setVASTAdTagURI('//entertainmentserver.com/vast1.xml')
            ->setAdSystem('Ad Server Name')
            ->setVASTAdTagURI('//entertainmentserver.com/vast2.xml')
            ->createLinearCreative()
                ->addVideoClicksClickTracking('//ad.server.com/videoclicks/clicktracking')
                ->addVideoClicksCustomClick('//ad.server.com/videoclicks/customclick')
                ->addTrackingEvent('start', '//ad.server.com/trackingevent/start')
                ->addTrackingEvent('pause', '//ad.server.com/trackingevent/stop');

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><Wrapper><VASTAdTagURI><![CDATA[//entertainmentserver.com/vast2.xml]]></VASTAdTagURI><AdSystem>Ad Server Name</AdSystem><Creatives><Creative><Linear><VideoClicks><ClickTracking><![CDATA[//ad.server.com/videoclicks/clicktracking]]></ClickTracking><CustomClick><![CDATA[//ad.server.com/videoclicks/customclick]]></CustomClick></VideoClicks><TrackingEvents><Tracking event="start"><![CDATA[//ad.server.com/trackingevent/start]]></Tracking><Tracking event="pause"><![CDATA[//ad.server.com/trackingevent/stop]]></Tracking></TrackingEvents></Linear></Creative></Creatives></Wrapper></Ad></VAST>';
        $this->assertVastXmlEquals($expectedXml, $document);
    }

    /**
     * Error trait in document
     */
    public function testErrorInDocument()
    {
        $factory = new Factory();
        $document = $factory->create('3.0');
        $document->setError('//ad.server.com/tracking/error/noad');

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="3.0"><Error><![CDATA[//ad.server.com/tracking/error/noad]]></Error></VAST>';
        $this->assertVastXmlEquals($expectedXml, $document);

        $this->assertEquals('//ad.server.com/tracking/error/noad', $document->getError());
    }

    /**
     * Error trait in wrapper ad
     */
    public function testErrorInWrapperAd()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document', $document);

        // insert Ad section
        $ad1 = $document
            ->createWrapperAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setVASTAdTagURI('//entertainmentserver.com/vast1.xml')
            ->setError('//ad.server.com/tracking/error');

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><Wrapper><AdSystem>Ad Server Name</AdSystem><VASTAdTagURI><![CDATA[//entertainmentserver.com/vast1.xml]]></VASTAdTagURI><Error><![CDATA[//ad.server.com/tracking/error]]></Error></Wrapper></Ad></VAST>';
        $this->assertVastXmlEquals($expectedXml, $document);

        $this->assertEquals('//ad.server.com/tracking/error', $ad1->getError());
    }

    /**
     * Error trait in inline ad
     */
    public function testErrorInInlineAd()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document', $document);

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setError('//ad.server.com/tracking/error');

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><InLine><AdSystem>Ad Server Name</AdSystem><Error><![CDATA[//ad.server.com/tracking/error]]></Error></InLine></Ad></VAST>';
        $this->assertVastXmlEquals($expectedXml, $document);

        $this->assertEquals('//ad.server.com/tracking/error', $ad1->getError());
    }

    /**
     * Impression trait in wrapper ad
     */
    public function testImpressionInWrapperAd()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document', $document);

        // insert Ad section
        $ad1 = $document
            ->createWrapperAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setVASTAdTagURI('//entertainmentserver.com/vast1.xml')
            ->setImpression('//ad.server.com/tracking/impression');

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><Wrapper><AdSystem>Ad Server Name</AdSystem><VASTAdTagURI><![CDATA[//entertainmentserver.com/vast1.xml]]></VASTAdTagURI><Impression><![CDATA[//ad.server.com/tracking/impression]]></Impression></Wrapper></Ad></VAST>';
        $this->assertVastXmlEquals($expectedXml, $document);

        $this->assertEquals('//ad.server.com/tracking/impression', $ad1->getImpression());
    }

}
