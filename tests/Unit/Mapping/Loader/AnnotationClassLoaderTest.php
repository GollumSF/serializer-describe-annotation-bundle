<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\Unit\Mapping\Loader;

use Doctrine\Common\Annotations\Reader;
use GollumSF\SerializerDescribeAnnotationBundle\Annotation\SerializerDescribe;
use GollumSF\SerializerDescribeAnnotationBundle\Mapping\Loader\AnnotationClassLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\MappingException;
use Symfony\Component\Serializer\Mapping\AttributeMetadata;
use Symfony\Component\Serializer\Mapping\ClassMetadataInterface;

class AnnotationModel {
	public $property1 = 'property1';
	public $property2 = 'property2';

	public function getProperty3() {
		return 'property3';
	}
}

class AnnotationClassLoaderTest extends TestCase
{

	public function testLoadClassMetadata() {

		$reader = $this->getMockBuilder(Reader::class)->disableOriginalConstructor()->getMock();
		$annotationClassLoader = new AnnotationClassLoader($reader);
		$classMetadata = $this->getMockForAbstractClass(ClassMetadataInterface::class);
		$rClass = new \ReflectionClass(AnnotationModel::class);
		$annotation = new SerializerDescribe([
			'value' => [
				'property2' => [
					'groups' => [ 'GROUP2' ],
				],
				'getProperty3' => [
					'groups' => [ 'GROUP3' ],
					'serializedName' => 'SERIALIZED_NAME',
					'maxDepth' => 5
				]
			]
		]);

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
					$this->assertEquals('property1', $metadata->name);
				}
				if (count($metadatas) === 1) {
					$this->assertEquals('property2', $metadata->name);
				}
				if (count($metadatas) === 2) {
					$this->assertEquals('property3', $metadata->name);
				}
				$metadatas[] = $metadata;
			})
		;

		$reader
			->expects($this->once())
			->method('getClassAnnotations')
			->willReturn([
				$annotation
			])
		;

		$this->assertTrue(
			$annotationClassLoader->loadClassMetadata($classMetadata)
		);

		$this->assertEquals([], $metadatas[0]->groups);
		$this->assertEquals(null, $metadatas[0]->serializedName);
		$this->assertEquals(null, $metadatas[0]->maxDepth);

		$this->assertEquals([ 'GROUP2' ], $metadatas[1]->groups);
		$this->assertEquals(null, $metadatas[1]->serializedName);
		$this->assertEquals(null, $metadatas[1]->maxDepth);

		$this->assertEquals([ 'GROUP3' ], $metadatas[2]->groups);
		$this->assertEquals('SERIALIZED_NAME', $metadatas[2]->serializedName);
		$this->assertEquals(5, $metadatas[2]->maxDepth);
	}

	public function testLoadClassMetadataException() {

		$reader = $this->getMockBuilder(Reader::class)->disableOriginalConstructor()->getMock();
		$annotationClassLoader = new AnnotationClassLoader($reader);
		$classMetadata = $this->getMockForAbstractClass(ClassMetadataInterface::class);
		$rClass = new \ReflectionClass(AnnotationModel::class);
		$annotation = new SerializerDescribe([
			'value' => [
				'error' => [
					'groups' => [ 'ERROR' ],
				],
			]
		]);

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
					$this->assertEquals('property1', $metadata->name);
				}
				if (count($metadatas) === 1) {
					$this->assertEquals('property2', $metadata->name);
				}
				$metadatas[] = $metadata;
			})
		;

		$reader
			->expects($this->once())
			->method('getClassAnnotations')
			->willReturn([
				$annotation
			])
		;

		$this->expectException(MappingException::class);

		$annotationClassLoader->loadClassMetadata($classMetadata);
	}
}
