<?php

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
