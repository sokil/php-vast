<?php

namespace Sokil\Vast;

use Sokil\Vast\Ad\InLine;

class DocumentTest extends AbstractTestCase
{
    /**
     * Test for inline ad
     */
    public function testCreateInLineAdSection()
    {
        $factory = new Factory();
        $document = $factory->create('4.1');
        $this->assertInstanceOf('\\Sokil\\Vast\\Document', $document);

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression', 'imp1');

        // create creative for ad section
        $ad1
            ->createLinearCreative()
            ->setDuration(128)
            ->setId('013d876d-14fc-49a2-aefd-744fce68365b')
            ->setAdId('pre')
            ->setUniversalAdId('ad-server.com', '15051996')
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
            ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
            ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop')
            ->addProgressTrackingEvent('http://ad.server.com/trackingevent/progress', 10)
            ->createMediaFile()
                ->setProgressiveDelivery()
                ->setType('video/mp4')
                ->setHeight(100)
                ->setWidth(100)
                ->setBitrate(600)
                ->setUrl('http://server.com/media.mp4');

        $this->assertVastDocumentSameWithXmlFixture('inlineAd.xml', $document);
    }

    /**
     * Test for inline ad
     */
    public function testReplaceVideoClicksClickThrough()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document->createInLineAdSection();

        // create creative for ad section
        $ad1->createLinearCreative()
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing1')
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing2');

