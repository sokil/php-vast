<?php

namespace Sokil\Vast\Document;

class Factory
{
    /**
     * Create new VAST document
     *
     * @param string $vastVersion
     *
     * @return \Sokil\Vast\Document
     */
    public function create($vastVersion = '2.0')
    {
        $xml = $this->prepareEmptyDom();

        // root
        $root = $xml->createElement('VAST');
        $xml->appendChild($root);

        // version
        $vastVersionAttribute = $xml->createAttribute('version');
        $vastVersionAttribute->value = $vastVersion;
        $root->appendChild($vastVersionAttribute);

        // return
        return new \Sokil\Vast\Document\Document($xml);
    }

    /**
     * Create VAST document from file
     *
     * @param string $filename
     *
     * @return \Sokil\Vast\Document
     */
    public function fromFile($filename)
    {
        $xml = $this->prepareEmptyDom();
        $xml->load($filename);

        return new \Sokil\Vast\Document\Document($xml);
    }

    /**
     * Create VAST document from given string with xml
     *
     * @param string $xmlString
     *
     * @return \Sokil\Vast\Document
     */
    public function fromString($xmlString)
    {
        $xml = $this->prepareEmptyDom();
        $xml->loadXml($xmlString);

        return new \Sokil\Vast\Document\Document($xml);
    }

    /**
     * Extracted common logic for preparing empty dom document
     *
     * @return \DomDocument
     */
    protected function prepareEmptyDom()
    {
        return new \DomDocument('1.0', 'UTF-8');
    }
}