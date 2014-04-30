# Kompakt Generic Release Batch

Generic release batch definition

## Install

+ `git clone https://github.com/kompakt/generic-release-batch.git`
+ `cd generic-release-batch`
+ `curl -sS https://getcomposer.org/installer | php`
+ `php composer.phar install`

## Tests

+ `cp tests/config.php.dist config.php`
+ Adjust `config.php` as needed
+ `vendor/bin/phpunit`
+ `vendor/bin/phpunit --coverage-html tests/_coverage`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/Batch/BatchTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/Batch/Factory/BatchFactoryTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/Batch/Tracer/BatchTracerTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/DropDir/DropDirTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/Packshot/Factory/PackshotFactoryTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/Packshot/Metadata/Loader/LoaderTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/Packshot/PackshotTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/GenericReleaseBatch/Packshot/Tracer/PackshotTracerTest`

## License

See LICENSE.