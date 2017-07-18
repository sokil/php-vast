<?php

namespace Sokil\Vast\Traits;

trait Error
{
    use UniqTag;

    /**
     * Add Error tracking url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setError($url)
    {
        return $this->setTagValue('Error', $url);
    }

    /**
     * Get previously set Error tracking url value
     *
     * @return null|string
     */
    public function getError()
    {
        return $this->getTagValue('Error');
    }
}