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
    public function createCreative()
    {
        // get container
        if(!$this->_creativesDomElement) {
            // get creatives tag
            $this->_creativesDomElement = $this->_domElement->getElementsByTagName('creatives')->item(0);
            if(!$this->_creativesDomElement) {
                $this->_creativesDomElement = $this->_domElement->ownerDocument->createElement('Creatives');
                $this->_domElement->firstChild->appendChild($this->_creativesDomElement);
            }
        }
        
        // dom
        $creativeDomElement = $this->_creativesDomElement->ownerDocument->createElement('Creative');
        $this->_creativesDomElement->appendChild($creativeDomElement);
        
        // object
        $creative = new Creative($creativeDomElement);
        $this->_creatives[] = $creative;
        
        return $creative;
    }
}