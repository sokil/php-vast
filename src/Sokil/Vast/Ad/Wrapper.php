<?php

namespace Sokil\Vast\Ad;

class Wrapper extends \Sokil\Vast\Ad\Ad
{
    use \Sokil\Vast\Traits\UniqTag;
    use \Sokil\Vast\Traits\Error;
    use \Sokil\Vast\Traits\Impression;

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

    /**
     * @inheritdoc
     */
    protected function buildCreativeClassName($type)
    {
        return '\\Sokil\\Vast\\Creative\\Wrapper\\' . $type;
    }

    /**
     * Create Linear creative
     *
     * @return \Sokil\Vast\Creative\Wrapper\Linear
     */
    public function createLinearCreative()
    {
        return $this->_createCreative('Linear');
    }
}
