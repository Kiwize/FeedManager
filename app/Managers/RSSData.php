<?php

namespace App\Managers;

use SimpleXMLElement;

class RSSData {
    public SimpleXMLElement $xmlObject;

    public function __construct(string $url) {
        $this->xmlObject = new SimpleXMLElement(file_get_contents($url));
    }

    /**
     * Return how many articles there are in the specified feed.
     *
     * @return integer
     */
    public function getArticleQuantity():int {
        $count = 0;
        foreach($this->xmlObject->channel->item as $item){
            $count += 1;
        }
        return $count;
    }

    public function getArticle($id) {
        return $this->xmlObject->channel->item[$id];
    }

    public function getTitle($id): string {
        return (string)$this->xmlObject->channel->item[$id]->{'title'};
    }

    public function getDescription($id): string {
        return (string)$this->xmlObject->channel->item[$id]->{'description'};
    }

    public function getLink($id): string {
        return $this->xmlObject->channel->item[$id]->link;
    }
    
    public function getGUID($id): string {
        return $this->xmlObject->channel->item[$id]->guid;
    }

    public function getPubdate($id): string {
        return $this->xmlObject->channel->item[$id]->pubDate;
    }
}