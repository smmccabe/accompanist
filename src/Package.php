<?php

namespace Accompanist;

class Package
{
    protected $name = '';
    protected $version = '';
    protected $dist;
    protected $source;

    public function __construct()
    {
        $this->dist = new \stdClass();
        $this->source = new \stdClass();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getDist()
    {
        return $this->dist;
    }

    public function setDist($dist)
    {
        $this->dist = $dist;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }
}
