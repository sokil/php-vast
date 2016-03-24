<?php

namespace Sokil\Vast\Ad;

class Wrapper extends \Sokil\Vast\Ad
{

    /**
     * URI of ad tag of downstream Secondary Ad Server
     *
     * @param $uri
     * @return $this
     */
    public function addVASTAdTagURI($uri)
    {
        // create VASTAdTagURI-Node
        $VASTAdTagURIDomElement = $this->domElement->ownerDocument->createElement('VASTAdTagURI');
        $this->domElement->firstChild->appendChild($VASTAdTagURIDomElement);

        // create VASTAdTagURI-cdata
        $cdata = $this->domElement->ownerDocument->createCDATASection($uri);
        $VASTAdTagURIDomElement->appendChild($cdata);

        return $this;
    }
}