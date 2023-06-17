<?php

namespace GollumSF\SerializerDescribeAnnotationBundle\Attribute;

/**
 * @codeCoverageIgnore PHP 8.0.0
 */
#[\Attribute(\Attribute::TARGET_CLASS|\Attribute::IS_REPEATABLE)]
class SerializerDescribe {
	
	/** @var array */
	private $properties = [];
	
	public function __construct (array $properties) {
		$this->properties = $properties;
	}
	
	public function getProperties(): array {
		return $this->properties;
	}
	
}
