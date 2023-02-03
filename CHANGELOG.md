## 2.2.1 (2023-01-29)
* Allows setting the `Description` and `AdServingId` of an `Inline` ad.

## 2.2.0 (2023-01-29)
* Add support for InteractiveCreativeFile as per 4.1 VAST specification

## 2.1.0 (2021-01-23)
* PHP 8 Support

## 2.0 (2019-09-26)
* Support PHP 7.1.3 and above
* Removed deprecated Document::toString(), use casting object to string
* Removed deprecated document builders Document::create(), Document::fromFile(), Document::fromString(), use Factory instead

## 1.0 (2019-09-26)
* Support Closed Caption Files
* Version 1.0 supports PHP 5.3 - 7.3

## 0.6 (2019-09-06)
  * Added support of `id` and `adId` attributes of `creative` element.
  * Added ability to create own elements and attributes through custom `ElementBuilder`, see [Custom Specification Support](https://github.com/sokil/php-vast#custom-specification-support) section of manual.

## 0.5.3 (2019-05-06)
  * UniversalAdId added due to VAST 4.0 specification. UniversalAdId required in response beginning with VAST 4.0 (paragraph 3.7.1)

## 0.5.2 (2019-03-23)
  * Add offset to progress event tracking. See specification 2.3.2.3 "Progress Event".

## 0.5.1 (2018-10-31)
  * Allow specify `adParameter` and `apiFramework`. 

## 0.4.8 (2018-06-29)
  * Fixed 'Document::getAdSections()'. Previously root DOM element was set to first child which may be text node. Now it points to `InLine` or `Wrapper` element.
  * Now may be specified id of `Impression` in `AbstractAdNode::addImpression`

## 0.4.7 (2018-06-29)
  * Fixed `AbstractNode::getValuesOfArrayNode`. Affected  `AbstractAdNode::getErrors()` and `AbstractAdNode::getImpressions()` if multiple nodes in array found. Array always contain first node instead of values of all nodes.

## 0.4.6 (2018-04-05)
  * Fix adding Extension to Ad\InLine section
  * Now Extensions can be created for Ad\Wrapper also

## 0.4.5 (2018-02-22)
  * Method `AbstractAdNode::getSequence` now return int instead of numeric string 

## 0.4.4 (2018-01-25)
  * Allow Ad sequence

## 0.4.2 (2017-11-02)
  * Returned method `AbstractAdNode::setImpression` and marked deprecated

## 0.4 (2017-07-26)
  * Move to PSR-4
  * Added `Factory` to create document. Factory methods in `Document` are deprecated
  * Added `Error` tag to `VAST`, `InLine` and `Wrapper`
  * Allowed to add multiple `Impression` to `InLine` and `Wrapper`
  * Removed method `AbstractAdNode::setImpression` 
  * Classes moved. Check your extends

## 0.3 (2016-03-24)
  * Add support of Wrapper's VASTAdTagURI element
  * Private methods and properties now without underscores
