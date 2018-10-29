<?php

namespace Sokil\Vast;

use Sokil\Vast\Document;

abstract class AbstractTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Minify XML
     *
     * @param string $xml
     * @return string
     */
    protected function minifyXml($xml)
    {
        $document = new \DOMDocument();
        $document->preserveWhiteSpace = false;
        $document->loadXML($xml);

        return $document->saveXML();
    }

    /**
     * Get minified xml string using file from data/ dir
     *
     * @param $filename
     * @return string
     */
    protected function minifiedXmlFromData($filename)
    {
        $xml = file_get_contents(__DIR__ . '/data/' . $filename);

        return $this->minifyXml($xml);
    }

    /**
     * Assert xml equals between file from data/ dir and given Document
     *
     * @param string   $filename
     * @param Document $document
     */
    protected function assertFileVsDocument($filename, Document $document)
    {
        self::assertEquals(
            $this->minifiedXmlFromData($filename),
            (string) $document
        );
    }
}
