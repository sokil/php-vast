PHP VAST
--------

VAST Ad generator and parser library on PHP.

```php
// create document
$document = \Sokil\Vast\Document::create('2.0');

// insert Ad section
$ad1 = $document->createInLineAdSection()
    ->setId('ad1')
    ->setAdSystem('Ad Server Name')
    ->setAdTitle('Ad Title')
    ->setImpression('http://ad.server.com/impression');

// create creative for ad section
$ad1->createLinearCreative()
    ->setDuration(128)
    ->setVideoClipsClickThrough('http://ad.server.com/videoclips/clickthrough')
    ->addVideoClipsClickTracking('http://ad.server.com/videoclips/clicktracking')
    ->addVideoClipsCustomClick('http://ad.server.com/videoclips/customclick')
    ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
    ->addTrackingEvent('stop', 'http://ad.server.com/trackingevent/stop')
    ->createMediaFile()
        ->setProgressiveDelivery()
        ->setType('video/mp4')
        ->setHeight(100)
        ->setWidth(100)
        ->setUrl('http://server.com/media.mp4');

echo $document->toDomDocument();
```
