<?php

namespace Accompanist;

use JsonSerializable;

class Accompanist implements JsonSerializable
{

    protected $name = '';
    protected $description = '';
    protected $version = '';
    protected $type = '';
    protected $keywords = [];
    protected $homepage = '';
    protected $time = '';
    protected $license = '';
    protected $authors = [];
    protected $support;
    protected $require;
    protected $requireDev;
    protected $conflict;
    protected $replace;
    protected $provide;
    protected $suggest;
    protected $autoload;
    protected $autoloadDev;
    protected $minimumStability = 'dev';
    protected $preferStable = true;
    protected $repositories;
    protected $config;
    protected $scripts;
    protected $extra;
    protected $bin = [];
    protected $archive;
    protected $nonFeatureBranches = [];
    protected $featureBranches = [];

    public function __construct($name, $description = '')
    {
        $this->setName($name);
        $this->setDescription($description);

        $this->require = new \stdClass();
        $this->requireDev = new \stdClass();
        $this->conflict = new \stdClass();
        $this->replace = new \stdClass();
        $this->provide = new \stdClass();
        $this->suggest = new \stdClass();
        $this->autoload = new \stdClass();
        $this->autoloadDev = new \stdClass();
        $this->repositories = new \stdClass();
        $this->config = new \stdClass();
        $this->scripts = new \stdClass();
        $this->extra = new \stdClass();
        $this->archive = new \stdClass();
        $this->support = new \stdClass();
    }

  /**
   * {@inheritdoc}
   */
    public function jsonSerialize()
    {
        $json = [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'require' => $this->require,
            'require-dev' => $this->requireDev,
            'conflict' => $this->conflict,
            'replace' => $this->replace,
            'provide' => $this->provide,
            'suggest' => $this->suggest,
            'autoload' => $this->autoload,
            'autoload-dev' => $this->autoloadDev,
            'minimum-stability' => $this->minimumStability,
            'prefer-stable' => $this->preferStable,
            'repositories' => $this->repositories,
            'config' => $this->config,
            'scripts' => $this->scripts,
            'extra' => $this->extra,
        ];

        if (!empty($this->version)) {
            $json['version'] = $this->version;
        }

        if (!empty($this->keywords)) {
            $json['keywords'] = $this->keywords;
        }

        if (!empty($this->homepage)) {
            $json['homepage'] = $this->homepage;
        }

        if (!empty($this->time)) {
            $json['time'] = $this->time;
        }

        if (!empty($this->license)) {
            $json['license'] = $this->license;
        }

        if (!empty($this->authors)) {
            $json['authors'] = $this->authors;
        }

        if (!empty($this->support)) {
            $json['support'] = $this->support;
        }

        if (!empty($this->extra)) {
            $json['extra'] = $this->extra;
        }

        if (!empty($this->bin)) {
            $json['bin'] = $this->bin;
        }

        if (!empty($this->archive)) {
            $json['archive'] = $this->archive;
        }

        if (!empty($this->nonFeatureBranches)) {
            $json['non-feature-branches'] = $this->nonFeatureBranches;
        }

        if (!empty($this->featureBranches)) {
            $json['feature-braches'] = $this->featureBranches;
        }

        return $json;
    }

  /**
   * @return string
   */
    public function getName()
    {
        return $this->name;
    }

  /**
   * @param string $name
   *
   * @return $this
   */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

  /**
   * @return string
   */
    public function getDescription()
    {
        return $this->description;
    }

  /**
   * @param string $description
   *
   * @return $this
   */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

  /**
   * @return string
   */
    public function getVersion()
    {
        return $this->version;
    }

  /**
   * @param string $version
   *
   * @return $this
   */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

  /**
   * @return string
   */
    public function getType()
    {
        return $this->type;
    }

  /**
   * @param string $type
   *
   * @return $this
   */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

  /**
   * @return string
   */
    public function getKeywords()
    {
        return $this->keywords;
    }

  /**
   * @param string $keyword
   *
   * @return $this
   */
    public function addKeyword($keyword)
    {
        $this->keywords[$keyword] = $keyword;

        return $this;
    }

  /**
   * @param string $keyword
   *
   * @return $this
   */
    public function removeKeyword($keyword)
    {
        unset($this->keywords[$keyword]);

        return $this;
    }

  /**
   * @return string
   */
    public function getHomepage()
    {
        return $this->homepage;
    }

  /**
   * @param string $homepage
   *
   * @return $this
   */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

  /**
   * @return string
   */
    public function getTime()
    {
        return $this->time;
    }

  /**
   * @param string $time
   *
   * @return $this
   */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

  /**
   * @return string
   */
    public function getLicense()
    {
        return $this->license;
    }

