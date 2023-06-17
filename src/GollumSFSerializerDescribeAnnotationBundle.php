<?php

namespace GollumSF\SerializerDescribeAnnotationBundle;

use GollumSF\SerializerDescribeAnnotationBundle\DependencyInjection\SerializerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * GollumSFSerializerDescribeAnnotationBundle
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class GollumSFSerializerDescribeAnnotationBundle extends Bundle {
	
	public function build(ContainerBuilder $container) {
		$container->addCompilerPass(new SerializerPass());
	}
}
