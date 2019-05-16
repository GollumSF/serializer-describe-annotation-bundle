# GollumSFSerializerDescribeAnnotationBundle

[![Build Status](https://travis-ci.com/GollumSF/serializer-describe-annotation-bundle.svg?branch=master)](https://travis-ci.com/GollumSF/serializer-describe-annotation-bundle)
[![License](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/license?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Latest Stable Version](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/v/stable?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Latest Unstable Version](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/v/unstable?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)

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
use GollumSF\SerializerDescribeAnnotationBundle\Annotation\SerializerDescribe;

class EntityParent {   
    private $proprtyA;
}

/**
 * @SerializerDescribe({
 * 	"proprtyA" = {
 *		"groups" = {
 * 			"group_1", "group_2"
 * 		}
 *	},
 * 	"proprtyB" = {
 *		"serializedName" = "new_name",
 *		"maxDepth" = 2
 *	}
 * })
 */
class EntityChild extends EntityParent {
    private $proprtyB;
}
```
