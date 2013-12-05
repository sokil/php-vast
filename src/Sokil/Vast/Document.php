<?php

namespace Sokil\Vast;

class Document
{    
    /**
     *
     * @var \DomDocument
     */
    private $_xml;
    
    private $_vastAdSequence = array();
    
    public static function create($vastVersion = '2.0')
    {        
        $xml = new \DomDocument('1.0', 'UTF-8');
        
        // root
        $root = $xml->createElement('VAST');
        $xml->appendChild($root);
        
        // version
        $vastVersionAttribute = $xml->createAttribute('version');
        $vastVersionAttribute->value = $vastVersion;
        $root->appendChild($vastVersionAttribute);
        
        // return
        return new self($xml);
    }
    
    public static function fromFile($filename)
    {
        $xml = new \DomDocument('1.0', 'UTF-8');
        $xml->load($filename);
        
        return new self($xml);
    }
    
    public static function fromString($xmlString)
    {
        $xml = new \DomDocument('1.0', 'UTF-8');
        $xml->loadXml($xmlString);
        
        return new self($xml);
    }
    
    public function __construct(\DOMDocument $xml)
    {
        $this->_xml = $xml;
    }

    public function toString()
    {
        return $this->_xml->saveXML();
    }
    
    public function __toString()
    {
        return $this->toString();
    }
    
    public function toDomDocument()
    {
        return $this->_xml;
    }
    
    /**
     * Create "Ad" section ov "VAST" node
     * @return \Sokil\Vast\Ad
     */
    public function createAdSection()
    {
        $adSection = new Ad();
        $this->addAdSection($adSection);
        return $adSection;
    }
    
    /**
     * Add previously created "Ad" section to sequence
     * 
     * @param \Sokil\Vast\Ad $adSection
     * @return \Sokil\Vast\Document
     */
    public function addAdSection(Ad $adSection)
    {
        $this->_vastAdSequence[] = $adSection;
        
        $this->_xml->documentElement->appendChild($adSection->toDomElement());
        
        return $this;
    }
    
    public function getAdSections()
    {
        if(!$this->_vastAdSequence) {
            
            foreach($this->_xml->documentElement->childNodes as $adDomElement) {
                
                if(!($adDomElement instanceof \DOMElement)) {
                    continue;
                }
                
                if('ad' !== strtolower($adDomElement->tagName)) {
                    continue;
                }

                $this->_vastAdSequence[] = new Ad($adDomElement);
            }
        }
        
        
        return $this->_vastAdSequence;
    }
}