<?php

namespace Sokil\Vast\Creative\InLine\Linear;

class MediaFile
{
    const DELIVERY_PROGRESSIVE = 'progressive';
    const DELIVERY_STREAMING = 'streaming';
    
    private $domElement;
    
    public function __construct(\DomElement $domElement)
    {
        $this->domElement = $domElement;
    }
    
    public function setProgressiveDelivery()
    {
        $this->domElement->setAttribute('delivery', self::DELIVERY_PROGRESSIVE);
        return $this;
    }
    
    public function setStreamingDelivery()
    {
        $this->domElement->setAttribute('delivery', self::DELIVERY_STREAMING);
        return $this;
    }
    
    public function setDelivery($delivery)
    {
        if (!in_array($delivery, array(self::DELIVERY_PROGRESSIVE, self::DELIVERY_STREAMING))) {
            throw new \Exception('Wrong delivery specified');
        }
        
        $this->domElement->setAttribute('delivery', $delivery);
        return $this;
    }
    
    public function setType($mime)
    {
        $this->domElement->setAttribute('type', $mime);
        return $this;
    }
    
    public function setWidth($width)
    {
        $this->domElement->setAttribute('width', $width);
        return $this;
    }
    
    public function setHeight($height)
    {
        $this->domElement->setAttribute('height', $height);
        return $this;
    }
    
    public function setUrl($url)
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);
    
        // update CData
        if ($this->domElement->hasChildNodes()) {
            $this->domElement->replaceChild($cdata, $this->domElement->firstChild);
        } // insert CData
        else {
            $this->domElement->appendChild($cdata);
        }
        return $this;
    }
}
