<?php

namespace Sokil\Vast\Creative\InLine\Linear;

class ClosedCaption
{   
    private $domElement;
    
    public function __construct(\DomElement $domElement)
    {
        $this->domElement = $domElement;
    }
    
    public function setType($mime)
    {
        $this->domElement->setAttribute('type', $mime);
        return $this;
    }
    
    public function setLanguage($language)
    {
        $this->domElement->setAttribute('language', $language);
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
