<?php

namespace Sokil\Vast\Traits;

trait Impression
{
    /**
     * Add Impression tracking url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setImpression($url)
    {
        return $this->setTagValue('Impression', $url);
    }

    /**
     * Get previously set Impression tracking url value
     *
     * @return null|string
     */
    public function getImpression()
    {
        return $this->getTagValue('Impression');
    }

    /**
     * Set value for given tag
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    abstract public function setTagValue($name, $value);

    /**
     * Get given tag value
     *
     * @param string $name
     *
     * @return null|string
     */
    abstract public function getTagValue($name);
}