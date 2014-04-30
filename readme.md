# Kompakt Generic Release Batch

Generic release batch definition

## Description

This package implements the handling of music deliveries (batches). The deliveries usually take place for encoding jobs or data and media imports into other systems. A batch is the sum of packshots in a delivery collected in one directory which lives in a drop directory. Packshots contain metadata about the release plus artwork, audio and other media files. The packshot structure can vary, a layout definition describes file locations, metadata readers and writers handle proprietary information schemas.

Tasks are the starting point of a specific application and process the containing packshots in some way. This could be an encoding job or a file-upload. Typically a task starts by selecting a batch from user input followed by "tracing" various steps while iterating over the packshots. Subscribers are notified of steps such as "metadata read ok" or "arwork not found" and can act upon the situation. This architecture allows fault-tolerant batch processing for cases where items fail to conform the expected contents. Such events may be logged by subscribers.

This package merely implements the building blocks described above. It is up to you to write concrete implementations for your specific batch structure. An example can be found here [kompakt/godisko-release-batch](http://github.com/kompakt/godisko-release-batch).

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