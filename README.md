# mod-news

Module for PIXELION CMS

[![Latest Stable Version](https://poser.pugx.org/panix/mod-news/v/stable)](https://packagist.org/packages/panix/mod-news) [![Total Downloads](https://poser.pugx.org/panix/mod-pages/downloads)](https://packagist.org/packages/panix/mod-pages) [![Monthly Downloads](https://poser.pugx.org/panix/mod-pages/d/monthly)](https://packagist.org/packages/panix/mod-pages) [![Daily Downloads](https://poser.pugx.org/panix/mod-pages/d/daily)](https://packagist.org/packages/panix/mod-pages) [![Latest Unstable Version](https://poser.pugx.org/panix/mod-pages/v/unstable)](https://packagist.org/packages/panix/mod-pages) [![License](https://poser.pugx.org/panix/mod-pages/license)](https://packagist.org/packages/panix/mod-pages)


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

#### Either run

```
php composer require --prefer-dist panix/mod-news "*"
```

or add

```
"panix/mod-news": "*"
```

to the require section of your `composer.json` file.


#### Add to web config.
```
    'modules' => [
        'news' => ['class' => 'panix\mod\news\Module'],
    ],
```
#### Migrate
```
php yii migrate --migrationPath=vendor/panix/mod-news/migrations
```
