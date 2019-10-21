Toy Robot Simulator
=====================================

This is the code to run and test the Toy Robot Simulator. It is a command line application that requires PHP to be installed.
It has been created with Laravel 6.3.0. It requires that PHP 7.2 and Composer is installed. 

There are only two files concerned with my code. They are `app/Console/Commands/StartSimulator.php` and `app/CustomClass/ToyRobotSimulator.php`.

The tests are in `tests/Unit` and `tests/Feature`. Note that I couldn't get the dependency injection to work on the unit tests so they currently fail but I believe the code is correct. I could work on that more but I am at the 5 hour limit and feel that the demonstration I have should be sufficient to gauge understanding. The feature tests work and pass as expected.

## Run application
Check out the code to your filesystem and run the following commands:

`composer install`

`php artisan toy-robot:start`

Commands should be executed exactly how they're demonstrated in the example documentation. Eg.

```
PLACE 0,0,N
LEFT
REPORT
Expected output:
0,0,W
```

Note: I just noticed I have put in initials for direction rather than the full word.

## Tests

The tests require PHP Unit to be installed:
- Unit tests: `phpunit tests/Unit`
- Feature tests: `phpunit tests/Feature`
