<?php

namespace Sokil\Vast;

class Factory
{
    /**
     * Create new VAST document
     *
     * @param string $vastVersion
     *
     * @return Document
     */
    public function create($vastVersion = '2.0')
    {
        $xml = $this->createDomDocument();

        // root
        $root = $xml->createElement('VAST');
        $xml->appendChild($root);

        // version
        $vastVersionAttribute = $xml->createAttribute('version');
        $vastVersionAttribute->value = $vastVersion;
        $root->appendChild($vastVersionAttribute);

        // return
        return new Document($xml);
    }

    /**
     * Create VAST document from file
     *
     * @param string $filename
     *
     * @return Document
     */
    public function fromFile($filename)
    {
        $xml = $this->createDomDocument();
        $xml->load($filename);

        return new Document($xml);
    }

    /**
     * Create VAST document from given string with xml
     *
     * @param string $xmlString
     *
     * @return Document
     */
    public function fromString($xmlString)
    {
        $xml = $this->createDomDocument();
        $xml->loadXml($xmlString);

        return new Document($xml);
    }

    /**
     * Create dom document
     *
     * @return \DomDocument
     */
    private function createDomDocument()
    {
        return new \DomDocument('1.0', 'UTF-8');
    }
}
