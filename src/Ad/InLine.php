<?php

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sokil\Vast\Ad;

use Sokil\Vast\Creative\InLine\Linear;

class InLine extends AbstractAdNode
{
    /**
     * Set Ad title
     *
     * @param string $value
     *
     * @return InLine
     */
    public function setAdTitle($value)
    {
        $this->setScalarNodeCdata('AdTitle', $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function buildCreativeClassName($type)
    {
        return '\\Sokil\\Vast\\Creative\\InLine\\' . $type;
    }

    /**
     * Create Linear creative
     *
     * @throws \Exception
     *
     * @return Linear
     */
    public function createLinearCreative()
    {
        /** @var Linear $creative */
        $creative = $this->buildCreative('Linear');

        return $creative;
    }
}