  /**
   * @param string $license
   *   Usually the license will be one of
   *     Apache-2.0
   *     BSD-2-Clause
   *     BSD-3-Clause
   *     BSD-4-Clause
   *     GPL-2.0
   *     GPL-3.0
   *     LGPL-2.1
   *     LGPL-3.0
   *     MIT
   *   And the composer spec request you stick to the above formatting.
   *
   * @return $this
   */
    public function setLicense($license)
    {
        $this->license = $license;

        return $this;
    }

  /**
   * @return array
   */
    public function getAuthors()
    {
        return $this->authors;
    }

  /**
   * @param array $authors
   *
   * @return $this
   */
    public function setAuthors($authors)
    {
        $this->authors = $authors;

        return $this;
    }

  /**
   * @return mixed
   */
    public function getSupport()
    {
        return $this->support;
    }

  /**
   * @param mixed $support
   *
   * @return $this
   */
    public function setSupport($support)
    {
        $this->support = $support;

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getRequire()
    {
        return $this->require;
    }

  /**
   * @param string $require
   * @param string $version
   *
   * @return $this
   */
    public function addRequire($require, $version = '*')
    {
        $this->require->$require = $version;

        return $this;
    }

  /**
   * @param string $require
   *
   * @return $this
   */
    public function removeRequire($require)
    {
        unset($this->require->$require);

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getRequireDev()
    {
        return $this->requireDev;
    }

  /**
   * @param string $require
   * @param string $version
   *
   * @return $this
   */
    public function addRequireDev($require, $version = '*')
    {
        $this->requireDev->$require = $version;

        return $this;
    }

  /**
   * @param string $require
   *
   * @return $this
   */
    public function removeRequireDev($require)
    {
        unset($this->requireDev->$require);

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getConflict()
    {
        return $this->conflict;
    }

  /**
   * @param array $conflict
   *
   * @return $this
   */
    public function setConflict($conflict)
    {
        $this->conflict = $conflict;

        return $this;
    }

  /**
   * @return mixed
   */
    public function getReplace()
    {
        return $this->replace;
    }

  /**
   * @param mixed $replace
   *
   * @return $this
   */
    public function setReplace($replace)
    {
        $this->replace = $replace;

        return $this;
    }

  /**
   * @return mixed
   */
    public function getProvide()
    {
        return $this->provide;
    }

  /**
   * @param mixed $provide
   *
   * @return $this
   */
    public function setProvide($provide)
    {
        $this->provide = $provide;

        return $this;
    }

  /**
   * @return mixed
   */
    public function getSuggest()
    {
        return $this->suggest;
    }

  /**
   * @param mixed $suggest
   *
   * @return $this
   */
    public function setSuggest($suggest)
    {
        $this->suggest = $suggest;

        return $this;
    }

  /**
   * @return string
   */
    public function getMinimumStability()
    {
        return $this->minimumStability;
    }

  /**
   * @param string $minimum_stability
   *   Must be one of
   *     dev
   *     alpha
   *     beta
   *     RC
   *     stable
   *
   * @return $this
   *
   * @throws \Exception
   */
    public function setMinimumStability($minimum_stability)
    {
        $acceptable_values = ['dev', 'alpha', 'beta', 'RC', 'stable'];

        if (in_array($minimum_stability, $acceptable_values)) {
            $this->minimumStability = $minimum_stability;
        } else {
            throw new \Exception('Minimum Stability must be one of dev, alpha, beta, RC or stable');
        }

        return $this;
    }

  /**
   * @return bool
   */
    public function isPreferStable()
    {
        return $this->preferStable;
    }

  /**
   * @param bool $prefer_stable
   *
   * @return $this
   */
    public function setPreferStable($prefer_stable)
    {
        $this->preferStable = $prefer_stable;

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getAutoload()
    {
        return $this->autoload;
    }

  /**
   * @param \stdClass $value
   *
   * @return $this
   */
    public function setAutoload($value)
    {
        $this->autoload = $value;

        return $this;
    }

  /**
   * @param string $name
   * @param mixed $value
   *
   * @return $this
   */
    public function addAutoload($name, $value)
    {
        $this->autoload->$name = $value;

        return $this;
    }

  /**
   * @param string $name
   *
   * @return $this
   */
    public function removeAutoload($name)
    {
        unset($this->autoload->$name);

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getAutoloadDev()
    {
        return $this->autoloadDev;
    }

  /**
   * @param string $name
   * @param mixed $value
   *
   * @return $this
   */
    public function addAutoloadDev($name, $value)
    {
        $this->autoloadDev->$name = $value;

        return $this;
    }

  /**
   * @param string $name
   *
   * @return $this
   */
    public function removeAutoloadDev($name)
    {
        unset($this->autoloadDev->$name);

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getRepositories()
    {
        return $this->repositories;
    }

  /**
   * @param string $name
   * @param string $type
   * @param string $url
   *
   * @return $this
   */
    public function addRepository($name, $value)
    {
        $this->repositories->$name = $value;

        return $this;
    }

  /**
   * @param string $name
   *
   * @return $this
   */
    public function removeRepository($name)
    {
        unset($this->repositories[$name]);

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getConfig()
    {
        return $this->config;
    }

  /**
   * @param array $config
   *
   * @return $this
   */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getScripts()
    {
        return $this->scripts;
    }

  /**
   * @param string $name
   * @param string $path
   *
   * @return $this
   */
    public function addScript($name, $path)
    {
        if (isset($this->scripts->$name)) {
            $this->scripts->$name[] = $path;
        } else {
            $this->scripts->$name = [$path];
        }

        return $this;
    }

  /**
   * @param string $name
   *
   * @return $this
   */
    public function removeScript($name)
    {
        unset($this->scripts->$name);

        return $this;
    }

  /**
   * @return \stdClass
   */
    public function getExtra()
    {
        return $this->extra;
    }

  /**
   * @param \stdClass $extra
   *
   * @return $this
   */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

  /**
   * @param string $extra
   * @param mixed $value
   *
   * @return $this
   */
    public function addExtra($extra, $value)
    {
        if (isset($this->extra->$extra) && is_array($this->extra->$extra)) {
            array_merge($this->extra->$extra, $value);
        } else {
            $this->extra->$extra = $value;
        }

        return $this;
    }

  /**
   * @param string $extra
   *
   * @return $this
   */
    public function removeExtra($extra)
    {
        unset($this->extra->$extra);

        return $this;
    }

  /**
   * @return mixed
   */
    public function getBin()
    {
        return $this->bin;
    }

  /**
   * @param mixed $bin
   *
   * @return $this
   */
    public function setBin($bin)
    {
        $this->bin = $bin;

        return $this;
    }

  /**
   * @return mixed
   */
    public function getArchive()
    {
        return $this->archive;
    }

  /**
   * @param mixed $archive
   *
   * @return $this
   */
    public function setArchive($archive)
    {
        $this->archive = $archive;

        return $this;
    }

  /**
   * @return mixed
   */
    public function getNonFeatureBranches()
    {
        return $this->nonFeatureBranches;
    }

  /**
   * @param mixed $nonFeatureBranches
   *
   * @return $this
   */
    public function setNonFeatureBranches($nonFeatureBranches)
    {
        $this->nonFeatureBranches = $nonFeatureBranches;

        return $this;
    }

  /**
   * @return mixed
   */
    public function getFeatureBranches()
    {
        return $this->featureBranches;
    }

  /**
   * @param mixed $featureBranches
   *
   * @return $this
   */
    public function setFeatureBranches($featureBranches)
    {
        $this->featureBranches = $featureBranches;

        return $this;
    }

    public function generateJSON()
    {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

  /**
   * @param string $location
   *
   * @throws \Exception
   */
    public function generate($location)
    {
        if (!empty($location)) {
            @mkdir($location);

            if (substr($location, -1) != '/') {
                $location .= '/';
            }

            file_put_contents($location . 'composer.json', $this->generateJSON());
        } else {
            throw new \Exception('A location must be provided when generating a composer.json file');
        }
    }

   /**
     * @param $filename
     */
    public function writeToFile($filename)
    {
        file_put_contents($filename, $this->generateJSON());
    }

  /**
   * @param string $url
   *
   * @return $this
   * @throws \Exception
   */
    public function loadFromFile($url)
    {
        $jsonString = file_get_contents($url);

        return $this->loadJSONString($jsonString);
    }

  /**
   * @param $jsonString
   *
   * @return $this
   * @throws \Exception
   */
    public function loadJSONString($jsonString)
    {
        $jsonData = json_decode($jsonString);
        foreach ($jsonData as $key => $values) {
            switch ($key) {
                case 'require':
                    foreach ($values as $require => $version) {
                        $this->addRequire($require, $version);
                    }
                    break;
                case 'require-dev':
                    foreach ($values as $require => $version) {
                        $this->addRequireDev($require, $version);
                    }
                    break;
                case 'repositories':
                    foreach ($values as $repo => $value) {
                        if (is_numeric($repo)) {
                            $repo = $this->getName() . '_' . $repo;
                        }
                        $this->addRepository($repo, $value);
                    }
                    break;
                case 'scripts':
                    foreach ($values as $name => $path) {
                        if (is_array($path)) {
                            foreach ($path as $value) {
                                $this->addScript($name, $value);
                            }
                        } else {
                            $this->addScript($name, $path);
                        }
                    }
                    break;
                case 'extra':
                    $this->setExtra($values);
                    break;
                case 'config':
                    $this->setConfig($values);
                    break;
                case 'autoload':
                    $this->setAutoload($values);
                    break;
                case 'authors':
                    $this->setAuthors($values);
                    break;
                case 'name':
                    $this->setName($values);
                    break;
                case 'license':
                    $this->setLicense($values);
                    break;
                case 'description':
                    $this->setDescription($values);
                    break;
                case 'minimum-stability':
                    $this->setMinimumStability($values);
                    break;
            }
        }

        return $this;
    }
}
