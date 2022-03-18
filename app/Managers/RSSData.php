<?php

namespace App\Managers;

use SimpleXMLElement;

class RSSData
{
    protected SimpleXMLElement $xmlObject;
    protected string $url;
    protected int $articleCount;

    public function __construct(string $url)
    {
        $this->url = $url;  
        $this->xmlObject = new SimpleXMLElement(file_get_contents($url));
        $this->articleCount = count($this->xmlObject->channel->item);
    }

    public function getArticle($id): Object
    {
        return $this->xmlObject->channel->item[$id];
    }

    public function getTitle($id): string
    {
        return (string)$this->xmlObject->channel->item[$id]->{'title'};
    }

    public function getDescription($id): string
    {
        return (string)$this->xmlObject->channel->item[$id]->{'description'};
    }

    public function getLink($id): string
    {
        return $this->xmlObject->channel->item[$id]->link;
    }

    public function getGUID($id): string
    {
        return $this->xmlObject->channel->item[$id]->guid;
    }

    public function getPubdate($id): string
    {
        return $this->xmlObject->channel->item[$id]->pubDate;
    }


    //Getters
    public function getURL(): string
    {
        return $this->url;
    }

    public function getXMLObject(): SimpleXMLElement
    {
        return $this->xmlObject;
    }

    public function getArticleCount(): int
    {
        return $this->articleCount;
    }
}
