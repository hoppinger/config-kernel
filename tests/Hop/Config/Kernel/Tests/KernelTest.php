<?php

/**
 * This file is part of hoppinger/config-kernel
 *
 * (c) Hoppinger BV <info@hoppinger.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hop\Config\Kernel\Tests;

use Hop\Config\Kernel\Tests\Fixtures\TestKernel;

use Hop\Config\Target\Target;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterContainerConfiguration()
    {
        $target = new Target(__DIR__, 'dev/foo');
        $kernel = new TestKernel($target);
        $loader = $this->getMock('Symfony\Component\Config\Loader\Loader');
        $loader->expects($this->exactly(2))
            ->method('load');

        $root = __DIR__.DIRECTORY_SEPARATOR.'Fixtures';

        $loader->expects($this->at(0))->method('load')->with(__DIR__.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config_dev.yml');
        $loader->expects($this->at(1))->method('load')->with($target->getTargetDir().DIRECTORY_SEPARATOR.'config.yml');

        $kernel->registerContainerConfiguration($loader);
    }

    public function testGetKernelParameters()
    {
        $target = new Target(__DIR__, 'dev/foo');
        $kernel = new TestKernel($target);

        $parameters = $kernel->getKernelParameters();

        $this->assertArrayHasKey('kernel.cnf.target', $parameters);
        $this->assertEquals('dev/foo', $parameters['kernel.cnf.target']);
        $this->assertArrayHasKey('kernel.cnf.root_dir', $parameters);
        $this->assertEquals($target->getRootDir(), $parameters['kernel.cnf.root_dir']);
        $this->assertArrayHasKey('kernel.cnf.target_dir', $parameters);
        $this->assertEquals($target->getTargetDir(), $parameters['kernel.cnf.target_dir']);
    }

    public function testDebugModes()
    {
        $kernel = new TestKernel(new Target(__DIR__, 'dev/foo'));
        $this->assertEquals(array('dev'), $kernel->getDebugModes());
    }

    public function testDebugIfDebugMode()
    {
        $kernel = new TestKernel(new Target(__DIR__, 'dev/foo'));
        $this->assertTrue($kernel->isDebug());
    }

    public function testNotDebugIfDebugMode()
    {
        $kernel = new TestKernel(new Target(__DIR__, 'dev/foo'), false);
        $this->assertFalse($kernel->isDebug());
    }

    public function testNotDebugIfNotDebugMode()
    {
        $kernel = new TestKernel(new Target(__DIR__, 'prod/foo'));
        $this->assertFalse($kernel->isDebug());
    }

    public function testDebugIfNotDebugMode()
    {
        $kernel = new TestKernel(new Target(__DIR__, 'prod/foo'), true);
        $this->assertTrue($kernel->isDebug());
    }
}
