<?php

namespace Sokil\Vast\Creative\Inline;

use Sokil\Vast\Creative\AbstractLinearCreative;
use Sokil\Vast\Creative\InLine\Linear\MediaFile;

class Linear extends AbstractLinearCreative
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
        if (!$this->mediaFilesDomElement) {
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

        $this->getDomElement()->firstChild->setAttribute('skipoffset', $time);

        return $this;
    }
}
