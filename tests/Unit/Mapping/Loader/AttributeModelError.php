<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\Unit\Mapping\Loader;

use GollumSF\SerializerDescribeAnnotationBundle\Attribute\SerializerDescribe;

#[SerializerDescribe([
	'error' => [
		'groups' => [ 'ERROR' ],
	],
])]
class AttributeModelError {
	public $property1 = 'property1';
	public $property2 = 'property2';

	public function getProperty3() {
		return 'property3';
	}
}
