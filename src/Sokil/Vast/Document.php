<?php

namespace Sokil\Vast;

use Sokil\Vast\Ad\AbstractAdNode;
use Sokil\Vast\Document\AbstractNode;

class Document extends AbstractNode
{
    /**
     * @var \DOMDocument
     */
    private $domDocument;

    /**
     * Ad node list
     *
     * @var AbstractAdNode[]
     */
    private $vastAdNodeList = array();

    /** @var Factory */
    private static $documentFactory;

    /**
     * @param \DOMDocument $DOMDocument
     */
    public function __construct(\DOMDocument $DOMDocument)
    {
        $this->domDocument = $DOMDocument;
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
     * @return AbstractAdNode
     */
    private function createAdSection($type)
    {        
        // Check Ad type
        $adTypeClassName = '\\Sokil\\Vast\\Ad\\' . $type;
        if (!class_exists($adTypeClassName)) {
            throw new \InvalidArgumentException(sprintf('Ad type %s not supported', $type));
        }
        
        // create dom node
        $adDomElement = $this->domDocument->createElement('Ad');
        $this->domDocument->documentElement->appendChild($adDomElement);

        // create type element
        $adTypeDomElement = $this->domDocument->createElement($type);
        $adDomElement->appendChild($adTypeDomElement);
        
        // create ad section
        $adSection = new $adTypeClassName($adDomElement);
        
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
        return $this->createAdSection('InLine');
    }
    
    /**
     * Create Wrapper Ad section
     *
     * @return \Sokil\Vast\Ad\Wrapper
     */
    public function createWrapperAdSection()
    {
        return $this->createAdSection('Wrapper');
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
                $adTypeClassName = '\\Sokil\\Vast\\AbstractAdNode\\' . $type;
                if (!class_exists($adTypeClassName)) {
                    throw new \Exception('Ad type ' . $type . ' not supported');
                }

                $this->vastAdNodeList[] = new $adTypeClassName($adDomElement);
                break;
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
        $this->addCdataToArrayNode('Error', $url);
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
