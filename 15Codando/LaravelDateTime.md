# Easier Date/Time in Laravel and PHP with Carbon

    • By Chris On Code
      PostedSeptember 15, 2020 28.6k views 

While this tutorial has content that we believe is of great benefit to our community, we have not yet tested or edited it to ensure you have an error-free learning experience. It's on our list, and we're working on it! You can help us out by using the "report an issue" button at the bottom of the tutorial. 

## Introduction

Working with date and time in PHP is not the easiest or most clear of tasks. We have to deal with strtotime, formatting issues, lots of calculations, and more.

The nifty package called Carbon can help make dealing with date/time in PHP much easier and more semantic so that our code can become more readable and maintainable.

Carbon is a package by Brian Nesbit that extends PHP’s own DateTime class.

## It provides some nice functionality to deal with dates in PHP. Specifically things like:
    • Dealing with timezones 
    • Getting current time easily 
    • Converting a datetime into something readable 
    • Parse an English phrase into datetime (first day of January 2016) 
    • Add and Subtract dates (+ 2 weeks, -6 months) 
    • Semantic way of dealing with dates 

All of the above lead to a very useful package that makes it a breeze to deal with times in PHP.

## Setup

In order to use Carbon, you’ll need to import Carbon from the Carbon namespace. Luckily for us, Carbon is already included in Laravel so there’s no need to go and add it with Composer.

Whenever we need to use Carbon, we can import it like so:
```php
<?php
use Carbon\Carbon;
```
After importing, let’s look at some cool things we can do with this great package.
Getting a Specific Date/Time
```php
// get the current time  - 2015-12-19 10:10:54
$current = Carbon::now();
$current = new Carbon();

// get today - 2015-12-19 00:00:00
$today = Carbon::today();

// get yesterday - 2015-12-18 00:00:00
$yesterday = Carbon::yesterday();

// get tomorrow - 2015-12-20 00:00:00
$tomorrow = Carbon::tomorrow();

// parse a specific string - 2016-01-01 00:00:00
$newYear = new Carbon('first day of January 2016');

// set a specific timezone - 2016-01-01 00:00:00
$newYearPST = new Carbon('first day of January 2016', 'America\Pacific');
```
Creating Dates with More Fine Grained Control

In addition to the quick ways to define date/times, Carbon also let’s us create date/times from a specific number of arguments.
```php
Carbon::createFromDate($year, $month, $day, $tz);
Carbon::createFromTime($hour, $minute, $second, $tz);
Carbon::create($year, $month, $day, $hour, $minute, $second, $tz);
```
These are very helpful when you get some sort of date or time in a format that isn’t normally recognized by Carbon. If you pass in null for any of those attributes, it will default to current.

## Manipulating the Date/Time

Grabbing the date/time isn’t the only thing you’ll need to do when working with dates. You’ll often need to manipulate the date or time.

For instance, when creating a trial period for a user, you will want the trial period to expire after a certain amount of time. So let’s say we have a 30 day trial period. We could easily calculate that time with add and subtract.

