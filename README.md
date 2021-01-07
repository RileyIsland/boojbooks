# Booj Reading List

*Beware of the person of one book. -- Thomas Aquinas*

## Task

Compose a site using the [Laravel](https://laravel.com/) or Vue framework that allows the user to create a list of books
they would like to read. Users should be able to perform the following actions:

* Connect to a publicly available API
* Create Postman collection and Vue app OR Laravel App
* Add or remove items from the list
* Change the order of the items in the list
* Sort the list of items
* Display a detail page with at least 3 points of data to display
* Include unit tests
* Deploy it on the cloud - be prepared to describe your process on deployment

## Solution

In order to spin up a local environment:

* clone the repo to your local files and navigate to the folder you cloned to
* run the following commands in this order:
    * `cp .env.example .env`
    * `composer install`
    * `php artisan key:generate`
    * `npm install`
    * `./vendor/bin/sail up`
* in another window in the same folder, run `./vendor/bin/sail artisan migrate`

You can then import the "booj-book-list-api-localhost.postman_collection.json" to your PostMan app to play with the API
directly or navigate to locahost in your browser to play with the Vue app.
