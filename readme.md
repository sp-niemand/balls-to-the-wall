# Balls to the wall

[![Build Status](https://travis-ci.org/sp-niemand/balls-to-the-wall.svg?branch=master)](https://travis-ci.org/sp-niemand/balls-to-the-wall)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sp-niemand/balls-to-the-wall/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sp-niemand/balls-to-the-wall/?branch=master)

## Backstory

Imagine a universe with:

* an​ infinite amount of balls, each of them with a number (from 1 to 999) on it (so we have 
an infinite amount of balls #1, an infinite amount of balls #2 etc.) 
30 baskets, each with a space for 10 balls 
our dear user has his own, special basket with space for 100 balls 
Now, what happens is:
* we fill each basket with a random amount (no higher than the basket’s capacity, higher 
than zero) of unique balls (so there is no basket with two balls #8, but ball #8 can be in 
many baskets) 
* the user also fills his basket with a random amount of unique balls (same rules apply) 

## And what should I do?
1. recreate the above scenario 
2. find baskets, that have only balls owned by the user 
3. find baskets, that have exactly one ball owned by the user 
This task is your best opportunity to showcase your skills and impress us, so proceed wisely.

## Requirements

* PHP 5.5+ (entire app tested on PHP 5.5, but should also work on 5.6 and 7.0)

## Install

* `composer install`

## Run

* application: `php bin/index.php`. It starts up WebSocket server on `localhost:8000`.
You can use a sample client from `client/client.html` to work with the server:
just open the page in browser (tested in Chrome).
* tests: `php vendor/bin/phpunit --bootstrap vendor/autoload.php test`
* phpcs: `vendor/bin/phpcs src`
* phpmd: `vendor/bin/phpmd src text cleancode`

## Inspiration video

[![Project name inspiration](http://img.youtube.com/vi/B_3TlrZLpQ0/hqdefault.jpg)] (https://www.youtube.com/watch?v=B_3TlrZLpQ0 "Project name inspiration")