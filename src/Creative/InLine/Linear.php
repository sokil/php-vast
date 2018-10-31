<?php

namespace Sokil\Vast\Creative\InLine;

use Sokil\Vast\Creative\AbstractLinearCreative;
use Sokil\Vast\Creative\InLine\Linear\MediaFile;
use Sokil\Vast\Creative\InLine\Linear\AdParameters;

class Linear extends AbstractLinearCreative
{
    /**
     * @var \DOMElement
     */
    private $mediaFilesDomElement;

    /**
     * @var \DOMElement
     */
    private $adParametersDomElement;

    /**
     * Set duration value
     *
     * @param int|string $duration seconds or time in format "H:m:i"
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        // get dom element
        $durationDomElement = $this->getDomElement()->getElementsByTagName('Duration')->item(0);
        if (!$durationDomElement) {
            $durationDomElement = $this->getDomElement()->ownerDocument->createElement('Duration');
            $this->getDomElement()->firstChild->appendChild($durationDomElement);
        }

        // set value
        if (is_numeric($duration)) {
            // in seconds
            $duration = $this->secondsToString($duration);
        }

        $durationDomElement->nodeValue = $duration;

        return $this;
    }

    /**
     * @return MediaFile
     */
    public function createMediaFile()
    {
        if (empty($this->mediaFilesDomElement)) {
            $this->mediaFilesDomElement = $this->getDomElement()->getElementsByTagName('MediaFiles')->item(0);
            if (!$this->mediaFilesDomElement) {
                $this->mediaFilesDomElement = $this->getDomElement()->ownerDocument->createElement('MediaFiles');
                $this->getDomElement()->firstChild->appendChild($this->mediaFilesDomElement);
            }
        }

        // dom
        $mediaFileDomElement = $this->mediaFilesDomElement->ownerDocument->createElement('MediaFile');
        $this->mediaFilesDomElement->appendChild($mediaFileDomElement);

        // object
        return new MediaFile($mediaFileDomElement);
    }

    /**
     * @param array|string $params
     *
     * @return self
     */
    public function setAdParameters($params)
    {
        $this->adParametersDomElement = $this->getDomElement()->getElementsByTagName('AdParameters')->item(0);
        if (!$this->adParametersDomElement) {
            $this->adParametersDomElement = $this->getDomElement()->ownerDocument->createElement('AdParameters');
            $this->getDomElement()->firstChild->appendChild($this->adParametersDomElement);
        }

        if (is_array($params)) {
            $params = json_encode($params);
        }

        $cdata = $this->adParametersDomElement->ownerDocument->createCDATASection($params);

        // update CData
        if ($this->adParametersDomElement->hasChildNodes()) {
            $this->adParametersDomElement->replaceChild($cdata, $this->adParametersDomElement->firstChild);
        } // insert CData
        else {
            $this->adParametersDomElement->appendChild($cdata);
        }

        return $this;
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

    /**
     * @param int|string $time seconds or time in format "H:m:i"
     * @return $this
     */
    public function skipAfter($time)
    {
        if (is_numeric($time)) {
            $time = $this->secondsToString($time);
        }

        $this->getDomElement()->firstChild->setAttribute('skipoffset', $time);

        return $this;
    }
}
