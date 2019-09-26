<?php

namespace Sokil\Vast\Stub\CustomElementBuilder;

use Sokil\Vast\Creative\InLine\Linear\MediaFile;
use Sokil\Vast\Document;
use Sokil\Vast\ElementBuilder;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomDocument;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomInLine;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomMediaFile;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomWrapper;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomWrapperAdLinearCreative;
use Sokil\Vast\Stub\CustomElementBuilder\Element\CustomInLineAdLinearCreative;
use Sokil\Vast\Creative\Wrapper\Linear as WrapperAdLinearCreative;
use Sokil\Vast\Creative\InLine\Linear as InLineAdLinearCreative;
use Sokil\Vast\Ad\Wrapper;
use Sokil\Vast\Ad\InLine;

class CustomElementBuilder extends ElementBuilder
{
    /**
     * <?xml> with <VAST> inside
     *
     * @param \DomDocument $xmlDocument
     *
     * @return CustomDocument
     */
    public function createDocument(\DomDocument $xmlDocument): Document
    {
        return new CustomDocument(
            $xmlDocument,
            $this
        );
    }

    /**
     * <Ad> with <InLine> inside
     *
     * @param \DomElement $adElement
     *
     * @return CustomInLine
     */
    public function createInLineAdNode(\DomElement $adElement): InLine
    {
        return new CustomInLine($adElement, $this);
    }

    /**
     * <Ad> with <Wrapper> inside
     *
     * @param \DomElement $adElement
     *
     * @return CustomWrapper
     */
    public function createWrapperAdNode(\DomElement $adElement): Wrapper
    {
        return new CustomWrapper($adElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return CustomInLineAdLinearCreative
     */
    public function createInLineAdLinearCreative(\DOMElement $creativeDomElement): InLineAdLinearCreative
    {
        return new CustomInLineAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><Wrapper><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return CustomWrapperAdLinearCreative
     */
    public function createWrapperAdLinearCreative(\DOMElement $creativeDomElement): WrapperAdLinearCreative
    {
        return new CustomWrapperAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return CustomMediaFile
     */
    public function createInLineAdLinearCreativeMediaFile(\DOMElement $mediaFileDomElement): MediaFile
    {
        return new CustomMediaFile($mediaFileDomElement);
    }

}