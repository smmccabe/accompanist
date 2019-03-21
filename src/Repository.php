<?php

namespace Accompanist;

class Repository
{
    protected $type = '';
    protected $url = '';
    protected $options;
    protected $package;

    public function __construct()
    {
        $this->options = new \stdClass();
        $this->package = new Package();
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function getPackage()
    {
        return $this->package;
    }

    public function setPackage(Package $package)
    {
        $this->package = $package;

        return $this;
    }

  /**
   * @param stdClass $jsonObject
   *
   * @return $this
   */
    public function loadJSONObject($jsonObject)
    {
        if (isset($jsonObject->type)) {
            $this->setType($jsonObject->type);
        }
        if (isset($jsonObject->url)) {
            $this->setUrl($jsonObject->url);
        }
        if (isset($jsonObject->options)) {
            $this->setOptions($jsonObject->options);
        }
        if (isset($jsonObject->package)) {
            $package = new Package();
            $package->setName($jsonObject->package->name)
                ->setVersion($jsonObject->package->version)
                ->setDist($jsonObject->package->dist)
                ->setSource($jsonObject->package->source);

            $this->setPackage($package);
        }

        return $this;
    }
}
