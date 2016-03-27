YEGVotes Website
==================

This is the git repository backing [YEGVotes.info](https://yegvotes.info).

Installation can be easily done on your own client machine by cloning the repository, running `composer install` and then doing the following:

1. Copy `.env.example` to `.env` and fill in the appropraite values (primarily your socrata information and local database information
2. Run `php artisan migrate --seed` to migrate and seed initial data.
3. Run `php artisan yegvotes:update_all` to pull relevant data from Socrata. This process might take a few minutes, as it pulls all data for the current term
4. Ensure that any councillors who were replaced mid-term (*cough*Sohi*cough*) are have the year in their term row. This will prevent them from showing up in the UI.

Testing
--------

Am I really going to be held to that high of a standard?

Simply run `phpunit`.



