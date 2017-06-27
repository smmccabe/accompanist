<?php

namespace Accompanist;

use JsonSerializable;

class Accompanist implements JsonSerializable {

  protected $name = '';
  protected $description = '';
  protected $type = '';
  protected $authors = [];
  protected $repositories;
  protected $config;
  protected $require;
  protected $requireDev;
  protected $conflict;
  protected $minimumStability = 'dev';
  protected $preferStable = TRUE;
  protected $autoload;
  protected $scripts;
  protected $extra;

  function __construct($name, $description = '') {
    $this->setName($name);
    $this->setDescription($description);

    $this->repositories = new \stdClass();
    $this->config = new \stdClass();
    $this->require = new \stdClass();
    $this->requireDev = new \stdClass();
    $this->conflict = new \stdClass();
    $this->autoload = new \stdClass();
    $this->scripts = new \stdClass();
    $this->extra = new \stdClass();
  }

  public function jsonSerialize() {
    return [
      'name' => $this->name,
      'description' => $this->description,
      'type' => $this->type,
      'authors' => $this->authors,
      'repositories' => $this->repositories,
      'config' => $this->config,
      'require' => $this->require,
      'require-dev' => $this->requireDev,
      'conflict' => $this->conflict,
      'minimum-stability' => $this->minimumStability,
      'prefer-stable' => $this->preferStable,
      'autoload' => $this->autoload,
      'scripts' => $this->scripts,
      'extra' => $this->extra,
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
   * @return array
   */
  public function getRepositories() {
    return $this->repositories;
  }

  /**
   * @param string $name
   * @param string $url
   */
  public function addRepository($name, $type, $url) {
    $this->repositories->$name = ['type' => $type, 'url' => $url];

    return $this;
  }

  /**
   *
   */
  public function removeRepository($name) {
    unset($this->repositories[$name]);

    return $this;
  }

  /**
   * @return array
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
   * @return array
   */
  public function getRequire() {
    return $this->require;
  }

  /**
   * @param string $require
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
   * @return array
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
   * @return array
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
   * @return array
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
   * @return array
   */
  public function getScripts() {
    return $this->scripts;
  }

  /**
   * @param array $scripts
   */
  public function addScript($name, $path) {
    $this->scripts->$name = $path;

    return $this;
  }

  /**
   * @param array $scripts
   */
  public function removeScript($name) {
    unset($this->scripts->$name);

    return $this;
  }

  /**
   * @return array
   */
  public function getExtra() {
    return $this->extra;
  }

  /**
   * @param array $extra
   */
  public function setExtra($extra) {
    $this->extra = $extra;

    return $this;
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