        $this->assertVastDocumentSameWithXmlFixture(
            'replacedClickThrough.xml',
            $document
        );
    }

    /**
     * Test for inline ad
     */
    public function testGetAdSection()
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
            ->addImpression('http://ad.server.com/impression');

        // create creative for ad section
        $ad1
            ->createLinearCreative()
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

        $adSections = $document->getAdSections();
        $this->assertCount(1, $adSections);

        /** @var InLine $adSection */
        $adSection = $adSections[0];
        $this->assertInstanceOf('\\Sokil\\Vast\\Ad\\InLine', $adSection);

        $this->assertSame('ad1', $adSection->getId());
    }

    /**
     * Test for creating media file with skipping after specific time
     */
    public function testCreateLinearCreativeWithSkipAfter()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression');

        $ad1
            ->createLinearCreative()
            ->skipAfter(1519203721);

        $this->assertVastDocumentSameWithXmlFixture('linearCreativeWithSkipAfter.xml', $document);
    }

    /**
     * Test for creating media file with streaming delivery
     */
    public function testCreateLinearCreativeWithStreamingDelivery()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression');
        $ad1->createLinearCreative()->createMediaFile()->setStreamingDelivery();

        $this->assertVastDocumentSameWithXmlFixture('linearCreativeWithStreamingDelivery.xml', $document);
    }
    
    /**
     * Test for creating media file with Closed Captions
     */
    public function testCreateLinearCreativeWithClosedCaptions()
    {
        $factory = new Factory();
        $document = $factory->create('4.1');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression');
        $ad1
          ->createLinearCreative()
          ->createClosedCaptionFile()
          ->setLanguage('en')
          ->setType('text/srt')
          ->setUrl('http://http://example.com/test.srt');

        $this->assertVastDocumentSameWithXmlFixture('linearCreativeWithClosedCaption.xml', $document);
    }
    
    /**
     * Test for creating media file with Closed Captions and Media Files
     */
    public function testCreateLinearCreativeWithClosedCaptionsAndMedia()
    {
        $factory = new Factory();
        $document = $factory->create('4.1');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression');
        
        $linear = $ad1->createLinearCreative();
        
        $linear
          ->createClosedCaptionFile()
          ->setLanguage('en')
          ->setType('text/srt')
          ->setUrl('http://example.com/test.srt');
        
        $linear
          ->createClosedCaptionFile()
          ->setLanguage('es-DO')
          ->setType('text/vtt')
          ->setUrl('http://example.com/closedcaption.vtt')
          ->setUrl('http://example.com/closedcaption2.vtt');
        
        $linear->createMediaFile()->setStreamingDelivery();

        $this->assertVastDocumentSameWithXmlFixture('linearCreativeWithClosedCaptionAndMediaFile.xml', $document);
    }

    /**
     * Test for creating media file with specific delivery
     */
    public function testCreateAdSectionWithDelivery()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression');
        $ad1->createLinearCreative()->createMediaFile()->setDelivery('progressive');

        $this->assertVastDocumentSameWithXmlFixture('adWithDelivery.xml', $document);
    }

    /**
     * Test for creating media file with invalid delivery
     * @expectedException        \Exception
     * @expectedExceptionMessage Wrong delivery specified
     */
    public function testCreateAdSectionWithInvalidDelivery()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression');

        // create creative for ad section
        $ad1
            ->createLinearCreative()
            ->setDuration(128)
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
            ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
            ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop')
            ->skipAfter(1519203721)
            ->createMediaFile()
                ->setDelivery('invalid_delivery')
                ->setType('video/mp4')
                ->setHeight(100)
                ->setWidth(100)
                ->setUrl('http://server.com/media.mp4');
    }

    /**
     * Test for ad with extension
     */
    public function testCreateAdSectionWithAddingExtension()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression');
        $ad1->addExtension('extension_type', 'extension_value');

        $this->assertVastDocumentSameWithXmlFixture('inlineAdWithExtension.xml', $document);

        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document
            ->createWrapperAdSection()
            ->setId('ad1')
            ->setVASTAdTagURI('//entertainmentserver.com/vast1.xml')
            ->setAdSystem('Ad Server Name')
            ->addImpression('http://ad.server.com/impression');
        $ad1->addExtension('extension_type', 'extension_value');

        $this->assertVastDocumentSameWithXmlFixture('wrapperAdWithExtension.xml', $document);
    }

    /**
     * Test for Document with set sequence
     */
    public function testCreateAdSectionWithSettingSequence()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->setSequence(0)
            ->addImpression('http://ad.server.com/impression');

        $this->assertSame(0, $ad1->getSequence());
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

        $this->assertVastDocumentSameWithXmlFixture('wrapper.xml', $document);
    }

    /**
     * Error trait in document
     */
    public function testErrorInDocument()
    {
        $factory = new Factory();
        $document = $factory->create('3.0');
        $document->addErrors('//ad.server.com/tracking/error/noad');

        $this->assertVastDocumentSameWithXmlFixture('error.xml', $document);

        $this->assertEquals(
            array('//ad.server.com/tracking/error/noad'),
            $document->getErrors()
        );
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
        $wrapperAd = $document
            ->createWrapperAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setVASTAdTagURI('//entertainmentserver.com/vast1.xml')
            ->addError('//ad.server.com/tracking/error');

        $this->assertVastDocumentSameWithXmlFixture('errorInWrapper.xml', $document);

        $this->assertEquals(
            array('//ad.server.com/tracking/error'),
            $wrapperAd->getErrors()
        );
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
            ->addError('//ad.server.com/tracking/error');

        $this->assertVastDocumentSameWithXmlFixture('errorInInline.xml', $document);

        $this->assertEquals(
            array('//ad.server.com/tracking/error'),
            $ad1->getErrors()
        );
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
            ->addImpression('//ad.server.com/tracking/impression1')
            ->addImpression('//ad.server.com/tracking/impression2');

        $this->assertVastDocumentSameWithXmlFixture('impressionInWrapper.xml', $document);

        $this->assertEquals(
            array(
                '//ad.server.com/tracking/impression1',
                '//ad.server.com/tracking/impression2',
            ),
            $ad1->getImpressions()
        );
    }

    /**
     * test Document to output string
     */
    public function testToString()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        $this->assertContains('<?xml version="1.0" encoding="UTF-8"?>', (string)$document);
        $this->assertContains('<VAST version="2.0"/>', (string)$document);
    }

    /**
     * test Document to output \DomDocument
     */
    public function testToDomDocument()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        $this->assertInstanceOf('\DomDocument', $document->toDomDocument());
    }

    /**
     * test Document to create another vast version from Document
     */
    public function testCreate()
    {
        $factory = new Factory();
        $document = $factory->create('2.0');

        $this->assertInstanceOf('\DomDocument', $document->toDomDocument());
    }

    /**
     * test Document to create vast from string
     */
    public function testFromString()
    {
        $factory = new Factory();

        $this->assertInstanceOf(
            'Sokil\Vast\Document',
            $factory->fromString('<?xml version="1.0" encoding="UTF-8"?><VAST version="2.0"/>')
        );
    }

    /**
     * test Document to create vast from file
     */
    public function testFromFile()
    {
        $factory = new Factory();

        $this->assertInstanceOf('Sokil\Vast\Document', $factory->fromFile(__DIR__ . '/data/vast.xml'));
    }

    /**
     * VPAID creative test
     */
    public function testVpaidCreative()
    {
        $factory = new Factory();
        $document = $factory->create('3.0');

        $ad = $document
            ->createInLineAdSection()
            ->setId('test-vpaid')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('VPAIDPreRoll');

        $creative = $ad->createLinearCreative();
        $creative
            ->setAdParameters(array(
                'param' => 42,
            ))
            ->setAdParameters(array(
                'list' => array(
                    array('param1' => 'value1', 'param2' => 'value2')
                ),
            ));

        $creative->createMediaFile()
            ->setApiFramework('VPAID')
            ->setType('application/javascript')
            ->setUrl('https://example.com/vpaid.js?v434');

        $this->assertVastDocumentSameWithXmlFixture('vpaid.xml', $document);
    }
}
