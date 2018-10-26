<?php

namespace Sokil\Vast\Creative\InLine\Linear;

class AdParameters
{
    private $domElement;
    
    public function __construct(\DomElement $domElement)
    {
        $this->domElement = $domElement;
    }

    public function setParams($params)
    {
        if (is_array($params)) {
            $params = json_encode($params);
        }
        $cdata = $this->domElement->ownerDocument->createCDATASection($params);
    
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
