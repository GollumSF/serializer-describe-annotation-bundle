<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\Unit\Mapping\Loader;

use GollumSF\SerializerDescribeAnnotationBundle\Attribute\SerializerDescribe;

#[SerializerDescribe([
	'property2' => [
		'groups' => [ 'GROUP2' ],
	],
	'getProperty3' => [
		'groups' => [ 'GROUP3' ],
		'serializedName' => 'SERIALIZED_NAME',
		'maxDepth' => 5
	]
])]
class AttributeModel {
	public $property1 = 'property1';
	public $property2 = 'property2';

	public function getProperty3() {
		return 'property3';
	}
}
