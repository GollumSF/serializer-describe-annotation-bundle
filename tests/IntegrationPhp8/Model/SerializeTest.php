<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\IntegrationPhp8\Model;

use Test\GollumSF\SerializerDescribeAnnotationBundle\Integration\Model\SerializeTest as SerializeTestBase;
use Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTestPhp8\Model\EntityChild;
use Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTestPhp8\Model\EntityError;

/**
 * @requires PHP 8.0.0
 */
class SerializeTest extends SerializeTestBase
{

	protected function getProjectPath(): string
	{
		return __DIR__ . '/../../ProjectTestPhp8';
	}

	protected function createObjChild() {
		return new EntityChild();
	}

	protected function createObjError() {
		return new EntityError();
	}

}
