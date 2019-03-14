<?php

namespace Accompanist;

class Support
{
    protected $email = '';
    protected $issues = '';
    protected $forum = '';
    protected $wiki = '';
    protected $irc = '';
    protected $source = '';
    protected $docs = '';
    protected $rss = '';
    protected $chat = '';

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function mergeEmail($email, $overwrite)
    {
        if ($this->email == '' || $overwrite) {
            $this->setEmail($email);
        }

        return $this;
    }

    public function getIssues()
    {
        return $this->issues;
    }

    public function setIssues($issues)
    {
        $this->issues = $issues;

        return $this;
    }

    public function mergeIssues($issues, $overwrite)
    {
        if ($this->issues == '' || $overwrite) {
            $this->setIssues($issues);
        }

        return $this;
    }

    public function getForum()
    {
        return $this->forum;
    }

    public function setForum($forum)
    {
        $this->forum = $forum;

        return $this;
    }

    public function mergeForum($forum, $overwrite)
    {
        if ($this->forum == '' || $overwrite) {
            $this->setForum($forum);
        }

        return $this;
    }

    public function getWiki()
    {
        return $this->wiki;
    }

    public function setWiki($wiki)
    {
        $this->wiki = $wiki;

        return $this;
    }

    public function mergeWiki($wiki, $overwrite)
    {
        if ($this->wiki == '' || $overwrite) {
            $this->setWiki($wiki);
        }

        return $this;
    }

    public function getIrc()
    {
        return $this->irc;
    }

    public function setIrc($irc)
    {
        $this->irc = $irc;

        return $this;
    }

    public function mergeIrc($irc, $overwrite)
    {
        if ($this->irc == '' || $overwrite) {
            $this->setIrc($irc);
        }

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

    public function mergeEmail($email, $overwrite)
    {
        if ($this->email == '' || $overwrite) {
            $this->setEmail($email);
        }

        return $this;
    }

    public function getDocs()
    {
        return $this->docs;
    }

    public function setDocs($docs)
    {
        $this->docs = $docs;

        return $this;
    }

    public function mergeDocs($docs, $overwrite)
    {
        if ($this->docs == '' || $overwrite) {
            $this->setDocs($docs);
        }

        return $this;
    }

    public function getRss()
    {
        return $this->rss;
    }

    public function setRss($rss)
    {
        $this->rss = $rss;

        return $this;
    }

    public function mergeRss($rss, $overwrite)
    {
        if ($this->rss == '' || $overwrite) {
            $this->setRss($rss);
        }

        return $this;
    }

    public function getChat()
    {
        return $this->chat;
    }

    public function setChat($chat)
    {
        $this->chat = $chat;

        return $this;
    }

    public function mergeChat($chat, $overwrite)
    {
        if ($this->chat == '' || $overwrite) {
            $this->setChat($chat);
        }

        return $this;
    }

    public function merge(Support $support, $overwrite)
    {
        $this->mergeEmail($support->getEmail(), $overwrite);
        $this->mergeIssues($support->getIssues(), $overwrite);
        $this->mergeForum($support->getForum(), $overwrite);
        $this->mergeWiki($support->getWiki(), $overwrite);
        $this->mergeIrc($support->getIrc(), $overwrite);
        $this->mergeSources($support->getSources(), $overwrite);
        $this->mergeDocs($support->getDocs(), $overwrite);
        $this->mergeRss($support->mergeRss(), $overwrite);
        $this->mergeChat($support->chat(), $overwrite);

        return $this;
    }
}
