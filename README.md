# GollumSFSerializerDescribeAnnotationBundle
[![Build Status](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions/workflows/symfony_4.4.yml/badge.svg?branch=master)](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions)
[![Build Status](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions/workflows/symfony_5.4.yml/badge.svg?branch=master)](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions)
[![Build Status](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions/workflows/symfony_6.0.yml/badge.svg?branch=master)](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions)
[![Build Status](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions/workflows/symfony_6.3.yml/badge.svg?branch=master)](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions)

[![Coverage](https://coveralls.io/repos/github/GollumSF/serializer-describe-annotation-bundle/badge.svg?branch=master)](https://coveralls.io/github/GollumSF/serializer-describe-annotation-bundle)
[![License](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/license?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Latest Stable Version](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/v/stable?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Latest Unstable Version](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/v/unstable?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Discord](https://img.shields.io/discord/671741944149573687?color=purple&label=discord)](https://discord.gg/xMBc5SQ)

Add class annotation for describe serializer property

## Installation:

```shell
composer require gollumsf/serializer-describe-annotation-bundle
```

### config/bundles.php
```php
return [
    // [ ... ]
    GollumSF\SerializerDescribeAnnotationBundle\GollumSFSerializerDescribeAnnotationBundle::class => ['all' => true],
];
```

## Usage

```php
use GollumSF\SerializerDescribeAnnotationBundle\Attribute\SerializerDescribe;

class EntityParent {   
	private $proprtyA;
}

#[SerializerDescribe([
	'propertyA' => [
		'groups' => [
 			'group_1', 'group_2'
 		]
	],
	'propertyB' => [
 		'serializedName' => 'new_name',
 		'maxDepth' => 2
 	]
])]
class EntityChild extends EntityParent {
    private $propretyB;
}
```

```php
use GollumSF\SerializerDescribeAnnotationBundle\Annotation\SerializerDescribe;

class EntityParent {   
	private $propertyA;
}

/**
 * @SerializerDescribe({
 * 	"propertyA" = {
 *		"groups" = {
 * 			"group_1", "group_2"
 * 		}
 *	},
 * 	"propertyB" = {
 *		"serializedName" = "new_name",
 *		"maxDepth" = 2
 *	}
 * })
 */
class EntityChild extends EntityParent {
	private $propertyB;
}
```
