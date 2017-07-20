<?php

namespace Sokil\Vast;

use Sokil\Vast\Ad\AbstractAd;

class Document
{
    /**
     * @var \Sokil\Vast\Util\ElementWrapper
     */
    private $elementWrapper;

    /**
     * @var \DomDocument
     */
    private $xml;

    /**
     * Cached ad sequence
     *
     * @var array
     */
    private $vastAdSequence = array();

    /** @var Factory */
    private static $documentFactory;

    /**
     * @param \DOMDocument $xml
     */
    public function __construct(\DOMDocument $xml)
    {
        $this->xml = $xml;
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
        return $this->xml->saveXML();

    }

    /**
     * Get DomDocument object
     *
     * @return \DomDocument
     */
    public function toDomDocument()
    {
        return $this->xml;
    }

    /**
     * Get element wrapper helper
     *
     * @return \Sokil\Vast\Util\ElementWrapper
     */
    protected function getElementWrapper()
    {
        if (null === $this->elementWrapper) {
            $this->elementWrapper = new \Sokil\Vast\Util\ElementWrapper(
                $this->xml->documentElement
            );
        }

        return $this->elementWrapper;
    }
    
    /**
     * Create "Ad" section ov "VAST" node
     *
     * @param string $type
     *
     * @throws \Exception
     *
     * @return AbstractAd
     */
    private function createAdSection($type)
    {        
        // Check Ad type
        $adTypeClassName = '\\Sokil\\Vast\\Ad\\' . $type;
        if (!class_exists($adTypeClassName)) {
            throw new \InvalidArgumentException('Ad type ' . $type . ' not supported');
        }
        
        // create dom node
        $adDomElement = $this->xml->createElement('Ad');
        $this->xml->documentElement->appendChild($adDomElement);

        // Create type element
        $adTypeDomElement = $this->xml->createElement($type);
        $adDomElement->appendChild($adTypeDomElement);
        
        // create ad section
        $adSection = new $adTypeClassName($adDomElement);
        
        // cache
        $this->vastAdSequence[] = $adSection;
        
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
     * @return array
     * @throws \Exception
     */
    public function getAdSections()
    {
        if (!$this->vastAdSequence) {
            
            foreach ($this->xml->documentElement->childNodes as $adDomElement) {
                
                // get Ad tag
                if (!($adDomElement instanceof \DOMElement)) {
                    continue;
                }
                
                if ('ad' !== strtolower($adDomElement->tagName)) {
                    continue;
                }

                // get Ad type tag
                foreach ($adDomElement->childNodes as $node) {
                    if (!($node instanceof \DomElement)) {
                        continue;
                    }
                    
                    $type = $node->tagName;

                    // create ad section
                    $adTypeClassName = '\\Sokil\\Vast\\AbstractAd\\' . $type;
                    if (!class_exists($adTypeClassName)) {
                        throw new \Exception('Ad type ' . $type . ' not supported');
                    }

                    $this->vastAdSequence[] = new $adTypeClassName($adDomElement);
                    break;
                }
            }
        }
        
        return $this->vastAdSequence;
    }

    /**
     * Add Error tracking url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setError($url)
    {
        $this->getElementWrapper()->setUniqTagValue('Error', $url);

        return $this;
    }

    /**
     * Get previously set Error tracking url value
     *
     * @return null|string
     */
    public function getError()
    {
        return $this->getElementWrapper()->getUniqTagValue('Error');
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
