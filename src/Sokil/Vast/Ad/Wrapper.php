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
        return $this->setTagValue('VASTAdTagURI', $uri);
    }
}
