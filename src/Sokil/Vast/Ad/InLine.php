<?php

namespace Sokil\Vast\Ad;

class InLine extends \Sokil\Vast\Ad
{
    /**
     * Creatives
     *
     * @var array
     */
    private $creatives = array();
    
    /**
     * @var \DomElement
     */
    private $creativesDomElement;
    
    /**
     * @var \DomElement
     */
    private $extensionsDomElement;
    
    /**
     * Set Ad title
     *
     * @param string $adTitle
     *
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdTitle($adTitle)
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($adTitle);
    
        // get AdTitle tag
        $adTitleDomElement = $this->domElement->getElementsByTagName('AdTitle')->item(0);
        if (!$adTitleDomElement) {
            $adTitleDomElement = $this->domElement->ownerDocument->createElement('AdTitle', $adTitle);
            $this->domElement->firstChild->appendChild($adTitleDomElement);
        }
        
        // update CData
        if ($adTitleDomElement->hasChildNodes()) {
            $adTitleDomElement->replaceChild($cdata, $adTitleDomElement->firstChild);
        } else {  // insert cdata
            $adTitleDomElement->appendChild($cdata);
        }
        
        return $this;
    }
    
    /**
     * Set impression tracking url
     *
     * @param string $url
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setImpression($url)
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);
        
        // get impression tag
        $impressionDomElement = $this->domElement->getElementsByTagName('Impression')->item(0);
        if (!$impressionDomElement) {
            $impressionDomElement = $this->domElement->ownerDocument->createElement('Impression');
            $this->domElement->firstChild->appendChild($impressionDomElement);
        }
        
        // update CData
        if ($impressionDomElement->hasChildNodes()) {
            $impressionDomElement->replaceChild($cdata, $impressionDomElement->firstChild);
        } else { // insert cdata
            $impressionDomElement->appendChild($cdata);
        }
        
        return $this;
    }
    
    /**
     * Create "creative" object of given type
     *
     * @param string $type
     * @throws \Exception
     *
     * @return \Sokil\Vast\Ad\InLine\Creative\Base
     */
    private function _createCreative($type)
    {
        // check type
        $creativeClassName = '\\Sokil\Vast\\Ad\\InLine\\Creative\\' . $type;
        if (!class_exists($creativeClassName)) {
            throw new \Exception('Wrong crative specified');
        }
        
        // get container
        if (!$this->creativesDomElement) {
            // get creatives tag
            $this->creativesDomElement = $this->domElement->getElementsByTagName('Creatives')->item(0);
            if (!$this->creativesDomElement) {
                $this->creativesDomElement = $this->domElement->ownerDocument->createElement('Creatives');
                $this->domElement->firstChild->appendChild($this->creativesDomElement);
            }
        }
        
        // Creative dom element
        $creativeDomElement = $this->creativesDomElement->ownerDocument->createElement('Creative');
        $this->creativesDomElement->appendChild($creativeDomElement);
        
        // Cteative type dom element
        $creativeTypeDomElement = $this->domElement->ownerDocument->createElement($type);
        $creativeDomElement->appendChild($creativeTypeDomElement);
        
        // object
        $creative = new $creativeClassName($creativeDomElement);
        $this->creatives[] = $creative;
        
        return $creative;
    }
    
    /**
     * 
     * @return \Sokil\Vast\Ad\InLine\Creative\Linear
     */
    public function createLinearCreative()
    {
        return $this->_createCreative('Linear');
    }

    /**
     * Add extension
     *
     * @param string $type
     * @param string $value
     *
     * @return $this
     */
    public function addExtension($type, $value)
    {
        // get container
        if (!$this->extensionsDomElement) {
            // get creatives tag
            $this->extensionsDomElement = $this->domElement->getElementsByTagName('Extensions')->item(0);
            if (!$this->extensionsDomElement) {
                $this->extensionsDomElement = $this->domElement->ownerDocument->createElement('Extensions');
                $this->domElement->firstChild->appendChild($this->extensionsDomElement);
            }
        }
        
        // Creative dom element
        $extensionDomElement = $this->extensionsDomElement->ownerDocument->createElement('Extension');
        $this->extensionsDomElement->appendChild($extensionDomElement);
        
        // create cdata
        $cdata = $this->domElement->ownerDocument->createCDATASection($value);
        
        // append
        $extensionDomElement->setAttribute('type', $type);
        $extensionDomElement->appendChild($cdata);
        
        return $this;
    }
}