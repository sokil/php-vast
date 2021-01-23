<?php

namespace Sokil\Vast;

abstract class AbstractTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $filename
     *
     * @return string
     */
    private function getFullXMLFixturePath($filename)
    {
        return __DIR__ . '/data/' . $filename;
    }

    /**
     * @param $expectedXml
     * @param $actualXml
     */
    protected function assertVastDocumentSameWithXmlFixture($expectedXmlFixturePath, Document $actualXmlDomDocument)
    {
        $this->assertXmlStringEqualsXmlFile(
            $this->getFullXMLFixturePath($expectedXmlFixturePath),
            (string)$actualXmlDomDocument
        );
    }
}
