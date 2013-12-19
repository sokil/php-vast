<?php

namespace Sokil\Vast\Ad;

use Sokil\Vast\Ad\InLine\Creative;

/**
 * @method \Sokil\Vast\Ad\InLine setId(integer $id) Set "id" of Ad section
 */
class InLine extends \Sokil\Vast\Ad
{
    private $_creatives = array();
    
    /**
     *
     * @var \DomElement
     */
    private $_creativesDomElement;
    
    /**
     *
     * @var \DomElement
     */
    private $_extensionsDomElement;
    
    /**
     * 
     * @param type $adSystem
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdSystem($adSystem)
    {
        $adSystemDomElement = $this->_domElement->getElementsByTagName('AdSystem')->item(0);
        if($adSystemDomElement) {
            $adSystemDomElement->nodeValue = $adSystem;
        }
        else {
            $adSystemDomElement = $this->_domElement->ownerDocument->createElement('AdSystem', $adSystem);
            $this->_domElement->firstChild->appendChild($adSystemDomElement);
        }
        
        return $this;
    }
    
    /**
     * 
     * @param type $adTitle
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setAdTitle($adTitle)
    {
        $cdata = $this->_domElement->ownerDocument->createCDATASection($adTitle);
    
        // get AdTitle tag
        $adTitleDomElement = $this->_domElement->getElementsByTagName('AdTitle')->item(0);
        if(!$adTitleDomElement) {
            $adTitleDomElement = $this->_domElement->ownerDocument->createElement('AdTitle', $adTitle);
            $this->_domElement->firstChild->appendChild($adTitleDomElement);
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
     * @param type $url
     * @return \Sokil\Vast\Ad\InLine
     */
    public function setImpression($url)
    {
        $cdata = $this->_domElement->ownerDocument->createCDATASection($url);
        
        // get impression tag
        $impressionDomElement = $this->_domElement->getElementsByTagName('Impression')->item(0);
        if(!$impressionDomElement) {
            $impressionDomElement = $this->_domElement->ownerDocument->createElement('Impression');
            $this->_domElement->firstChild->appendChild($impressionDomElement);
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
        if(!$this->_creativesDomElement) {
            // get creatives tag
            $this->_creativesDomElement = $this->_domElement->getElementsByTagName('Creatives')->item(0);
            if(!$this->_creativesDomElement) {
                $this->_creativesDomElement = $this->_domElement->ownerDocument->createElement('Creatives');
                $this->_domElement->firstChild->appendChild($this->_creativesDomElement);
            }
        }
        
        // Creative dom element
        $creativeDomElement = $this->_creativesDomElement->ownerDocument->createElement('Creative');
        $this->_creativesDomElement->appendChild($creativeDomElement);
        
        // Cteative type dom element
        $creativeTypeDomElement = $this->_domElement->ownerDocument->createElement($type);
        $creativeDomElement->appendChild($creativeTypeDomElement);
        
        // object
        $creative = new $creativeClassName($creativeDomElement);
        $this->_creatives[] = $creative;
        
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
        if(!$this->_extensionsDomElement) {
            // get creatives tag
            $this->_extensionsDomElement = $this->_domElement->getElementsByTagName('Extensions')->item(0);
            if(!$this->_extensionsDomElement) {
                $this->_extensionsDomElement = $this->_domElement->ownerDocument->createElement('Extensions');
                $this->_domElement->firstChild->appendChild($this->_extensionsDomElement);
            }
        }
        
        // Creative dom element
        $extensionDomElement = $this->_extensionsDomElement->ownerDocument->createElement('Extension');
        $this->_extensionsDomElement->appendChild($extensionDomElement);
        
        // create cdata
        $cdata = $this->_domElement->ownerDocument->createCDATASection($value);
        
        // append
        $extensionDomElement->setAttribute('type', $type);
        $extensionDomElement->appendChild($cdata);
        
        return $this;
    }
}