<?php

namespace Sokil\Vast;

abstract class AbstractTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $expectedXml
     * @param Document $actualVastDocument
     */
    protected function assertVastXmlEquals($expectedXml, Document $actualVastDocument)
    {
        $actualXml = str_replace(
            array("\r", "\n"),
            '',
            (string)$actualVastDocument
        );

        $this->assertEquals($expectedXml, $actualXml);
    }
}
