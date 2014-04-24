# Kompakt Release Batch

Release batch abstraction library

## Install

+ `git clone https://github.com/kompakt/release-batch-tools.git`
+ `cd batch-tools`
+ `curl -sS https://getcomposer.org/installer | php`
+ `php composer.phar install`

## Tests

+ `cp tests/config.php.dist config.php`
+ Adjust `config.php` as needed
+ `vendor/bin/phpunit`

# Unit Tests

+ `vendor/bin/phpunit tests/Kompakt/Tests`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/Batch/BatchTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/Batch/Factory/BatchFactoryTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/Batch/Processor/BatchProcessorTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/DropDir/DropDirTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/Packshot/Factory/PackshotFactoryTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/Packshot/Metadata/Loader/LoaderTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/Packshot/PackshotTest`
+ `vendor/bin/phpunit tests/Kompakt/Tests/ReleaseBatch/Packshot/Processor/PackshotProcessorTest`