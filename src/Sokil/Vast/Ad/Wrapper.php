<?php

namespace Sokil\Vast\Ad;

class Wrapper extends \Sokil\Vast\Ad
{
    use \Sokil\Vast\Traits\Error;

    /**
     * UniqTag trait interface method
     *
     * @return \DOMElement
     */
    protected function getDomElement()
    {
        return $this->domElement->firstChild;
    }

    /**
     * URI of ad tag of downstream Secondary Ad Server
     *
     * @param string $uri
     * @return $this
     */
    public function setVASTAdTagURI($uri)
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($uri);

        // get VASTAdTagURI dom node
        $VASTAdTagURIDomElement = $this->domElement->getElementsByTagName('VASTAdTagURI')->item(0);

        // create VASTAdTagURI-Node
        if (!$VASTAdTagURIDomElement) {
            $VASTAdTagURIDomElement = $this->domElement->ownerDocument->createElement('VASTAdTagURI');
            $this->domElement->firstChild->appendChild($VASTAdTagURIDomElement);
        }

        // set cdata
        if ($VASTAdTagURIDomElement->hasChildNodes()) {
            $VASTAdTagURIDomElement->replaceChild($cdata, $VASTAdTagURIDomElement->firstChild);
        } else {
            $VASTAdTagURIDomElement->appendChild($cdata);
        }

        return $this;
    }
}
