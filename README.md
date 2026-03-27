# GollumSFSerializerDescribeAnnotationBundle

> **DEPRECATED** - This bundle is deprecated. Use [gollumsf/serializer-describe-attribute-bundle](https://github.com/GollumSF/serializer-describe-attribute-bundle) instead, which supports PHP 8.2+ and Symfony 6.4 / 7.x / 8.0.

[![Build Status](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions/workflows/symfony_4.4.yml/badge.svg?branch=master)](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions)
[![Build Status](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions/workflows/symfony_5.4.yml/badge.svg?branch=master)](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions)
[![Build Status](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions/workflows/symfony_6.4.yml/badge.svg?branch=master)](https://github.com/GollumSF/serializer-describe-annotation-bundle/actions)

[![Coverage](https://coveralls.io/repos/github/GollumSF/serializer-describe-annotation-bundle/badge.svg?branch=master)](https://coveralls.io/github/GollumSF/serializer-describe-annotation-bundle)
[![License](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/license?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Latest Stable Version](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/v/stable?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Latest Unstable Version](https://poser.pugx.org/gollumsf/serializer-describe-annotation-bundle/v/unstable?)](https://packagist.org/packages/gollumsf/serializer-describe-annotation-bundle)
[![Discord](https://img.shields.io/discord/671741944149573687?color=purple&label=discord)](https://discord.gg/xMBc5SQ)

Add class annotation for describe serializer property

## Migration

Replace in your `composer.json`:
```diff
- "gollumsf/serializer-describe-annotation-bundle": "^x.x"
+ "gollumsf/serializer-describe-attribute-bundle": "^1.0"
```

Replace in your code:
```diff
- use GollumSF\SerializerDescribeAnnotationBundle\Attribute\SerializerDescribe;
+ use GollumSF\SerializerDescribeAttributeBundle\Attribute\SerializerDescribe;
```

Replace in `config/bundles.php`:
```diff
- GollumSF\SerializerDescribeAnnotationBundle\GollumSFSerializerDescribeAnnotationBundle::class => ['all' => true],
+ GollumSF\SerializerDescribeAttributeBundle\GollumSFSerializerDescribeAttributeBundle::class => ['all' => true],
```
