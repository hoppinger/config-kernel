<?php

/**
 * This file is part of hoppinger/config-kernel
 *
 * (c) Hoppinger BV <info@hoppinger.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hop\Config\Kernel;

use Hop\Config\Target\TargetInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * @author Korstiaan de Ridder <korstiaan@korstiaan.com>
 */
abstract class Kernel extends BaseKernel
{
    /**
     * @var TargetInterface
     */
    protected $target;

    /**
     * Constructor
     *
     * @param TargetInterface $target
     * @param boolean         $debug
     */
    public function __construct(TargetInterface $target, $debug = null)
    {
        $this->target = $target;

        parent::__construct(
            $this->target->getMode(),
            null !== $debug && is_bool($debug) ? $debug : $this->isDebugMode()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->rootDir.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config_'.$this->target->getMode().'.yml');
        $loader->load($this->target->getTargetDir().DIRECTORY_SEPARATOR.'config.yml');
    }

    /**
     * {@inheritDoc}
     */
    protected function getKernelParameters()
    {
        return array_merge(
            array(
                'kernel.cnf.target'     => $this->target->getTarget(),
                'kernel.cnf.root_dir'   => $this->target->getRootDir(),
                'kernel.cnf.target_dir' => $this->target->getTargetDir(),
            ), parent::getKernelParameters()
        );
    }

    /**
     * Checks if we are in debug mode
     *
     * @return boolean
     */
    protected function isDebugMode()
    {
        return in_array($this->target->getMode(), $this->getDebugModes());
    }

    /**
     * Returns the modes considered as debug
     *
     * @return array
     */
    protected function getDebugModes()
    {
        return array(
            'dev',
        );
    }
}
