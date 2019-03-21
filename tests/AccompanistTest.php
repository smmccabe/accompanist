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
        $this->assertEquals('1.0.0', $accompanist->getVersion());
        $this->assertEquals('library', $accompanist->getType());

        // Keywords
        $this->assertEquals('logging', $accompanist->getKeywords()[0]);
        $this->assertEquals('events', $accompanist->getKeywords()[1]);

        $this->assertEquals('https://www.example.com', $accompanist->getHomepage());
        $this->assertEquals('README.md', $accompanist->getReadme());
        $this->assertEquals('2019-03-15', $accompanist->getTime());
        $this->assertEquals('GPL-3.0', $accompanist->getLicense());

        $authors = $accompanist->getAuthors();
        $this->assertEquals('Shawn McCabe', $authors[0]->name);
        $this->assertEquals('smccabe@acromedia.com', $authors[0]->email);

        $support = $accompanist->getSupport();
        $this->assertEquals('smccabe@acromedia.com', $support->getEmail());
        $this->assertEquals('https://github.com/smmccabe/accompanist/issues', $support->getIssues());
        $this->assertEquals('www.example.com/forum', $support->getForum());
        $this->assertEquals('www.example.com/wiki', $support->getWiki());
        $this->assertEquals('#accompanist', $support->getIrc());
        $this->assertEquals('https://github.com/smmccabe/accompanist', $support->getSource());
        $this->assertEquals('www.example.com/docs', $support->getDocs());
        $this->assertEquals('www.example.com/rss', $support->getRss());
        $this->assertEquals('slack #accompanist', $support->getChat());

        $this->assertEquals('^7.0', $accompanist->getRequire()->php);
        $this->assertEquals('^7.1@dev', $accompanist->getRequireDev()->{"phpunit/phpunit"});
        $this->assertEquals('1.0.0', $accompanist->getConflict()->{"made/up"});
        $this->assertEquals('3.2.1', $accompanist->getReplace()->{"replace/me"});
        $this->assertEquals('4.5.6', $accompanist->getProvide()->{"pro/vide"});
        $this->assertEquals(
            'Allows more advanced logging of the application flow',
            $accompanist->getSuggest()->{"monolog/monolog"}
        );

        $autoload = $accompanist->getAutoload();
        $this->assertEquals('src/', $autoload->getPsr4()->{"Accompanist\\"});
        $this->assertEquals('src-psr0/', $autoload->getPsr0()->{"AccompanistPsr0\\"});
        $this->assertEquals('src-classmap/', $autoload->getClassmap()[0]);
        $this->assertEquals('src-classmap-exclude/', $autoload->getExcludeFromClassmap()[0]);
        $this->assertEquals('src-files/', $autoload->getFiles()[0]);

        $autoload = $accompanist->getAutoloadDev();
        $this->assertEquals('src-dev/', $autoload->getPsr4()->{"AccompanistDev\\"});
        $this->assertEquals('src-dev-psr0/', $autoload->getPsr0()->{"AccompanistDevPsr0\\"});
        $this->assertEquals('src-dev-classmap/', $autoload->getClassmap()[0]);
        $this->assertEquals('src-dev-classmap-exclude/', $autoload->getExcludeFromClassmap()[0]);
        $this->assertEquals('src-dev-files/', $autoload->getFiles()[0]);

        $this->assertEquals('dev', $accompanist->getMinimumStability());
        $this->assertEquals(false, $accompanist->isPreferStable());

        $repositories = $accompanist->getRepositories();
        $this->assertEquals('composer', $repositories[0]->getType());
        $this->assertEquals('http://packages.example.com', $repositories[0]->getUrl());
        $this->assertEquals('composer', $repositories[1]->getType());
        $this->assertEquals('https://packages.example.com', $repositories[1]->getUrl());
        $this->assertEquals('true', $repositories[1]->getOptions()->ssl->verify_peer);
        $this->assertEquals('vcs', $repositories[2]->getType());
        $this->assertEquals('https://github.com/Seldaek/monolog', $repositories[2]->getUrl());
        $this->assertEquals('pear', $repositories[3]->getType());
        $this->assertEquals('https://pear2.php.net', $repositories[3]->getUrl());
        $this->assertEquals('package', $repositories[4]->getType());

        $package = $repositories[4]->getPackage();
        $this->assertEquals('smarty/smarty', $package->getName());
        $this->assertEquals('3.1.7', $package->getVersion());
        $this->assertEquals('https://www.smarty.net/files/Smarty-3.1.7.zip', $package->getDist()->url);
        $this->assertEquals('zip', $package->getDist()->type);
        $this->assertEquals('https://smarty-php.googlecode.com/svn/', $package->getSource()->url);
        $this->assertEquals('svn', $package->getSource()->type);
        $this->assertEquals('tags/Smarty_3_1_7/distribution/', $package->getSource()->reference);
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
