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
    private function _createAdSection($type)
    {        
        // Check Ad type
        $adTypeClassName = '\\Sokil\\Vast\\Ad\\' . $type;
        if(!class_exists($adTypeClassName)) {
            throw new \Exception('Ad type ' . $type . ' not allowed');
        }
        
        // create dom node
        $adDomElement = $this->_xml->createElement('Ad');
        $this->_xml->documentElement->appendChild($adDomElement);

        // Create type element
        $adTypeDomElement = $this->_xml->createElement($type);
        $adDomElement->appendChild($adTypeDomElement);
        
        // create ad section
        $adSection = new $adTypeClassName($adDomElement);
        
        // cache
        $this->_vastAdSequence[] = $adSection;
        
        return $adSection;
    }
    
    /**
     * 
     * @return \Sokil\Vast\Ad\InLine
     */
    public function createInLineAdSection()
    {
        return $this->_createAdSection('InLine');
    }
    
    /**
     * 
     * @return \Sokil\Vast\Ad\Wrapper
     */
    public function createWrapperAdSection()
    {
        return $this->_createAdSection('Wrapper');
    }
    
    public function getAdSections()
    {
        if(!$this->_vastAdSequence) {
            
            foreach($this->_xml->documentElement->childNodes as $adDomElement) {
                
                // get Ad tag
                if(!($adDomElement instanceof \DOMElement)) {
                    continue;
                }
                
                if('ad' !== strtolower($adDomElement->tagName)) {
                    continue;
                }

                // get Ad type tag
                foreach($adDomElement->childNodes as $node) {
                    if(!($node instanceof \DomElement)) {
                        continue;
                    }
                    
                    $type = $node->tagName;

                    // create ad section
                    $adTypeClassName = '\\Sokil\\Vast\\Ad\\' . $type;
                    if(!class_exists($adTypeClassName)) {
                        throw new \Exception('Ad type ' . $type . ' not allowed');
                    }

                    $this->_vastAdSequence[] = new $adTypeClassName($adDomElement);
                    break;
                }
            }
        }
        
        
        return $this->_vastAdSequence;
    }
}