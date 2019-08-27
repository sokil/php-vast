<?php

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

/**
 * Builder of VAST document elements, useful for overriding element classes
 */
class ElementBuilder
{
    /**
     * @param \DomDocument $xmlDocument <?xml> with <VAST> inside
     *
     * @return Document
     */
    public function createDocument(\DomDocument $xmlDocument)
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
    public function createInLineAdNode(\DomElement $adElement)
    {
        return new InLine($adElement);
    }

    /**
     * <Ad> with <Wrapper> inside
     *
     * @param \DomElement $adElement
     *
     * @return Wrapper
     */
    public function createWrapperAdNode(\DomElement $adElement)
    {
        return new Wrapper($adElement);
    }
}