# Kompakt Mediameister

Media batch processing framework

## Description

This package provides the building blocks for media batch processing applications. Media processing can be anything such as encoding jobs, data imports, re-formattings, taggings or transfers applied to a set of releases. A batch is the sum of releases in a delivery collected in one directory which lives in a drop directory. A release is collected into a packshot and contains metadata, artwork, audio and other media files. The packshot structure can vary, a layout definition describes file locations, metadata readers and writers handle proprietary information schemas. Only batches of identical structure should live together in a given drop dir, thus use one drop dir per supported structure. Unless it is merely a read-only task, this means that processing results of one batch should be saved to a batch in another drop dir.

Tasks are the starting point of a specific application and process the packshots contained in a batch. Typically a task starts by selecting a batch followed by tracking various steps while iterating over the packshots. Subscribers are notified of steps such as "metadata read ok" or "arwork not found" and can act upon the situation. This architecture allows fault-tolerant batch processing for cases where items fail to conform to expected contents. Such events may in turn be logged by specialized subscribers.

This package implements the building blocks described above. It is up to you to write concrete implementations for your specific batch structure. An example can be found here [kompakt/godisko-release-batch](http://github.com/kompakt/godisko-release-batch).

Example:

    + drop-dir
        + batch-dir
            + packshot-dir
                + metadata.xml
                + audio-1.wav
                + audio-2.wav
                + audio-3.wav
                + artwork.jpg
                + booklet.pdf
            + ...

## Install

+ `git clone https://github.com/kompakt/mediameister.git`
+ `cd mediameister`
+ `curl -sS https://getcomposer.org/installer | php`
+ `php composer.phar install`

## Tests

+ `cp tests/config.php.dist config.php`
+ Adjust `config.php` as needed
+ `vendor/bin/phpunit`
+ `vendor/bin/phpunit --coverage-html tests/_coverage`

## License

kompakt/mediameister is licensed under the MIT license - see the LICENSE file for details