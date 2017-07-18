<?php

namespace Sokil\Vast\Creative\Inline;

class Linear extends \Sokil\Vast\Creative\Linear
{
    private $mediaFilesDomElement;

    /**
     * Set duration value
     *
     * @param mixed $duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        // get dom element
        $durationDomElement = $this->domElement->getElementsByTagName('Duration')->item(0);
        if (!$durationDomElement) {
            $durationDomElement = $this->domElement->ownerDocument->createElement('Duration');
            $this->domElement->firstChild->appendChild($durationDomElement);
        }

        // set value
        if (is_numeric($duration)) {
            // in seconds
            $duration = $this->secondsToString($duration);
        }

        $durationDomElement->nodeValue = $duration;

        return $this;
    }


    public function createMediaFile()
    {
        if (!$this->mediaFilesDomElement) {
            $this->mediaFilesDomElement = $this->domElement->getElementsByTagName('MediaFiles')->item(0);
            if (!$this->mediaFilesDomElement) {
                $this->mediaFilesDomElement = $this->domElement->ownerDocument->createElement('MediaFiles');
                $this->domElement->firstChild->appendChild($this->mediaFilesDomElement);
            }
        }

        // dom
        $mediaFileDomElement = $this->mediaFilesDomElement->ownerDocument->createElement('MediaFile');
        $this->mediaFilesDomElement->appendChild($mediaFileDomElement);

        // object
        return new \Sokil\Vast\Creative\InLine\Linear\MediaFile($mediaFileDomElement);
    }

    /**
     * Convert seconds to H:m:i
     * Hours could be more than 24
     *
     * @param mixed $seconds
     *
     * @return string
     */
    private function secondsToString($seconds)
    {
        $seconds = (int) $seconds;

        $time = array();

        // get hours
        $hours = floor($seconds / 3600);
        $time[] = str_pad($hours, 2, '0', STR_PAD_LEFT);

        // get minutes
        $seconds = $seconds % 3600;
        $time[] = str_pad(floor($seconds / 60), 2, '0', STR_PAD_LEFT);

        // get seconds
        $time[] = str_pad($seconds % 60, 2, '0', STR_PAD_LEFT);

        return implode(':', $time);
    }

    public function skipAfter($time)
    {
        if (is_numeric($time)) {
            $time = $this->secondsToString($time);
        }

        $this->domElement->firstChild->setAttribute('skipoffset', $time);

        return $this;
    }

    /**
     * Set video click through url
     *
     * @param string $url
     * @return $this
     */
    public function setVideoClicksClickThrough($url)
    {
        // create cdata
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);

        // create ClickThrough
        $clickThroughDomElement = $this->getVideoClicksDomElement()->getElementsByTagName('ClickThrough')->item(0);
        if (!$clickThroughDomElement) {
            $clickThroughDomElement = $this->domElement->ownerDocument->createElement('ClickThrough');
            $this->getVideoClicksDomElement()->appendChild($clickThroughDomElement);
        }

        // update CData
        if ($clickThroughDomElement->hasChildNodes()) {
            $clickThroughDomElement->replaceChild($cdata, $clickThroughDomElement->firstChild);
        } else { // insert CData
            $clickThroughDomElement->appendChild($cdata);
        }

        return $this;
    }
}