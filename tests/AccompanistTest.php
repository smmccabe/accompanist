<?php

namespace Accompanist;

use PHPUnit\Framework\TestCase;

class AccompanistTest extends TestCase
{
    public function testDefaults()
    {
        $accompanist = new Accompanist('test/name', 'test description');

        $this->assertEquals('test/name', $accompanist->getName());
        $this->assertEquals('test description', $accompanist->getDescription());
    }

    public function testRead()
    {
        $accompanist = new Accompanist('test name');

        $accompanist->loadFromFile('./tests/test_composer.json');

        $this->assertEquals('smmccabe/accompanist', $accompanist->getName());
        $this->assertEquals('A PHP API for generating dynamic composer.json files', $accompanist->getDescription());
    }

    public function testWrite()
    {
        // clean up the file if it exists, so we don't effect the test.
        @unlink('./tests/testoutput_composer.json');

        $accompanist = new Accompanist('test name');
        $accompanist->addRequire('monolog/monolog');
        $accompanist->addRequire('guzzlehttp/guzzle', '^6.3');

        $accompanist->writeToFile('./tests/testoutput_composer.json');

        $this->assertTrue(file_exists('./tests/testoutput_composer.json'));
    }

    public function testReadWrite()
    {
        // clean up the file if it exists, so we don't effect the test.
        @unlink('./tests/testoutput_composer.json');

        $accompanist = new Accompanist('test name');

        $accompanist->loadFromFile('./tests/test_composer.json');
        $this->assertEquals('A PHP API for generating dynamic composer.json files', $accompanist->getDescription());

        $accompanist->setDescription('test description');
        $accompanist->writeToFile('./tests/testoutput_composer.json');

        $accompanist2 = new Accompanist('test/name2');
        $accompanist2->loadFromFile('./tests/testoutput_composer.json');
        $this->assertEquals('test description', $accompanist2->getDescription());
    }
}
