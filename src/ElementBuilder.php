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

namespace Sokil\Vast;

use Sokil\Vast\Ad\InLine;
use Sokil\Vast\Ad\Wrapper;
use Sokil\Vast\Creative\InLine\Linear as InLineAdLinearCreative;
use Sokil\Vast\Creative\Wrapper\Linear as WrapperAdLinearCreative;
use Sokil\Vast\Creative\InLine\Linear\MediaFile;
use Sokil\Vast\Creative\InLine\Linear\ClosedCaptionFile;

/**
 * Builder of VAST document elements, useful for overriding element classes
 */
class ElementBuilder
{
    /**
     * <?xml> with <VAST> inside
     *
     * @param \DomDocument $xmlDocument
     *
     * @return Document
     */
    public function createDocument(\DomDocument $xmlDocument): Document
    {
        return new Document(
            $xmlDocument,
            $this
        );
    }

    /**
     * <Ad> with <InLine> inside
     *
     * @param \DomElement $adElement
     *
     * @return InLine
     */
    public function createInLineAdNode(\DomElement $adElement): InLine
    {
        return new InLine($adElement, $this);
    }

    /**
     * <Ad> with <Wrapper> inside
     *
     * @param \DomElement $adElement
     *
     * @return Wrapper
     */
    public function createWrapperAdNode(\DomElement $adElement): Wrapper
    {
        return new Wrapper($adElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return InLineAdLinearCreative
     */
    public function createInLineAdLinearCreative(\DOMElement $creativeDomElement): InLineAdLinearCreative
    {
        return new InLineAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><Wrapper><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return WrapperAdLinearCreative
     */
    public function createWrapperAdLinearCreative(\DOMElement $creativeDomElement): WrapperAdLinearCreative
    {
        return new WrapperAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFiles><MediaFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return MediaFile
     */
    public function createInLineAdLinearCreativeMediaFile(\DOMElement $mediaFileDomElement): MediaFile
    {
        return new MediaFile($mediaFileDomElement);
    }
    
    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFiles><ClosedCaptionFiles><ClosedCaptionFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return ClosedCaptionFile
     */
    public function createInLineAdLinearCreativeClosedCaptionFile(\DOMElement $mediaFileDomElement): ClosedCaptionFile
    {
        return new ClosedCaptionFile($mediaFileDomElement);
    }
}
