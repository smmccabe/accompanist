<?php

namespace Accompanist;

use JsonSerializable;

class Accompanist implements JsonSerializable {

  protected $name = '';
  protected $description = '';
  protected $version = '';
  protected $type = '';
  protected $keywords = '';
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
  protected $preferStable = TRUE;
  protected $repositories;
  protected $config;
  protected $scripts;
  protected $extra;
  protected $bin;
  protected $archive;
  protected $nonFeatureBranches;
  protected $featureBranches;

  function __construct($name, $description = '') {
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
  }

  /**
   * {@inheritdoc}
   */
  public function jsonSerialize() {
    return [
      'name' => $this->name,
      'description' => $this->description,
      'version' => $this->version,
      'type' => $this->type,
      'keywords' => $this->keywords,
      'homepage' => $this->homepage,
      'time' => $this->time,
      'license' => $this->license,
      'authors' => $this->authors,
      'support' => $this->support,
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
      'bin' => $this->bin,
      'archive' => $this->archive,
      'non-feature-branches' => $this->nonFeatureBranches,
      'feature-braches' => $this->featureBranches,
    ];
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * @return string
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription($description) {
    $this->description = $description;

    return $this;
  }

  /**
   * @return string
   */
  public function getVersion() {
    return $this->version;
  }

  /**
   * @param string $version
   */
  public function setVersion($version) {
    $this->version = $version;

    return $this;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @param string $type
   */
  public function setType($type) {
    $this->type = $type;

    return $this;
  }

  /**
   * @return string
   */
  public function getKeywords() {
    return $this->keywords;
  }

  /**
   * @param string $keywords
   */
  public function setKeywords($keywords) {
    $this->keywords = $keywords;
  }

  /**
   * @return string
   */
  public function getHomepage() {
    return $this->homepage;
  }

  /**
   * @param string $homepage
   */
  public function setHomepage($homepage) {
    $this->homepage = $homepage;
  }

  /**
   * @return string
   */
  public function getTime() {
    return $this->time;
  }

  /**
   * @param string $time
   */
  public function setTime($time) {
    $this->time = $time;
  }

  /**
   * @return string
   */
  public function getLicense() {
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
   */
  public function setLicense($license) {
    $this->license = $license;
  }

  /**
   * @return array
   */
  public function getAuthors() {
    return $this->authors;
  }

  /**
   * @param array $authors
   */
  public function setAuthors($authors) {
    $this->authors = $authors;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getSupport() {
    return $this->support;
  }

  /**
   * @param mixed $support
   */
  public function setSupport($support) {
    $this->support = $support;
  }

  /**
   * @return \stdClass
   */
  public function getRequire() {
    return $this->require;
  }

  /**
   * @param string $require
   * @param string $version
   */
  public function addRequire($require, $version = '*') {
    $this->require->$require = $version;

    return $this;
  }

  /**
   * @param string $require
   */
  public function removeRequire($require) {
    unset($this->require->$require);

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getRequireDev() {
    return $this->requireDev;
  }

  /**
   * @param string $require
   */
  public function addRequireDev($require, $version = '*') {
    $this->requireDev->$require = $version;

    return $this;
  }

  /**
   * @param string $require
   */
  public function removeRequireDev($require) {
    unset($this->requireDev->$require);

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getConflict() {
    return $this->conflict;
  }

  /**
   * @param array $conflict
   */
  public function setConflict($conflict) {
    $this->conflict = $conflict;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getReplace() {
    return $this->replace;
  }

  /**
   * @param mixed $replace
   */
  public function setReplace($replace) {
    $this->replace = $replace;
  }

  /**
   * @return mixed
   */
  public function getProvide() {
    return $this->provide;
  }

  /**
   * @param mixed $provide
   */
  public function setProvide($provide) {
    $this->provide = $provide;
  }

  /**
   * @return mixed
   */
  public function getSuggest() {
    return $this->suggest;
  }

  /**
   * @param mixed $suggest
   */
  public function setSuggest($suggest) {
    $this->suggest = $suggest;
  }

  /**
   * @return string
   */
  public function getMinimumStability() {
    return $this->minimumStability;
  }

  /**
   * @param string $minimumStability
   */
  public function setMinimumStability($minimumStability) {
    $this->minimumStability = $minimumStability;

    return $this;
  }

  /**
   * @return bool
   */
  public function isPreferStable() {
    return $this->preferStable;
  }

  /**
   * @param bool $preferStable
   */
  public function setPreferStable($preferStable) {
    $this->preferStable = $preferStable;

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getAutoload() {
    return $this->autoload;
  }

  /**
   * @param string $name
   * @param mixed $value
   */
  public function addAutoload($name, $value) {
    $this->autoload->$name = $value;

    return $this;
  }

  /**
   * @param string $name
   *
   * @return $this
   */
  public function removeAutoload($name) {
    unset($this->autoload->$name);

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getAutoloadDev() {
    return $this->autoloadDev;
  }

  /**
   * @param string $name
   * @param mixed $value
   */
  public function addAutoloadDev($name, $value) {
    $this->autoloadDev->$name = $value;

    return $this;
  }

  /**
   * @param string $name
   *
   * @return \Accompanist\Accompanist
   */
  public function removeAutoloadDev($name) {
    unset($this->autoloadDev->$name);

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getRepositories() {
    return $this->repositories;
  }

  /**
   * @param string $name
   * @param string $type
   * @param string $url
   *
   * @return \Accompanist\Accompanist
   */
  public function addRepository($name, $type, $url) {
    $this->repositories->$name = ['type' => $type, 'url' => $url];

    return $this;
  }

  /**
   * @param string $name
   *
   * @return \Accompanist\Accompanist
   */
  public function removeRepository($name) {
    unset($this->repositories[$name]);

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * @param array $config
   */
  public function setConfig($config) {
    $this->config = $config;

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getScripts() {
    return $this->scripts;
  }

  /**
   * @param string $name
   * @param string $path
   *
   * @return \Accompanist\Accompanist
   */
  public function addScript($name, $path) {
    $this->scripts->$name = $path;

    return $this;
  }

  /**
   * @param string $name
   *
   * @return \Accompanist\Accompanist
   */
  public function removeScript($name) {
    unset($this->scripts->$name);

    return $this;
  }

  /**
   * @return \stdClass
   */
  public function getExtra() {
    return $this->extra;
  }

  /**
   * @param \stdClass $extra
   *
   * @return \Accompanist\Accompanist
   */
  public function setExtra($extra) {
    $this->extra = $extra;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getBin() {
    return $this->bin;
  }

  /**
   * @param mixed $bin
   */
  public function setBin($bin) {
    $this->bin = $bin;
  }

  /**
   * @return mixed
   */
  public function getArchive() {
    return $this->archive;
  }

  /**
   * @param mixed $archive
   */
  public function setArchive($archive) {
    $this->archive = $archive;
  }

  /**
   * @return mixed
   */
  public function getNonFeatureBranches() {
    return $this->nonFeatureBranches;
  }

  /**
   * @param mixed $nonFeatureBranches
   */
  public function setNonFeatureBranches($nonFeatureBranches) {
    $this->nonFeatureBranches = $nonFeatureBranches;
  }

  /**
   * @return mixed
   */
  public function getFeatureBranches() {
    return $this->featureBranches;
  }

  /**
   * @param mixed $featureBranches
   */
  public function setFeatureBranches($featureBranches) {
    $this->featureBranches = $featureBranches;
  }

  function generateJSON() {
    return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  }

  /**
   * @param string $folder
   */
  function generate($folder = '') {
    if(!empty($folder)) {
      @mkdir($folder);
    }

    file_put_contents($folder . '/composer.json', $this->generateJSON());
  }
}