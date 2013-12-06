<?php

namespace Sokil\Vast\Ad\InLine\Creative\Base;

class MediaFile
{
    private $_domElement;
    
    public function __construct(\DomElement $domElement)
    {
        $this->_domElement = $domElement;
    }
    
    public function setProgressiveDelivery()
    {
        $this->_domElement->setAttribute('delivery', 'progressive');
        return $this;
    }
    
    public function setStreamingDelivery()
    {
        $this->_domElement->setAttribute('delivery', 'streaming');
        return $this;
    }
    
    public function setType($mime)
    {
        $this->_domElement->setAttribute('type', $mime);
        return $this;
    }
    
    public function setWidth($width)
    {
        $this->_domElement->setAttribute('width', $width);
        return $this;
    }
    
    public function setHeight($height)
    {
        $this->_domElement->setAttribute('height', $height);
        return $this;
    }
    
    public function setUrl($url)
    {
        $cdata = $this->_domElement->ownerDocument->createCDATASection($url);
    
        // update CData
        if($this->_domElement->hasChildNodes()) {
            $this->_domElement->replaceChild($cdata, $this->_domElement->firstChild);
        }
        
        // insert CData
        else {
            $this->_domElement->appendChild($cdata);
        }
    }
}