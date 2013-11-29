moves-api-php
=============

PHP wrapper library for [Moves API](https://dev.moves-app.com/)

## Usage

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