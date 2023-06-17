<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\Unit;

use GollumSF\ReflectionPropertyTest\ReflectionPropertyTrait;
use GollumSF\SerializerDescribeAnnotationBundle\GollumSFSerializerDescribeAnnotationBundle;
use GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader\AnnotationClassLoader;
use GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader\AttributeClassLoader;
use Nyholm\BundleTest\BaseBundleTestCase;
use Nyholm\BundleTest\CompilerPass\PublicServicePass;
use Symfony\Component\Serializer\Mapping\Loader\LoaderChain;

class GollumSFSerializerDescribeAnnotationBundleTest extends BaseBundleTestCase {

    use ReflectionPropertyTrait;

    protected function getBundleClass() {
        return GollumSFSerializerDescribeAnnotationBundle::class;
    }

    protected function setUp(): void {
        parent::setUp();

        // Make all services public
        $this->addCompilerPass(new PublicServicePass('|GollumSF*|'));
        $this->addCompilerPass(new PublicServicePass('|serializer.mapping.chain_loader|'));
    }

    public function testInitBundle()
    {
        // Create a new Kernel
        $kernel = $this->createKernel();

        // Add some configuration
        $kernel->addConfigFile(__DIR__.'/Resources/config.yaml');

        // Boot the kernel.
        $this->bootKernel();

        // Get the container
        $container = $this->getContainer();

        /** @var LoaderChain $chainLoader */
        $loaderChain = $container->get('serializer.mapping.chain_loader');
        $loaders = $loaderChain->getLoaders();

        $this->assertInstanceOf(AnnotationClassLoader::class, $container->get(AnnotationClassLoader::class));
        $this->assertContainsEquals($container->get(AnnotationClassLoader::class), $loaders);
        if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
            $this->assertInstanceOf(AttributeClassLoader::class, $container->get(AttributeClassLoader::class));
            $this->assertContainsEquals($container->get(AttributeClassLoader::class), $loaders);
        }
    }
}
