<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTest\Model;

use GollumSF\SerializerDescribeAnnotationBundle\Annotation\SerializerDescribe;

/**
 * @SerializerDescribe({
 * 	"propertyParentA" = {
 *		"groups" = {
 * 			"group_1", "group_2"
 * 		}
 *	},
 * 	"propertyChildA" = {
 *		"serializedName" = "propertyChildAOverride",
 *		"maxDepth" = 3,
 *		"groups" = {
 * 			"group_1", "group_3", "depth"
 * 		}
 *	},
 * 	"getPropertyChildBB" = {
 *		"groups" = {
 * 			"group_1", "group_4"
 * 		}
 *	}
 * })
 */
class EntityChild extends EntityParent {
    public $propertyChildA = 'propertyChildA';
    public $propertyChildB = 'propertyChildB';

    public function getPropertyChildA() {
        return $this->propertyChildA;
    }

    public function getPropertyChildB() {
        return $this->propertyChildB;
    }

    public function getPropertyChildBB() {
        return $this->propertyChildB;
    }

}
