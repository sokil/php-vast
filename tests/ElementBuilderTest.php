<?php

namespace Sokil\Vast;

use Sokil\Vast\Stub\CustomElementBuilder\CustomElementBuilder;

class ElementBuilderTest extends AbstractTestCase
{
    public function testCustomAttributes()
    {
        $customElementBuilder = new CustomElementBuilder();
        $factory = new Factory($customElementBuilder);

        $document = $factory->create('4.1');
        $this->assertInstanceOf('\\Sokil\\Vast\\Stub\\CustomElementBuilder\\Element\\CustomDocument', $document);

        // insert Ad section
        $inLineAd = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression', 'imp1');

        $this->assertInstanceOf('\\Sokil\\Vast\\Stub\\CustomElementBuilder\\Element\\CustomInLine', $inLineAd);

        // create creative for ad section
        $inLineAdLinearCreative = $inLineAd
            ->createLinearCreative()
            ->setDuration(128)
            ->setUniversalAdId('ad-server.com', '15051996')
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
            ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
            ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop')
            ->addProgressTrackingEvent('http://ad.server.com/trackingevent/progress', 10);

        $this->assertInstanceOf('\\Sokil\\Vast\\Stub\\CustomElementBuilder\\Element\\CustomInLineAdLinearCreative', $inLineAdLinearCreative);

        $mediaFile = $inLineAdLinearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(100)
            ->setWidth(100)
            ->setBitrate(600)
            ->setUrl('http://server.com/media.mp4');

        $this->assertInstanceOf('\\Sokil\\Vast\\Stub\\CustomElementBuilder\\Element\\CustomMediaFile', $mediaFile);

        $this->assertVastDocumentSameWithXmlFixture('inlineAdCustomElements.xml', $document);
    }
}