<?php

namespace Test\GollumSF\SerializerDescribeAnnotationBundle\Integration\Model;

use Doctrine\Common\Annotations\AnnotationReader;
use GollumSF\SerializerDescribeAnnotationBundle\GollumSFSerializerDescribeAnnotationBundle;
use Nyholm\BundleTest\BaseBundleTestCase;
use Nyholm\BundleTest\CompilerPass\PublicServicePass;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Exception\MappingException;
use Symfony\Component\Serializer\SerializerInterface;
use Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTest\Model\EntityChild;
use Test\GollumSF\SerializerDescribeAnnotationBundle\ProjectTest\Model\EntityError;

class SerializeTest extends BaseBundleTestCase
{
	protected function getProjectPath(): string
	{
		return __DIR__ . '/../../ProjectTest';
	}

	/** @var KernelInterface */
	private $kernel;

	protected function getBundleClass()
	{
		return GollumSFSerializerDescribeAnnotationBundle::class;
	}


	protected function setUp(): void
	{
		parent::setUp();
		$_ENV['SHELL_VERBOSITY'] = 1;
		// Make all services public
		$this->addCompilerPass(new PublicServicePass('|GollumSF*|'));

		AnnotationReader::addGlobalIgnoredName('after');
		AnnotationReader::addGlobalIgnoredName('test');
		AnnotationReader::addGlobalIgnoredName('dataProvider');
		AnnotationReader::addGlobalIgnoredName('covers');
	}

	protected function getKernel(): KernelInterface
	{
		if (!$this->kernel) {
			// Create a new Kernel
			$this->kernel = $this->createKernel();

			$this->kernel->addCompilerPasses([new PublicServicePass('|GollumSF*|')]);
			$this->kernel->addCompilerPasses([new PublicServicePass('|serializer|')]);

			$this->kernel->addConfigFile($this->getProjectPath() . '/Resources/config/config.yaml');

			// Boot the kernel.
			$this->kernel->boot();
		}
		return $this->kernel;
	}

	protected function getContainer(): ContainerInterface
	{
		return $this->getKernel()->getContainer();
	}

	protected function createObjChild() {
		return new EntityChild();
	}

	protected function createObjError() {
		return new EntityError();
	}

	public function provideSerialize()
	{
		return [
			[['group_1'], [
				'propertyChildAOverride' => 'propertyChildA',
				'propertyParentA' => 'propertyParentA',
				'propertyChildBB' => "propertyChildB",
			]],
			[['group_2'], [
				'propertyParentA' => 'propertyParentA',
			]],
			[['group_3'], [
				'propertyChildAOverride' => 'propertyChildA',
			]],
			[['group_4'], [
				'propertyChildBB' => "propertyChildB",
			]]
		];
	}

	/**
	 * @dataProvider provideSerialize
	 */
	public function testSerialize($groups, $result)
	{
		$obj = $this->createObjChild();

		/** @var SerializerInterface $serializer */
		$serializer = $this->getContainer()->get('serializer');

		$this->assertEquals($result, $serializer->normalize($obj, 'json', ['groups' => $groups]));
	}

	public function testSerializeDepth()
	{
		$obj1 = $this->createObjChild();
		$obj2 = $this->createObjChild();
		$obj3 = $this->createObjChild();
		$obj4 = $this->createObjChild();
		$obj5 = $this->createObjChild();
		$obj6 = $this->createObjChild();
		$obj1->propertyChildA = $obj2;
		$obj2->propertyChildA = $obj3;
		$obj3->propertyChildA = $obj4;
		$obj4->propertyChildA = $obj5;
		$obj5->propertyChildA = $obj6;

		/** @var SerializerInterface $serializer */
		$serializer = $this->getContainer()->get('serializer');

		$this->assertEquals([
			"propertyChildAOverride" => [
				"propertyChildAOverride" => [
					"propertyChildAOverride" => []
				]
			]
		], $serializer->normalize($obj1, 'json', ['groups' => 'group_3', 'enable_max_depth' => true]));
	}

	public function testSerializeMappingError()
	{
		$obj = $this->createObjError();

		/** @var SerializerInterface $serializer */
		$serializer = $this->getContainer()->get('serializer');

		$this->expectException(MappingException::class);

		$serializer->normalize($obj, 'json', ['groups' => 'group_1']);
	}
}
