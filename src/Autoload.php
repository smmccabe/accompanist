<?php

namespace Accompanist;

use JsonSerializable;

class Autoload implements JsonSerializable
{
    protected $psr4;
    protected $psr0;
    protected $classmap = [];
    protected $excludeFromClassmap = [];
    protected $files = [];

    public function __construct()
    {
        $this->psr4 = new \stdClass();
        $this->psr0 = new \stdClass();
    }

  /**
   * {@inheritdoc}
   */
    public function jsonSerialize()
    {
        $json = [];

        if (!empty($this->psr4)) {
            $json['psr-4'] = $this->psr4;
        }

        if (!empty($this->psr0)) {
            $json['psr-0'] = $this->psr0;
        }

        if (!empty($this->classmap)) {
            $json['classmap'] = $this->classmap;
        }

        if (!empty($this->excludeFromClassmap)) {
            $json['exclude-form-classmap'] = $this->excludeFromClassmap;
        }

        if (!empty($this->files)) {
            $json['files'] = $this->files;
        }

        return $json;
    }

  /**
   * @param stdClass $jsonObject
   *
   * @return $this
   */
    public function loadJSONObject($jsonObject)
    {
        foreach ($jsonObject as $key => $values) {
            switch ($key) {
                case 'psr-4':
                    foreach ($values as $namespace => $path) {
                        $this->addPsr4($namespace, $path);
                    }
                    break;
                case 'psr-0':
                    foreach ($values as $namespace => $path) {
                        $this->addPsr0($namespace, $path);
                    }
                    break;
                case 'classmap':
                    foreach ($values as $path) {
                        $this->addClassmap($path);
                    }
                    break;
                case 'exclude-from-classmap':
                    foreach ($values as $path) {
                        $this->addExcludeFromClassmap($path);
                    }
                    break;
                case 'files':
                    foreach ($values as $path) {
                        $this->addFile($path);
                    }
                    break;
            }
        }

        return $this;
    }

    public function getPsr4()
    {
        return $this->psr4;
    }

    public function setPsr4($psr4)
    {
        $this->psr4 = $psr4;

        return $this;
    }

    public function addPsr4($psr4, $value)
    {
        $this->psr4->$psr4 = $value;

        return $this;
    }

    public function removePsr4($psr4)
    {
        unset($this->psr4->$psr4);

        return $this;
    }

    public function getPsr0()
    {
        return $this->psr0;
    }

    public function setPsr0($psr0)
    {
        $this->psr0 = $psr0;

        return $this;
    }

    public function addPsr0($psr0, $value, $overwrite = false)
    {
        if (!isset($this->getPsr0()->$psr0) || $overwrite) {
            $this->psr0->$psr0 = $value;
        }

        return $this;
    }

    public function removePsr0($psr0)
    {
        unset($this->getPsr0()->$psr0);

        return $this;
    }

    public function getClassmap()
    {
        return $this->classmap;
    }

    public function setClassmap($classmap)
    {
        $this->classmap = $classmap;

        return $this;
    }

    public function addClassmap($classmap)
    {
        $this->classmap[] = $classmap;

        return $this;
    }

    public function removeClassmap($classmap)
    {
        if (($key = array_search($classmap, $this->classmap)) !== false) {
            unset($this->classmap[$key]);
        }

        return $this;
    }

    public function getExcludeFromClassmap()
    {
        return $this->excludeFromClassmap;
    }

    public function setExcludeFromClassmap($exclude_from_classmap)
    {
        $this->excludeFromClassmap = $exclude_from_classmap;

        return $this;
    }

    public function addExcludeFromClassmap($exclude_from_classmap)
    {
        $this->excludeFromClassmap[] = $exclude_from_classmap;

        return $this;
    }

    public function removeExcludeFromClassmap($exclude_from_classmap)
    {
        if (($key = array_search($exclude_from_classmap, $this->excludeFromClassmap)) !== false) {
            unset($this->excludeFromClassmap[$key]);
        }

        return $this;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    public function addFile($file)
    {
        $this->files[] = $file;

        return $this;
    }

    public function removeFile($file)
    {
        if (($key = array_search($file, $this->files)) !== false) {
            unset($this->files[$key]);
        }

        return $this;
    }

    public function merge(Autoload $autoload, $overwrite = false)
    {
        foreach ($autoload->getPsr4() as $psr4 => $value) {
            $this->addPsr4($psr4, $value, $overwrite);
        }
        foreach ($autoload->getPsr0() as $psr0 => $value) {
            $this->addPsr0($psr0, $value, $overwrite);
        }
        foreach ($autoload->getClassmap() as $classmap) {
            $this->addClassmap($classmap);
        }
        foreach ($autoload->getExcludeFromClassmap() as $classmap) {
            $this->addExcludeFromClassmap($classmap);
        }
        foreach ($autoload->getFiles() as $file) {
            $this->addFile($file);
        }
    }
}
