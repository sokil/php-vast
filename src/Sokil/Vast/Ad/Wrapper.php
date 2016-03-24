<?php

namespace Sokil\Vast\Ad;

class Wrapper extends \Sokil\Vast\Ad
{

    /**
     * adds a VASTAdTagURI-Node to Wrapper-Node
     *
     * @param $uri
     * @return $this
     */
    public function addVASTAdTagURI($uri)
    {
        // create VASTAdTagURI-Node
        $VASTAdTagURIDomElement = $this->_domElement->ownerDocument->createElement('VASTAdTagURI');
        $this->_domElement->firstChild->appendChild($VASTAdTagURIDomElement);

        // create VASTAdTagURI-cdata
        $cdata = $this->_domElement->ownerDocument->createCDATASection($uri);
        $VASTAdTagURIDomElement->appendChild($cdata);

        return $this;
    }

    /**
     * adds a AdSystem-Node to Wrapper-Node
     *
     * @param string $adSystem
     * @return \Sokil\Vast\Ad\Wrapper
     */
    public function setAdSystem($adSystem)
    {
        $adSystemDomElement = $this->_domElement->getElementsByTagName('AdSystem')->item(0);
        if ($adSystemDomElement) {
            $adSystemDomElement->nodeValue = $adSystem;
        } else {
            $adSystemDomElement = $this->_domElement->ownerDocument->createElement('AdSystem', $adSystem);
            $this->_domElement->firstChild->appendChild($adSystemDomElement);
        }

        return $this;
    }
}