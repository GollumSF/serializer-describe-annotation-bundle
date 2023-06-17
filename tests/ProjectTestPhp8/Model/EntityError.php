<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTestPhp8\Model;

use GollumSF\SerializerDescribeAnnotationBundle\Attribute\SerializerDescribe;

#[SerializerDescribe([
 	'errorProps' => [
		'groups' => [
 			'group_1'
		]
	]
 ])]
class EntityError extends EntityParent {
}
