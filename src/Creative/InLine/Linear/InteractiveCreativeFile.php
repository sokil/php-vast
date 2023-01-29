<?php
declare(strict_types=1);

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sokil\Vast\Creative\InLine\Linear;

/**
 * Optional node that enables interactive creative files associated with the ad media (video or audio)
 * to be provided to the player.
 *
 * Compatible with VAST starting from version 4.0
 *
 * See section 3.9.3 of VAST specification version 4.1
 *
 * @author Bram Devries <bramdevries93@gmail.com>
 */
class InteractiveCreativeFile
{
    /**
     * @var \DomElement
     */
    private $domElement;

    /**
     * @param \DomElement $domElement
     */
    public function __construct(\DomElement $domElement)
    {
        $this->domElement = $domElement;
    }

    /**
     * Set file mime type
     *
     * @param string $mime Mime type of the file
     */
    public function setType(string $mime): self
    {
        $this->domElement->setAttribute('type', $mime);

        return $this;
    }

    /**
     * @param string $apiFramework the API needed to execute the resource file if applicable.
     */
    public function setApiFramework(string $apiFramework): self
    {
        $this->domElement->setAttribute('apiFramework', $apiFramework);

        return $this;
    }

    /**
     * Set file URL
     *
     * @param string $url URL of the file
     */
    public function setUrl(string $url): self
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);

        // update CData
        if ($this->domElement->hasChildNodes()) {
            $this->domElement->replaceChild($cdata, $this->domElement->firstChild);
        } // insert CData
        else {
            $this->domElement->appendChild($cdata);
        }
        return $this;
    }
}
