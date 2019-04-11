<?php

namespace GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader;

use Doctrine\Common\Annotations\Reader;
use GollumSF\SerializerDescribeAnnotationBundle\Annotation\SerializerDescribe;
use Symfony\Component\Serializer\Exception\MappingException;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use Symfony\Component\Serializer\Mapping\ClassMetadataInterface;
use Symfony\Component\Serializer\Mapping\Loader\LoaderInterface;

class AnnotationClassLoader implements LoaderInterface
{
	private $reader;
	
	public function __construct(Reader $reader)
	{
		$this->reader = $reader;
	}
	
	public function loadClassMetadata(ClassMetadataInterface $classMetadata) {
		
		$reflectionClass = $classMetadata->getReflectionClass();
		$attributesMetadata = $classMetadata->getAttributesMetadata();
		
		foreach ($reflectionClass->getProperties() as $property) {
			if (!isset($attributesMetadata[$property->name])) {
				$attributesMetadata[$property->name] = new AttributeMetadata($property->name);
				$classMetadata->addAttributeMetadata($attributesMetadata[$property->name]);
			}
		}
		foreach ($reflectionClass->getMethods() as $method) {
			if ($method->getDeclaringClass()->name !== $classMetadata->getName()) {
				continue;
			}
			
			$accessorOrMutator = preg_match('/^(get|is|has|set)(.+)$/i', $method->name, $matches);
			if ($accessorOrMutator) {
				$attributeName = lcfirst($matches[2]);
				
				if (!isset($attributesMetadata[$attributeName])) {
					$attributesMetadata[$attributeName] = $attributeMetadata = new AttributeMetadata($attributeName);
					$classMetadata->addAttributeMetadata($attributeMetadata);
				}
			}
		}
		
		foreach ($this->reader->getClassAnnotations($reflectionClass) as $annotation) {
			if ($annotation instanceof SerializerDescribe) {
				
				foreach ($annotation->getProperties() as $propertyName => $property) {
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
		}
		
		return true;
	}
}

