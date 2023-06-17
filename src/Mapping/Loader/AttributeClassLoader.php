<?php

namespace GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader;

use GollumSF\SerializerDescribeAnnotationBundle\Attribute\SerializerDescribe;
use Symfony\Component\Serializer\Exception\MappingException;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use Symfony\Component\Serializer\Mapping\ClassMetadataInterface;
use Symfony\Component\Serializer\Mapping\Loader\LoaderInterface;

/**
 * @codeCoverageIgnore PHP 8.0.0
 */
class AttributeClassLoader implements LoaderInterface {
	
	public function __construct() {
	}
	
	public function loadClassMetadata(ClassMetadataInterface $classMetadata): bool {
		
		$reflectionClass = $classMetadata->getReflectionClass();
		$attributesMetadata = $classMetadata->getAttributesMetadata();
		
		foreach ($reflectionClass->getProperties() as $property) {
			if (!isset($attributesMetadata[$property->name])) {
				$attributesMetadata[$property->name] = new AttributeMetadata($property->name);
				$classMetadata->addAttributeMetadata($attributesMetadata[$property->name]);
			}
		}
		
		foreach ($reflectionClass->getAttributes(SerializerDescribe::class) as $rAttribute) {
			/** @var SerializerDescribe $attribute */
			$attribute = $rAttribute->newInstance();
			foreach ($attribute->getProperties() as $propertyName => $property) {

				if ($reflectionClass->hasMethod($propertyName)) {
					$accessorOrMutator = preg_match('/^(get|is|has|set)(.+)$/i', $propertyName, $matches);
					if ($accessorOrMutator) {
						$propertyName = lcfirst($matches[2]);
					}

					if (!isset($attributesMetadata[$propertyName])) {
						$attributesMetadata[$propertyName] = $attributeMetadata = new AttributeMetadata($propertyName);
						$classMetadata->addAttributeMetadata($attributeMetadata);
					}
				}
				
				if (!isset($attributesMetadata[$propertyName])) {
					throw new MappingException(sprintf('Property%s not found on class %s, (must be %s)', $propertyName, $reflectionClass->getName(), join(', ', array_keys($attributesMetadata))));
				}
				$metadata = $attributesMetadata[$propertyName];
				
				if (isset($property['groups'])) {
					foreach ($property['groups'] as $group) {
						$metadata->addGroup($group);
					}
				}
				if (isset($property['serializedName'])) {
					$metadata->setSerializedName($property['serializedName']);
				}
				if (isset($property['maxDepth'])) {
					$metadata->setMaxDepth($property['maxDepth']);
				}
			}
		}
		
		return true;
	}
}

