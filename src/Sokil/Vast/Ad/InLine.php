<?php

namespace Sokil\Vast\Ad;

/**
 * @method \Sokil\Vast\Ad\InLine setId(integer $id) Set "id" of Ad section
 */
class InLine extends \Sokil\Vast\Ad
{
    private $creatives = array();
    
    /**
     *
     * @var \DomElement
     */
    private $creativesDomElement;
    
    /**
     *
     * @var \DomElement
     */
    private $extensionsDomElement;
    
    /**
     * 
     * @param string $adTitle
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdTitle($adTitle)
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($adTitle);
    
        // get AdTitle tag
        $adTitleDomElement = $this->domElement->getElementsByTagName('AdTitle')->item(0);
        if(!$adTitleDomElement) {
            $adTitleDomElement = $this->domElement->ownerDocument->createElement('AdTitle', $adTitle);
            $this->domElement->firstChild->appendChild($adTitleDomElement);
        }
        
        // update CData
        if($adTitleDomElement->hasChildNodes()) {
            $adTitleDomElement->replaceChild($cdata, $adTitleDomElement->firstChild);
        }
        
        // insert cdata
        else {
            $adTitleDomElement->appendChild($cdata);
        }
        
        return $this;
    }
    
    /**
     * 
     * @param string $url
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setImpression($url)
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);
        
        // get impression tag
        $impressionDomElement = $this->domElement->getElementsByTagName('Impression')->item(0);
        if(!$impressionDomElement) {
            $impressionDomElement = $this->domElement->ownerDocument->createElement('Impression');
            $this->domElement->firstChild->appendChild($impressionDomElement);
        }
        
        // update CData
        if($impressionDomElement->hasChildNodes()) {
            $impressionDomElement->replaceChild($cdata, $impressionDomElement->firstChild);
        }
        
        // insert cdata
        else {
            $impressionDomElement->appendChild($cdata);
        }
        
        return $this;
    }
    
    /**
     * 
     * @return \Sokil\Vast\Ad\InLine\Creative
     */
    private function _createCreative($type)
    {
        // check type
        $creativeClassName = '\\Sokil\Vast\\Ad\\InLine\\Creative\\' . $type;
        if(!class_exists($creativeClassName)) {
            throw new \Exception('Wrong crative specified');
        }
        
        // get container
        if(!$this->creativesDomElement) {
            // get creatives tag
            $this->creativesDomElement = $this->domElement->getElementsByTagName('Creatives')->item(0);
            if(!$this->creativesDomElement) {
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
    
    public function addExtension($type, $value)
    {
        // get container
        if(!$this->extensionsDomElement) {
            // get creatives tag
            $this->extensionsDomElement = $this->domElement->getElementsByTagName('Extensions')->item(0);
            if(!$this->extensionsDomElement) {
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