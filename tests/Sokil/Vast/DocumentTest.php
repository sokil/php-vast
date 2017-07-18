<?php

namespace Sokil\Vast;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateInLineAdSection()
    {
        $document = (new \Sokil\Vast\Document\Factory())->create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document\Document', $document);

        // insert Ad section
        $ad1 = $document->createInLineAdSection()
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

        $actualXml = str_replace(array("\r", "\n"), '', (string) $document);

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><InLine><AdSystem>Ad Server Name</AdSystem><AdTitle><![CDATA[Ad Title]]></AdTitle><Impression><![CDATA[http://ad.server.com/impression]]></Impression><Creatives><Creative><Linear><Duration>00:02:08</Duration><VideoClicks><ClickThrough><![CDATA[http://entertainmentserver.com/landing]]></ClickThrough><ClickTracking><![CDATA[http://ad.server.com/videoclicks/clicktracking]]></ClickTracking><CustomClick><![CDATA[http://ad.server.com/videoclicks/customclick]]></CustomClick></VideoClicks><TrackingEvents><Tracking event="start"><![CDATA[http://ad.server.com/trackingevent/start]]></Tracking><Tracking event="pause"><![CDATA[http://ad.server.com/trackingevent/stop]]></Tracking></TrackingEvents><MediaFiles><MediaFile delivery="progressive" type="video/mp4" height="100" width="100"><![CDATA[http://server.com/media.mp4]]></MediaFile></MediaFiles></Linear></Creative></Creatives></InLine></Ad></VAST>';

        $this->assertEquals($expectedXml, $actualXml);
    }

    public function testCreateWrapperAdSection()
    {
        $document = (new \Sokil\Vast\Document\Factory())->create('2.0');
        $this->assertInstanceOf('\Sokil\Vast\Document\Document', $document);

        // insert Ad section
        $ad1 = $document->createWrapperAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setVASTAdTagURI('http://entertainmentserver.com/vast1.xml')
            ->setVASTAdTagURI('http://entertainmentserver.com/vast2.xml');

        $actualXml = str_replace(array("\r", "\n"), '', (string) $document);

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><Wrapper><AdSystem>Ad Server Name</AdSystem><VASTAdTagURI><![CDATA[http://entertainmentserver.com/vast2.xml]]></VASTAdTagURI></Wrapper></Ad></VAST>';

        $this->assertEquals($expectedXml, $actualXml);
    }

    /**
     * Clean given string of newlines
     *
     * @param string $xml
     *
     * @return string
     */
    protected function stripNewLines($xml)
    {
        return str_replace(array("\r", "\n"), '', $xml);
    }
}
