<?php

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sokil\Vast;

class Factory
{
    /**
     * @var ElementBuilder
     */
    private $vastElementBuilder;

    /**
     * @param ElementBuilder $vastElementBuilder
     */
    public function __construct(ElementBuilder $vastElementBuilder = null)
    {
        if ($vastElementBuilder === null) {
            $vastElementBuilder = new ElementBuilder();
        }

        $this->vastElementBuilder = $vastElementBuilder;
    }

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
        return $this->vastElementBuilder->createDocument($xml);
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

        return $this->vastElementBuilder->createDocument($xml);
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

        return $this->vastElementBuilder->createDocument($xml);
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
