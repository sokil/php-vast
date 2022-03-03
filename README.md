# Stand With Ukraine

![](https://github.com/sokil/php-isocodes/raw/4.0/.github/russia-invaded-ukraine.png)

## Free world

As you already know, russia invaded Ukraine on 24 of February 2022, at 5.00 AM the armed forces of the Russian Federation attacked Ukraine. Please, Stand with Ukraine, stay tuned for updates on Ukraine’s official sources and channels in English and support Ukraine in its fight for freedom and democracy in Europe. 

https://ukraine.ua/news/stand-with-ukraine/

Ways to support Ukraine

* Help to defend Ukraine — donate to Ukraine’s main charity fund — https://savelife.in.ua/en/donate/
* Help to defend Ukraine — donate to the fund of the National Bank of Ukraine:
  * SWITFT: https://ukraine.ua/news/donate-to-the-nbu-fund/
  * Credit card: https://bank.gov.ua/en/news/all/natsionalniy-bank-vidkriv-spetsrahunok-dlya-zboru-koshtiv-na-potrebi-armiyi

[#StandWithUkraine](https://twitter.com/hashtag/standwithukraine)

## Россияне

Cпасите жизни своих сограждан, помогите остановить войну.

Форма для поиска пропавших: https://bit.ly/3hrAjGA.
Больше инфо здесь: https://200rf.com

Тelegram-каналы:
* https://t.me/rf200_now
* https://t.me/voyna_2022
* https://t.me/UkraineNow
* https://t.me/UkrainianWitness
* http://t.me/umer_RF

Проверяйте факты, помогите нам распространить правду, вы не услышыте ее в новостях. Помогите остановить войну. Делайте хоть чтото, не молчите.

----

PHP-VAST
========

[![Build](https://github.com/sokil/php-vast/workflows/Test/badge.svg?branch=2.0)](https://github.com/sokil/php-vast/actions?query=workflow%3ATest)
[![Total Downloads](http://img.shields.io/packagist/dt/sokil/php-vast.svg?1)](https://packagist.org/packages/sokil/php-vast)
[![Coverage Status](https://coveralls.io/repos/github/sokil/php-vast/badge.svg?branch=master&1)](https://coveralls.io/github/sokil/php-vast?branch=master)

:star: VAST Ad generator and parser library on PHP.

## Specs
* VAST 2.0 Spec: http://www.iab.net/media/file/VAST-2_0-FINAL.pdf
* VAST 3.0 Spec: http://www.iab.com/wp-content/uploads/2015/06/VASTv3_0.pdf
* VAST 4.0 Spec: 
  * http://www.iab.com/wp-content/uploads/2016/01/VAST_4-0_2016-01-21.pdf
  * https://www.iab.com/wp-content/uploads/2016/04/VAST4.0_Updated_April_2016.pdf
* VAST 4.1 Spec:
  * https://iabtechlab.com/wp-content/uploads/2018/11/VAST4.1-final-Nov-8-2018.pdf
* [VAST Samples](https://github.com/InteractiveAdvertisingBureau/VAST_Samples)

## Install

Install library through composer:

```
composer require sokil/php-vast
```

## Quick start

```php
// create document
$factory = new \Sokil\Vast\Factory();
$document = $factory->create('4.1');

// insert Ad section
$ad1 = $document
    ->createInLineAdSection()
    ->setId('ad1')
    ->setAdSystem('Ad Server Name')
    ->setAdTitle('Ad Title')
    ->addImpression('http://ad.server.com/impression', 'imp1');

// create creative for ad section
$linearCreative = $ad1
    ->createLinearCreative()
    ->setDuration(128)
    ->setId('013d876d-14fc-49a2-aefd-744fce68365b')
    ->setAdId('pre')
    ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
    ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
    ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
    ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
    ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop');

// add closed caption file (Closed Caption support starts on VAST 4.1)
$linearCreative
    ->createClosedCaptionFile()
    ->setLanguage('en-US')
    ->setType('text/srt')
    ->setUrl('http://server.com/cc.srt');
    
// add 100x100 media file
$linearCreative
    ->createMediaFile()
    ->setProgressiveDelivery()
    ->setType('video/mp4')
    ->setHeight(100)
    ->setWidth(100)
    ->setBitrate(2500)
    ->setUrl('http://server.com/media1.mp4');

// add 200x200 media file
$linearCreative
    ->createMediaFile()
    ->setProgressiveDelivery()
    ->setType('video/mp4')
    ->setHeight(200)
    ->setWidth(200)
    ->setBitrate(2500)
    ->setUrl('http://server.com/media2.mp4');
    
// get dom document
$domDocument = $document->toDomDocument();

// get XML string
echo $document;
```

This will generate:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<VAST version="2.0">
    <Ad id="ad1">
        <InLine>
            <AdSystem>Ad Server Name</AdSystem>
            <AdTitle><![CDATA[Ad Title]]></AdTitle>
            <Impression id="imp1"><![CDATA[http://ad.server.com/impression]]></Impression>
            <Creatives>
                <Creative>
                    <Linear>
                        <Duration>00:02:08</Duration>
                        <VideoClicks>
                            <ClickThrough><![CDATA[http://entertainmentserver.com/landing]]></ClickThrough>
                            <ClickTracking><![CDATA[http://ad.server.com/videoclicks/clicktracking]]></ClickTracking>
                            <CustomClick><![CDATA[http://ad.server.com/videoclicks/customclick]]></CustomClick>
                        </VideoClicks>
                        <TrackingEvents>
                            <Tracking event="start"><![CDATA[http://ad.server.com/trackingevent/start]]></Tracking>
                            <Tracking event="pause"><![CDATA[http://ad.server.com/trackingevent/stop]]></Tracking>
                        </TrackingEvents>
                        <MediaFiles>
                            <ClosedCaptionFiles>
                              <ClosedCaptionFile language="en-US" type="text/srt">
                                  <![CDATA[http://server.com/cc.srt]]>
                              </ClosedCaptionFile>
                            </ClosedCaptionFiles>
                            <MediaFile delivery="progressive" type="video/mp4" height="100" width="100" bitrate="2500">
                                <![CDATA[http://server.com/media1.mp4]]>
                            </MediaFile>
                            <MediaFile delivery="progressive" type="video/mp4" height="200" width="200" bitrate="2500">
                                <![CDATA[http://server.com/media2.mp4]]>
                            </MediaFile>
                        </MediaFiles>
                    </Linear>
                </Creative>
            </Creatives>
        </InLine>
    </Ad>
</VAST>
```

## Custom Specification Support

VAST document elements are completely described in it's specification, but some Ad servers may add support for custom elements and attributes. This library strictly follows specification, generally because two dialects of VAST may conflict with each other. You may write our own dialect by overriding element builder and create any elements and attributes you want.

The VAST dialect is described in `\Sokil\Vast\ElementBuilder` class. By overriding it you may create instances of your own classes and add there any setters.

First let's create a class for `MediaFile` and add some custom attributes:

```php
<?php

namespace Acme\Vast\ElementBuilder\Element;

use Sokil\Vast\Creative\InLine\Linear\MediaFile;

class AcmeMediaFile extends MediaFile
{
    public function setMinDuration($seconds)
    {
        $seconds = (int)$seconds;
        if ($seconds <= 0) {
            thow new \InvalidArgumentException('Invalid min duration specified, must be positive int')
        }
        
        $this->domElement->setAttribute('minDuration', $seconds);
        
        return $this;
    }
}
```

Now we need to override the default element builder and create our own `MediaFile` factory method:

```php
<?php

namespace Acme\Vast\ElementBuilder;

use Sokil\Vast\ElementBuilder;
use Acme\Vast\ElementBuilder\Element\AcmeMediaFile;

class AcmeElementBuilder extends ElementBuilder
{
    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return AcmeMediaFile
     */
    public function createInLineAdLinearCreativeMediaFile(\DOMElement $mediaFileDomElement)
    {
        return new AcmeMediaFile($mediaFileDomElement);
    }
}
```

Now we need to confugure VAST factory to use overridden element builder:

```php
<?php

use Acme\Vast\ElementBuilder\AcmeElementBuilder;
use Sokil\Vast\Factory;

$elementBuilder = new AcmeElementBuilder();
$factory = new Factory($elementBuilder);

$document = $factory->create('4.1');

$ad = $document->createInLineAdSection();
$creative = $ad->createLinearCreative();
$mediaFile = $creative->createMediaFile();

$mediaFile->setMinDiration(10);
```

If you have an AD server and want to add support for your custom tag, create your own library with custom elements and element builder, or add a pull request to this library. 
