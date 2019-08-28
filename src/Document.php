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

use Sokil\Vast\Ad\AbstractAdNode;
use Sokil\Vast\Ad\InLine;
use Sokil\Vast\Ad\Wrapper;
use Sokil\Vast\Document\AbstractNode;

class Document extends AbstractNode
{
    /**
     * @var \DOMDocument
     */
    private $domDocument;

    /**
     * @var ElementBuilder
     */
    private $vastElementBuilder;

    /**
     * Ad node list
     *
     * @var AbstractAdNode[]
     */
    private $vastAdNodeList = array();

    /**
     * @deprecated
     *
     * @var Factory
     */
    private static $documentFactory;

    /**
     * @param \DOMDocument $DOMDocument
     */
    public function __construct(\DOMDocument $DOMDocument, ElementBuilder $vastElementBuilder)
    {
        $this->domDocument = $DOMDocument;
        $this->vastElementBuilder = $vastElementBuilder;
    }

    /**
     * @return \DOMElement
     */
    protected function getDomElement()
    {
        return $this->domDocument->documentElement;
    }

    /**
     * Convert to string
     *
     * @deprecated use `(string) $document` instead
     *
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     * "Magic" method to convert document to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->domDocument->saveXML();
    }

    /**
     * Get DomDocument object
     *
     * @return \DomDocument
     */
    public function toDomDocument()
    {
        return $this->domDocument;
    }
    
    /**
     * Create "Ad" section on "VAST" node
     *
     * @param string $type
     *
     * @throws \InvalidArgumentException
     *
     * @return AbstractAdNode|InLine|Wrapper
     */
    private function createAdSection($type)
    {
        // Check Ad type
        if (!in_array($type, array(InLine::TAG_NAME, Wrapper::TAG_NAME))) {
            throw new \InvalidArgumentException(sprintf('Ad type %s not supported', $type));
        }

        // create dom node
        $adDomElement = $this->domDocument->createElement('Ad');
        $this->domDocument->documentElement->appendChild($adDomElement);

        // create type element
        $adTypeDomElement = $this->domDocument->createElement($type);
        $adDomElement->appendChild($adTypeDomElement);

        // create ad section
        switch ($type) {
            case InLine::TAG_NAME:
                $adSection = $this->vastElementBuilder->createInLineAdNode($adDomElement);
                break;
            case Wrapper::TAG_NAME:
                $adSection = $this->vastElementBuilder->createWrapperAdNode($adDomElement);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Ad type %s not supported', $type));
        }

        // cache
        $this->vastAdNodeList[] = $adSection;
        
        return $adSection;
    }
    
    /**
     * Create inline Ad section
     *
     * @return \Sokil\Vast\Ad\InLine
     */
    public function createInLineAdSection()
    {
        return $this->createAdSection(InLine::TAG_NAME);
    }
    
    /**
     * Create Wrapper Ad section
     *
     * @return \Sokil\Vast\Ad\Wrapper
     */
    public function createWrapperAdSection()
    {
        return $this->createAdSection(Wrapper::TAG_NAME);
    }

    /**
     * Get document ad sections
     *
     * @return AbstractAdNode[]
     *
     * @throws \Exception
     */
    public function getAdSections()
    {
        if (!empty($this->vastAdNodeList)) {
            return $this->vastAdNodeList;
        }
            
        foreach ($this->domDocument->documentElement->childNodes as $adDomElement) {
            // get Ad tag
            if (!$adDomElement instanceof \DOMElement) {
                continue;
            }

            if ('ad' !== strtolower($adDomElement->tagName)) {
                continue;
            }

            // get Ad type tag
            foreach ($adDomElement->childNodes as $node) {
                if (!($node instanceof \DOMElement)) {
                    continue;
                }

                $type = $node->tagName;

                // create ad section
                switch ($type) {
                    case InLine::TAG_NAME:
                        $adSection = $this->vastElementBuilder->createInLineAdNode($adDomElement);
                        break;
                    case Wrapper::TAG_NAME:
                        $adSection = $this->vastElementBuilder->createWrapperAdNode($adDomElement);
                        break;
                    default:
                        throw new \Exception('Ad type ' . $type . ' not supported');
                }

                $this->vastAdNodeList[] = $adSection;
            }
        }
        
        return $this->vastAdNodeList;
    }

    /**
     * Add Error tracking url.
     * Allowed multiple error elements.
     *
     * @param string $url
     *
     * @return $this
     */
    public function addErrors($url)
    {
        $this->addCdataNode('Error', $url);
        return $this;
    }

    /**
     * Get previously set error tracking url value
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->getValuesOfArrayNode('Error');
    }

    /**
     * @deprecated Helper method to get factory for deprecated methods
     *
     * @return Factory
     */
    private static function getFactory()
    {
        if (empty(self::$documentFactory)) {
            self::$documentFactory = new Factory();
        }

        return self::$documentFactory;
    }

    /**
     * @deprecated use Factory::create
     *
     * @param string $vastVersion
     *
     * @return Document
     */
    public static function create($vastVersion = '2.0')
    {
        return self::getFactory()->create($vastVersion);
    }

    /**
     * @deprecated use Factory::fromFile
     *
     * @param string $filename
     *
     * @return Document
     */
    public static function fromFile($filename)
    {
        return self::getFactory()->fromFile($filename);
    }

    /**
     * @deprecated use Factory::fromString
     *
     * @param string $xmlString
     *
     * @return Document
     */
    public static function fromString($xmlString)
    {
        return self::getFactory()->fromString($xmlString);
    }
}
