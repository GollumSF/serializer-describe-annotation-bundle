<?php

namespace GollumSF\SerializerDescribeAnnotationBundle\DependencyInjection;

use GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader\AnnotationClassLoader;
use GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader\AttributeClassLoader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class SerializerPass implements CompilerPassInterface {
	
	public function process(ContainerBuilder $container) {

		$container->setDefinition(
			AnnotationClassLoader::class,
			new Definition(AnnotationClassLoader::class, [
				new Reference('annotation_reader')
			])
		);
		
		if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
			$container->setDefinition(
				AttributeClassLoader::class,
				new Definition(AttributeClassLoader::class, [])
			);
		}
		
		$chainLoader = $container->getDefinition('serializer.mapping.chain_loader');
		/** @var array $loaders */
		$loaders = $chainLoader->getArgument(0);
		$loaders[] = $container->getDefinition(AnnotationClassLoader::class);
		
		if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
			$loaders[] = $container->getDefinition(AttributeClassLoader::class);
		}
		
		$chainLoader->setArgument(0, $loaders);
	}
}