For this trial period, we would do:
```php
// get the current time
$current = Carbon::now();

// add 30 days to the current time

$trialExpires = $current->addDays(30);
```
From the Carbon docs, here are some of the other add() and sub() methods available to us:
```php
$dt = Carbon::create(2012, 1, 31, 0);

echo $dt->toDateTimeString();            // 2012-01-31 00:00:00

echo $dt->addYears(5);                   // 2017-01-31 00:00:00
echo $dt->addYear();                     // 2018-01-31 00:00:00
echo $dt->subYear();                     // 2017-01-31 00:00:00
echo $dt->subYears(5);                   // 2012-01-31 00:00:00

echo $dt->addMonths(60);                 // 2017-01-31 00:00:00
echo $dt->addMonth();                    // 2017-03-03 00:00:00 equivalent of $dt->month($dt->month + 1); so it wraps
echo $dt->subMonth();                    // 2017-02-03 00:00:00
echo $dt->subMonths(60);                 // 2012-02-03 00:00:00

echo $dt->addDays(29);                   // 2012-03-03 00:00:00
echo $dt->addDay();                      // 2012-03-04 00:00:00
echo $dt->subDay();                      // 2012-03-03 00:00:00
echo $dt->subDays(29);                   // 2012-02-03 00:00:00

echo $dt->addWeekdays(4);                // 2012-02-09 00:00:00
echo $dt->addWeekday();                  // 2012-02-10 00:00:00
echo $dt->subWeekday();                  // 2012-02-09 00:00:00
echo $dt->subWeekdays(4);                // 2012-02-03 00:00:00

echo $dt->addWeeks(3);                   // 2012-02-24 00:00:00
echo $dt->addWeek();                     // 2012-03-02 00:00:00
echo $dt->subWeek();                     // 2012-02-24 00:00:00
echo $dt->subWeeks(3);                   // 2012-02-03 00:00:00

echo $dt->addHours(24);                  // 2012-02-04 00:00:00
echo $dt->addHour();                     // 2012-02-04 01:00:00
echo $dt->subHour();                     // 2012-02-04 00:00:00
echo $dt->subHours(24);                  // 2012-02-03 00:00:00

echo $dt->addMinutes(61);                // 2012-02-03 01:01:00
echo $dt->addMinute();                   // 2012-02-03 01:02:00
echo $dt->subMinute();                   // 2012-02-03 01:01:00
echo $dt->subMinutes(61);                // 2012-02-03 00:00:00

echo $dt->addSeconds(61);                // 2012-02-03 00:01:01
echo $dt->addSecond();                   // 2012-02-03 00:01:02
echo $dt->subSecond();                   // 2012-02-03 00:01:01
echo $dt->subSeconds(61);                // 2012-02-03 00:00:00
Getters and Setters
Another quick way to manipulate or read the time is to use the getters and setters available.
$dt = Carbon::now();

// set some things
$dt->year   = 2015;
$dt->month  = 04;
$dt->day    = 21;
$dt->hour   = 22;
$dt->minute = 32;
$dt->second = 5;

// get some things
var_dump($dt->year);
var_dump($dt->month);
var_dump($dt->day);
var_dump($dt->hour);
var_dump($dt->second);
var_dump($dt->dayOfWeek);
var_dump($dt->dayOfYear);
var_dump($dt->weekOfMonth);
var_dump($dt->daysInMonth);
We can even string together some setters
$dt = Carbon::now();

$dt->year(1975)->month(5)->day(21)->hour(22)->minute(32)->second(5)->toDateTimeString();
$dt->setDate(1975, 5, 21)->setTime(22, 32, 5)->toDateTimeString();
$dt->setDateTime(1975, 5, 21, 22, 32, 5)->toDateTimeString();
```
Formatting
In that example above, you may have noticed the -&gt;toDateTimeString() method. We can easily format the date/time for our purposes. In that case, we got a datetime string.
```php
$dt = Carbon::now();

echo $dt->toDateString();               // 2015-12-19
echo $dt->toFormattedDateString();      // Dec 19, 2015
echo $dt->toTimeString();               // 10:10:16
echo $dt->toDateTimeString();           // 2015-12-19 10:10:16
echo $dt->toDayDateTimeString();        // Sat, Dec 19, 2015 10:10 AM

// ... of course format() is still available
echo $dt->format('l jS \\of F Y h:i:s A');         // Saturday 19th of December 2015 10:10:16 AM
```
## Relative Time

Carbon lets us easily display time relatively with the diff() methods.
For instance, let’s say we have a blog and wanted to show a published time of 3 hours ago. We would be able to do that with these methods.

Finding the Difference
These methods are used to just find the number of difference.
```php
$current = Carbon::now();
$dt      = Carbon::now();

$dt = $dt->subHours(6);
echo $dt->diffInHours($current);         // -6
echo $current->diffInHours($dt);         // 6

$future = $current->addMonth();
$past   = $current->subMonths(2);
echo $current->diffInDays($future);      // 31
echo $current->diffInDays($past);        // -62
```
## Displaying the Difference for Humans

Displaying time relatively can sometimes be more useful to readers than a date or timestamp.

For example, instead of displaying the time of a post like 8:12am, the time will be displayed as 3 hrs ago.

The diffForHumans() method is used for calculating the difference and also converting it to a humanly readable format.

Here are some examples:
```php
$dt     = Carbon::now();
$past   = $dt->subMonth();
$future = $dt->addMonth();

echo $dt->subDays(10)->diffForHumans();     // 10 days ago
echo $dt->diffForHumans($past);             // 1 month ago
echo $dt->diffForHumans($future);           // 1 month before
```
## Conclusion

There’s plenty more that Carbon can do. Be sure to look through the official Carbon docs. Hopefully this helps use date/times easier in PHP and speeds up development times!

https://www.digitalocean.com/community/tutorials/easier-datetime-in-laravel-and-php-with-carbon

