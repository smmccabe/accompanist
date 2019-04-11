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
        $this->assertEquals('logging', $accompanist->getKeywords()['logging']);
        $this->assertEquals('events', $accompanist->getKeywords()['events']);

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

    public function testMerge()
    {
        $accompanist_base = new Accompanist();
        $accompanist_base->loadFromFile('./tests/test_merge_base.json');
        $accompanist_addon = new Accompanist();
        $accompanist_addon->loadFromFile('./tests/test_merge_addon.json');
        // Testing merge without overwrite.
        $accompanist_base->merge($accompanist_addon);

        $this->assertEquals('smmccabe/accompanist', $accompanist_base->getName());
        $this->assertEquals('A PHP API for generating dynamic composer.json files', $accompanist_base->getDescription());
        $this->assertEquals('1.0.0', $accompanist_base->getVersion());
        $this->assertEquals('library', $accompanist_base->getType());

        // Keywords are not unique, so they should add instead of overwriting.
        $this->assertEquals('logging', $accompanist_base->getKeywords()['logging']);
        $this->assertEquals('events', $accompanist_base->getKeywords()['events']);
        $this->assertEquals('avengers', $accompanist_base->getKeywords()['avengers']);
        $this->assertEquals('hank pym', $accompanist_base->getKeywords()['hank pym']);

        $this->assertEquals('https://www.example.com', $accompanist_base->getHomepage());
        $this->assertEquals('README.md', $accompanist_base->getReadme());
        $this->assertEquals('2019-03-15', $accompanist_base->getTime());
        $this->assertEquals('GPL-3.0', $accompanist_base->getLicense());

        $authors = $accompanist_base->getAuthors();
        $this->assertEquals('Shawn McCabe', $authors[0]->name);
        $this->assertEquals('smccabe@acromedia.com', $authors[0]->email);

        $support = $accompanist_base->getSupport();
        $this->assertEquals('smccabe@acromedia.com', $support->getEmail());
        $this->assertEquals('https://github.com/smmccabe/accompanist/issues', $support->getIssues());
        $this->assertEquals('www.example.com/forum', $support->getForum());
        $this->assertEquals('www.example.com/wiki', $support->getWiki());
        $this->assertEquals('#accompanist', $support->getIrc());
        $this->assertEquals('https://github.com/smmccabe/accompanist', $support->getSource());
        $this->assertEquals('www.example.com/docs', $support->getDocs());
        $this->assertEquals('www.example.com/rss', $support->getRss());
        $this->assertEquals('slack #accompanist', $support->getChat());

        $this->assertEquals('^7.0', $accompanist_base->getRequire()->php);
        $this->assertEquals('^7.1@dev', $accompanist_base->getRequireDev()->{"phpunit/phpunit"});
        $this->assertEquals('1.0.0', $accompanist_base->getConflict()->{"made/up"});
        $this->assertEquals('3.2.1', $accompanist_base->getReplace()->{"replace/me"});
        $this->assertEquals('4.5.6', $accompanist_base->getProvide()->{"pro/vide"});
        $this->assertEquals(
            'Allows more advanced logging of the application flow',
            $accompanist_base->getSuggest()->{"monolog/monolog"}
        );

        $this->assertEquals('^0.9.1', $accompanist_base->getRequire()->{'pym/particles'});

        $this->assertEquals('^7.1@dev', $accompanist_base->getRequireDev()->{"phpunit/phpunit"});
        $this->assertEquals('3.1.1', $accompanist_base->getRequireDev()->{'banner/gamma'});

        $this->assertEquals('1.0.0', $accompanist_base->getConflict()->{"made/up"});
        $this->assertEquals('1.0.0', $accompanist_base->getConflict()->{'pym/ultron'});

        $this->assertEquals('3.2.1', $accompanist_base->getReplace()->{"replace/me"});
        $this->assertEquals('1.0.2', $accompanist_base->getReplace()->{'pym/ultron'});

        $this->assertEquals('4.5.6', $accompanist_base->getProvide()->{"pro/vide"});
        $this->assertEquals('0.0.2', $accompanist_base->getProvide()->{'stark/ironlegion'});

        $autoload = $accompanist_base->getAutoload();
        $this->assertEquals('src/', $autoload->getPsr4()->{"Accompanist\\"});
        $this->assertEquals('src-psr0/', $autoload->getPsr0()->{"AccompanistPsr0\\"});
        $this->assertEquals('src-classmap/', $autoload->getClassmap()[0]);
        $this->assertEquals('src-classmap-exclude/', $autoload->getExcludeFromClassmap()[0]);
        $this->assertEquals('src-files/', $autoload->getFiles()[0]);

        $autoload = $accompanist_base->getAutoloadDev();
        $this->assertEquals('src-dev/', $autoload->getPsr4()->{"AccompanistDev\\"});
        $this->assertEquals('src-dev-psr0/', $autoload->getPsr0()->{"AccompanistDevPsr0\\"});
        $this->assertEquals('src-dev-classmap/', $autoload->getClassmap()[0]);
        $this->assertEquals('src-dev-classmap-exclude/', $autoload->getExcludeFromClassmap()[0]);
        $this->assertEquals('src-dev-files/', $autoload->getFiles()[0]);

        $this->assertEquals('dev', $accompanist_base->getMinimumStability());
        $this->assertEquals(false, $accompanist_base->isPreferStable());

        $repositories = $accompanist_base->getRepositories();
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

        $this->assertEquals('composer', $repositories[5]->getType());
        $this->assertEquals('http://packages.starkenterprises.com', $repositories[5]->getUrl());
        $this->assertEquals('composer', $repositories[6]->getType());
        $this->assertEquals('https://packages.pymtechnologies.com', $repositories[6]->getUrl());
        $this->assertEquals('false', $repositories[6]->getOptions()->ssl->verify_peer);
        $this->assertEquals('vcs', $repositories[7]->getType());
        $this->assertEquals('https://github.com/banner/gamma', $repositories[7]->getUrl());
        $this->assertEquals('pear', $repositories[8]->getType());
        $this->assertEquals('https://pear.starkenterprises.com', $repositories[8]->getUrl());
        $this->assertEquals('package', $repositories[9]->getType());

        $package = $repositories[9]->getPackage();
        $this->assertEquals('stark/jarvis', $package->getName());
        $this->assertEquals('5.0.1', $package->getVersion());
        $this->assertEquals('https://jarvis.starkenterprises.net/files/jarvis-5.0.1.zip', $package->getDist()->url);
        $this->assertEquals('zip', $package->getDist()->type);
        $this->assertEquals('https://ironman.tonystark.com/svn/', $package->getSource()->url);
        $this->assertEquals('svn', $package->getSource()->type);
        $this->assertEquals('tags/jarvis_5_0_1/distribution/', $package->getSource()->reference);
    }

    public function testMergeOverwrite()
    {
        $accompanist_base = new Accompanist();
        $accompanist_base->loadFromFile('./tests/test_merge_base.json');
        $accompanist_addon = new Accompanist();
        $accompanist_addon->loadFromFile('./tests/test_merge_addon.json');
        // Testing merge without overwrite.
        $accompanist_base->merge($accompanist_addon, true);

        $this->assertEquals('stark/ultron', $accompanist_base->getName());
        $this->assertEquals('An AI that definitely will not go rogue.', $accompanist_base->getDescription());
        $this->assertEquals('2.0.1', $accompanist_base->getVersion());
        $this->assertEquals('ai', $accompanist_base->getType());

        // Keywords
        $this->assertEquals('logging', $accompanist_base->getKeywords()['logging']);
        $this->assertEquals('events', $accompanist_base->getKeywords()['events']);
        $this->assertEquals('avengers', $accompanist_base->getKeywords()['avengers']);
        $this->assertEquals('hank pym', $accompanist_base->getKeywords()['hank pym']);

        $this->assertEquals('https://ultron.starkenterprises.com', $accompanist_base->getHomepage());
        $this->assertEquals('stark_notes.md', $accompanist_base->getReadme());
        $this->assertEquals('1968-08-01', $accompanist_base->getTime());
        $this->assertEquals('Stark Enterprises Proprietary', $accompanist_base->getLicense());

        $authors = $accompanist_base->getAuthors();
        $this->assertEquals('Shawn McCabe', $authors[0]->name);
        $this->assertEquals('smccabe@acromedia.com', $authors[0]->email);
        $this->assertEquals('Tony Stark', $authors[1]->name);
        $this->assertEquals('astark@starkenterprises.com', $authors[1]->email);

        $support = $accompanist_base->getSupport();
        $this->assertEquals('ppotts@starkenterprises.com', $support->getEmail());
        $this->assertEquals('https://github.com/stark/ultron/issues', $support->getIssues());
        $this->assertEquals('ultron.starkenterprises.com/forum', $support->getForum());
        $this->assertEquals('ultron.starkenterprises.com/wiki', $support->getWiki());
        $this->assertEquals('#ultron', $support->getIrc());
        $this->assertEquals('https://github.com/stark/ultron', $support->getSource());
        $this->assertEquals('ultron.starkenterprises.com/docs', $support->getDocs());
        $this->assertEquals('ultron.starkenterprises.com/rss', $support->getRss());
        $this->assertEquals('slack #ultron', $support->getChat());

        $this->assertEquals('^7.2', $accompanist_base->getRequire()->php);
        $this->assertEquals('^0.9.1', $accompanist_base->getRequire()->{'pym/particles'});

        $this->assertEquals('^7.1@dev', $accompanist_base->getRequireDev()->{"phpunit/phpunit"});
        $this->assertEquals('3.1.1', $accompanist_base->getRequireDev()->{'banner/gamma'});

        $this->assertEquals('1.0.0', $accompanist_base->getConflict()->{"made/up"});
        $this->assertEquals('1.0.0', $accompanist_base->getConflict()->{'pym/ultron'});

        $this->assertEquals('3.2.1', $accompanist_base->getReplace()->{"replace/me"});
        $this->assertEquals('1.0.2', $accompanist_base->getReplace()->{'pym/ultron'});

        $this->assertEquals('4.5.6', $accompanist_base->getProvide()->{"pro/vide"});
        $this->assertEquals('0.0.2', $accompanist_base->getProvide()->{'stark/ironlegion'});

        $this->assertEquals(
            'Allows more advanced logging of the application flow',
            $accompanist_base->getSuggest()->{"monolog/monolog"}
        );
        $this->assertEquals(
            'Failsafe if stuff goes haywire (unlikely)',
            $accompanist_base->getSuggest()->{'shield/override'}
        );

        $autoload = $accompanist_base->getAutoload();
        $this->assertEquals('src/', $autoload->getPsr4()->{"Accompanist\\"});
        $this->assertEquals('src-ultron/', $autoload->getPsr4()->{"Ultron\\"});

        $this->assertEquals('src-psr0/', $autoload->getPsr0()->{"AccompanistPsr0\\"});
        $this->assertEquals('src-ultron-psr0/', $autoload->getPsr0()->{"UltronPsr0\\"});

        $this->assertEquals('src-classmap/', $autoload->getClassmap()[0]);
        $this->assertEquals('src-ultron-classmap/', $autoload->getClassmap()[1]);

        $this->assertEquals('src-classmap-exclude/', $autoload->getExcludeFromClassmap()[0]);
        $this->assertEquals('src-ultron-classmap-exclude/', $autoload->getExcludeFromClassmap()[1]);

        $this->assertEquals('src-files/', $autoload->getFiles()[0]);
        $this->assertEquals('src-ultron-files/', $autoload->getFiles()[1]);

        $autoload = $accompanist_base->getAutoloadDev();
        $this->assertEquals('src-dev/', $autoload->getPsr4()->{"AccompanistDev\\"});
        $this->assertEquals('src-ultron-dev/', $autoload->getPsr4()->{"UltronDev\\"});

        $this->assertEquals('src-dev-psr0/', $autoload->getPsr0()->{"AccompanistDevPsr0\\"});
        $this->assertEquals('src-ultron-dev-psr0/', $autoload->getPsr0()->{"UltronDevPsr0\\"});

        $this->assertEquals('src-dev-classmap/', $autoload->getClassmap()[0]);
        $this->assertEquals('src-ultron-dev-classmap/', $autoload->getClassmap()[1]);

        $this->assertEquals('src-dev-classmap-exclude/', $autoload->getExcludeFromClassmap()[0]);
        $this->assertEquals('src-ultron-dev-classmap-exclude/', $autoload->getExcludeFromClassmap()[1]);

        $this->assertEquals('src-dev-files/', $autoload->getFiles()[0]);
        $this->assertEquals('src-ultron-dev-files/', $autoload->getFiles()[1]);

        $this->assertEquals('dev', $accompanist_base->getMinimumStability());
        $this->assertEquals(false, $accompanist_base->isPreferStable());

        $repositories = $accompanist_base->getRepositories();
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

        $this->assertEquals('composer', $repositories[5]->getType());
        $this->assertEquals('http://packages.starkenterprises.com', $repositories[5]->getUrl());
        $this->assertEquals('composer', $repositories[6]->getType());
        $this->assertEquals('https://packages.pymtechnologies.com', $repositories[6]->getUrl());
        $this->assertEquals('false', $repositories[6]->getOptions()->ssl->verify_peer);
        $this->assertEquals('vcs', $repositories[7]->getType());
        $this->assertEquals('https://github.com/banner/gamma', $repositories[7]->getUrl());
        $this->assertEquals('pear', $repositories[8]->getType());
        $this->assertEquals('https://pear.starkenterprises.com', $repositories[8]->getUrl());
        $this->assertEquals('package', $repositories[9]->getType());

        $package = $repositories[9]->getPackage();
        $this->assertEquals('stark/jarvis', $package->getName());
        $this->assertEquals('5.0.1', $package->getVersion());
        $this->assertEquals('https://jarvis.starkenterprises.net/files/jarvis-5.0.1.zip', $package->getDist()->url);
        $this->assertEquals('zip', $package->getDist()->type);
        $this->assertEquals('https://ironman.tonystark.com/svn/', $package->getSource()->url);
        $this->assertEquals('svn', $package->getSource()->type);
        $this->assertEquals('tags/jarvis_5_0_1/distribution/', $package->getSource()->reference);
    }
}
