<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTest\Model;

use GollumSF\SerializerDescribeAnnotationBundle\Annotation\SerializerDescribe;

/**
 * @SerializerDescribe({
 * 	"errorProps" = {
 *		"groups" = {
 * 			"group_1"
 * 		}
 *	}
 * })
 */
class EntityError extends EntityParent {
}
