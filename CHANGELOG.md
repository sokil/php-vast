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
