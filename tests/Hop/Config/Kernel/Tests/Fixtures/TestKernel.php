<?php

/**
 * This file is part of hoppinger/config-kernel
 *
 * (c) Hoppinger BV <info@hoppinger.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hop\Config\Kernel\Tests\Fixtures;

use Hop\Config\Kernel\Kernel;

class TestKernel extends Kernel
{
    protected $bundles = array();

    public function registerBundles()
    {
        return array();
    }

    public function getKernelParameters()
    {
        return parent::getKernelParameters();
    }

    public function getDebugModes()
    {
        return parent::getDebugModes();
    }

    public function init()
    {
    }
}
