[![Build Status](https://travis-ci.org/borivojevic/moves-api-php.png?branch=master)](https://travis-ci.org/borivojevic/moves-api-php)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/borivojevic/moves-api-php/badges/quality-score.png?s=77f00079e962f7c80156a9dc51a09dfd72d34405)](https://scrutinizer-ci.com/g/borivojevic/moves-api-php/)
[![Code Coverage](https://scrutinizer-ci.com/g/borivojevic/moves-api-php/badges/coverage.png?s=8203a4a99138f78630ce3de7292d7ab489f51529)](https://scrutinizer-ci.com/g/borivojevic/moves-api-php/)
[![Latest Stable Version](https://poser.pugx.org/borivojevic/rescuetime/v/stable.png)](https://packagist.org/packages/borivojevic/moves)

moves-api-php
=============

PHP client for [Moves API](https://dev.moves-app.com/).

Inspired by [moves](https://github.com/ankane/moves) Ruby Gem.

### Installation ###

Recommend way to install this package with [Composer](http://getcomposer.org/). Add borivojevic/moves-api-php to your composer.json file.

``` json
{
    "require": {
        "borivojevic/moves": "1.*"
    }
}
```

To install composer run:

```
curl -s http://getcomposer.org/installer | php
```

To install composer dependences run:

```
php composer.phar install
```

You can autoload all dependencies by adding this to your code:

```
require 'vendor/autoload.php';
```

### Usage ###

The main entry point of the library is the Moves\Moves class. API methods require to be signed with valid access token parameter which you have to provide as a first argument of the constructor.

```php
$Moves = new \Moves\Moves($accessToken);
```

[Get Profile](https://dev.moves-app.com/docs/api_profile)

```php
$Moves->profile();
```

[Daily summaries](https://dev.moves-app.com/docs/api_summaries)

```php
$Moves->dailySummary(); # current day
$Moves->dailySummary('2013-11-20'); # any day
$Moves->dailySummary('2013-W48'); # any week
$Moves->dailySummary('2013-11'); # any month

# Date range - max 31 days
$Moves->dailySummary('2013-11-10', '2013-11-20');
$Moves->dailySummary(array('from' => '2013-11-10', 'to' => '2013-11-20'));

$Moves->dailySummary(array('pastDays' => 3)); # past 3 days

# also supports DateTime objects
$Moves->dailySummary(new DateTime('2013-11-20'));
$Moves->dailySummary(new DateTime('2013-11-10'), new DateTime('2013-11-20'));
$Moves->dailySummary(array('from' => new DateTime('2013-11-10'), 'to' => new DateTime('2013-11-20')));
```

[Daily activities](https://dev.moves-app.com/docs/api_activities)

```php
$Moves->dailyActivities(); # current day
$Moves->dailyActivities('2013-11-20'); # any day
$Moves->dailyActivities('2013-W48'); # any week

# Date range - max 7 days
$Moves->dailyActivities('2013-11-10', '2013-11-20');
$Moves->dailyActivities(array('from' => '2013-11-10', 'to' => '2013-11-20'));

$Moves->dailyActivities(array('pastDays' => 3)); # past 3 days
```

[Daily places](https://dev.moves-app.com/docs/api_places)

```php
$Moves->dailyPlaces(); # current day
$Moves->dailyPlaces('2013-11-20'); # any day
$Moves->dailyPlaces('2013-W48'); # any week

# Date range - max 7 days
$Moves->dailyPlaces('2013-11-10', '2013-11-20');
$Moves->dailyPlaces(array('from' => '2013-11-10', 'to' => '2013-11-20'));

$Moves->dailyPlaces(array('pastDays' => 3)); # past 3 days
```

[Daily storyline](https://dev.moves-app.com/docs/api_storyline)

```php
$Moves->dailyStoryline(); # current day
$Moves->dailyStoryline('2013-11-20'); # any day
$Moves->dailyStoryline('2013-W48'); # any week

# Date range - max 7 days
$Moves->dailyStoryline('2013-11-10', '2013-11-20');
$Moves->dailyStoryline(array('from' => '2013-11-10', 'to' => '2013-11-20'));

$Moves->dailyStoryline(array('pastDays' => 3)); # past 3 days

# Get daily storyline with track points
$Moves->dailyStoryline(array('trackPoints' => 'true'));
$Moves->dailyStoryline('2013-11-10', array('trackPoints' => 'true'));
```

### Versioning ###

The library uses [Semantic Versioning](http://semver.org/)

### Copyright and License ###

The library is licensed under the MIT license.
