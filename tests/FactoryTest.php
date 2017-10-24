<?php

namespace Sokil\Vast;

class FactoryTest extends AbstractTestCase
{
    /**
     * @var string
     */
    private $vastXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"><Ad id="ad1"><InLine><AdSystem><![CDATA[Ad Server Name]]></AdSystem><AdTitle><![CDATA[Ad Title]]></AdTitle><Impression><![CDATA[http://ad.server.com/impression]]></Impression><Creatives><Creative><Linear><Duration>00:02:08</Duration><VideoClicks><ClickThrough><![CDATA[http://entertainmentserver.com/landing]]></ClickThrough><ClickTracking><![CDATA[http://ad.server.com/videoclicks/clicktracking]]></ClickTracking><CustomClick><![CDATA[http://ad.server.com/videoclicks/customclick]]></CustomClick></VideoClicks><TrackingEvents><Tracking event="start"><![CDATA[http://ad.server.com/trackingevent/start]]></Tracking><Tracking event="pause"><![CDATA[http://ad.server.com/trackingevent/stop]]></Tracking></TrackingEvents><MediaFiles><MediaFile delivery="progressive" type="video/mp4" height="100" width="100"><![CDATA[http://server.com/media.mp4]]></MediaFile></MediaFiles></Linear></Creative></Creatives></InLine></Ad></VAST>';

    public function testFromFile()
    {
        $tempFilename = tempnam(sys_get_temp_dir(), "vast");
        file_put_contents($tempFilename, $this->vastXml);

        $factory = new Factory();
        $vastDocument = $factory->fromFile($tempFilename);

        $this->assertInstanceOf(
            'Sokil\Vast\Document',
            $vastDocument
        );

        unlink($tempFilename);
    }

    public function testFromString()
    {
        $factory = new Factory();
        $vastDocument = $factory->fromString($this->vastXml);

        $this->assertInstanceOf(
            'Sokil\Vast\Document',
            $vastDocument
        );
    }
}
