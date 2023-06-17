<?php

namespace GollumSF\SerializerDescribeAnnotationBundle\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class SerializerDescribe {
	
	/** @var array */
	private $properties = [];
	
	public function __construct (array $param) {
		$this->properties = isset($param['value']) ? $param['value'] : [];
	}
	
	public function getProperties(): array {
		return $this->properties;
	}
	
}
