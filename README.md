# Cleaner Robot

**Installation**

composer install

**Use**

run this command to clean and see the state of cleaning and charging.

`$ php robot.php clean --floor=carpet --area=60 `

`$ php robot.php clean --floor=hard --area=30 `

The --floor parameter can have one of the values _hard_ or _carpet_.

**Tests**

You can run tests by 
`./vendor/bin/phpunit --bootstrap ./vendor/autoload.php tests`
