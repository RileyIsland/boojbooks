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

## Solution Details

### Local Environment

In order to use the app on a local computer:

* On your command line application clone the repository to your local files
* Navigate to the folder where you cloned the repository
* Run the following commands in this order:
    * `cp .env.example .env`
    * `composer install`
    * `php artisan key:generate`
    * `npm install`
    * `./vendor/bin/sail up`
* The last command take a long time, but you will know the application is ready when:
    * The mysql_1 container shows a message saying "ready for connections"
    * The laravel.test_1 container shows a message saying "Development Server...started"
* Once you see those messages, open another command line window, navigate to the same folder, and
  run `./vendor/bin/sail artisan migrate`
* Optionally in another command line:
    * Run `npm run dev` if you want to be able to use the Vue inspector in your browser developer tools
    * Run `npm run watch` if you want to make changes to the code and have the changes compile immediately

Once you follow the previous steps:

* Import the "booj-book-list-api-localhost.postman_collection.json" to your PostMan app to play with the API
* Navigate to localhost in your browser to play with the Vue app
* Run `./vendor/bin/sail test` in the command line to run the tests

### Deployment to Production:

I chose Elastic Beanstalk and was able to deploy the site
at http://rileyislandboojbooks-env.eba-g8uj9mjg.us-east-2.elasticbeanstalk.com/. I will leave this instance up and
running until the site has been reasonably assessed by the Booj and Re/Max team.

Ideally if this were a project in need of a more CI/CD-based approach, I would have used Elastic CodePipeline to fire
off automated tests and automatically deploy on every git merge. However, I am admittedly pretty green to setting up a
deployment from scratch. So this was a good first step to just deploy an application.
