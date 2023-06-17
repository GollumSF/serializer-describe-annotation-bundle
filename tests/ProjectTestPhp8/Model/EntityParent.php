<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTestPhp8\Model;

class EntityParent {
    public $propertyParentA = 'propertyParentA';
    public $propertyParentB = 'propertyParentB';

    public function getPropertyParentA() {
        return $this->propertyParentA;
    }

    public function getPropertyParentB() {
        return $this->propertyParentB;
    }
}
