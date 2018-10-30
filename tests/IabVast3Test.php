<?php

namespace Sokil\Vast;

class IabVast3Test extends AbstractTestCase
{
    public function testWrapperTag()
    {
        $factory = new Factory();
        $document = $factory->create('3.0');

        $document
            ->createInLineAdSection()
            ->setId('20001')
            ->setAdSystem('iabtechlab')
            ->setAdTitle('iabtechlab video ad')
            ->addImpression('http://example.com/track/impression') // missing attr ID
            ->addError('http://example.com/error')
        ;

        // Stop here and mark this test as incomplete.
        self::markTestIncomplete(
          'This test has not been implemented yet.'
        );
        $this->assertFileVsDocument('iab/VAST 3.0 samples/No_Wrapper_Tag-test.xml', $document);
    }
}
