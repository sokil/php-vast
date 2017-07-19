<?php

namespace Sokil\Vast\Ad;

class Wrapper extends \Sokil\Vast\Ad\Ad
{
    /**
     * URI of ad tag of downstream Secondary Ad Server
     *
     * @param string $uri
     * @return $this
     */
    public function setVASTAdTagURI($uri)
    {
        $this->getElementWrapper()->setUniqTagValue('VASTAdTagURI', $uri);

        return $this;
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

    /**
     * Add Error tracking url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setError($url)
    {
        $this->getElementWrapper()->setUniqTagValue('Error', $url);

        return $this;
    }

    /**
     * Get previously set Error tracking url value
     *
     * @return null|string
     */
    public function getError()
    {
        return $this->getElementWrapper()->getUniqTagValue('Error');
    }
    /**
     * Add Impression tracking url
     * NB! Non standard! By standard multiple impressions should be allowed.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setImpression($url)
    {
        $this->getElementWrapper()->setUniqTagValue('Impression', $url);

        return $this;
    }

    /**
     * Get previously set Impression tracking url value
     *
     * @return null|string
     */
    public function getImpression()
    {
        return $this->getElementWrapper()->getUniqTagValue('Impression');
    }
}
