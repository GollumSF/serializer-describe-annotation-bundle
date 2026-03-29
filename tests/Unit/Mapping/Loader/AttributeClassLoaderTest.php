<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\Unit\Mapping\Loader;

use GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader\AttributeClassLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\MappingException;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use Symfony\Component\Serializer\Mapping\ClassMetadataInterface;

/**
 * @requires PHP 8.0.0
 */
class AttributeClassLoaderTest extends TestCase
{

	public function testLoadClassMetadata() {

		$classMetadata = $this->getMockForAbstractClass(ClassMetadataInterface::class);
		$attributeClassLoader = new AttributeClassLoader();
		$rClass = new \ReflectionClass(AttributeModel::class);

		$classMetadata
			->expects($this->once())
			->method('getReflectionClass')
			->willReturn($rClass)
		;
		$classMetadata
			->expects($this->once())
			->method('getAttributesMetadata')
			->willReturn([])
		;

		/** @var AttributeMetadata[] $metadatas */
		$metadatas = [];
		$classMetadata
			->expects($this->exactly(3))
			->method('addAttributeMetadata')
			->willReturnCallback(function (AttributeMetadata $metadata) use (&$metadatas) {
				if (count($metadatas) === 0) {
					$this->assertEquals('property1', $metadata->getName());
				}
				if (count($metadatas) === 1) {
					$this->assertEquals('property2', $metadata->getName());
				}
				if (count($metadatas) === 2) {
					$this->assertEquals('property3', $metadata->getName());
				}
				$metadatas[] = $metadata;
			})
		;


		$this->assertTrue(
			$attributeClassLoader->loadClassMetadata($classMetadata)
		);

		$this->assertEquals([], $metadatas[0]->getGroups());
		$this->assertEquals(null, $metadatas[0]->getSerializedName());
		$this->assertEquals(null, $metadatas[0]->getMaxDepth());

		$this->assertEquals([ 'GROUP2' ], $metadatas[1]->getGroups());
		$this->assertEquals(null, $metadatas[1]->getSerializedName());
		$this->assertEquals(null, $metadatas[1]->getMaxDepth());

		$this->assertEquals([ 'GROUP3' ], $metadatas[2]->getGroups());
		$this->assertEquals('SERIALIZED_NAME', $metadatas[2]->getSerializedName());
		$this->assertEquals(5, $metadatas[2]->getMaxDepth());
	}

	public function testLoadClassMetadataException() {

		$classMetadata = $this->getMockForAbstractClass(ClassMetadataInterface::class);
		$attributeClassLoader = new AttributeClassLoader();
		$rClass = new \ReflectionClass(AttributeModelError::class);

		$classMetadata
			->expects($this->once())
			->method('getReflectionClass')
			->willReturn($rClass)
		;
		$classMetadata
			->expects($this->once())
			->method('getAttributesMetadata')
			->willReturn([])
		;

		/** @var AttributeMetadata[] $metadatas */
		$metadatas = [];
		$classMetadata
			->expects($this->exactly(2))
			->method('addAttributeMetadata')
			->willReturnCallback(function (AttributeMetadata $metadata) use (&$metadatas) {
				if (count($metadatas) === 0) {
					$this->assertEquals('property1', $metadata->getName());
				}
				if (count($metadatas) === 1) {
					$this->assertEquals('property2', $metadata->getName());
				}
				$metadatas[] = $metadata;
			})
		;


		$this->expectException(MappingException::class);

		$attributeClassLoader->loadClassMetadata($classMetadata);
	}
}
