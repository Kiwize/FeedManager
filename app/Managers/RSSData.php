<?php

namespace App\Managers;

use ErrorException;
use Exception;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\ExceptionWrapper;
use SimpleXMLElement;
use UnexpectedValueException;

class RSSData
{
    protected object $data;
    protected string $url;
    protected int $articleCount;
    private string $dataType;

    /**
     * __construct
     *
     * @param  mixed $url
     * @return void
     */
    public function __construct(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false)
            throw new UnexpectedValueException("Invalid URL");
        $this->url = $url;
        $this->dataType = $this->parse($url);
    }

    /**
     * getArticle
     *
     * @param  int $id
     * @return object
     */
    public function getArticle(int $id): object
    {
        if ($this->dataType === "xml") {
            return $this->data->channel->item[$id];
        } else {
            return $this->data->items[$id];
        }
    }

    /**
     * getTitle
     *
     * @param  int $id
     * @return string
     */
    public function getTitle(int $id): string
    {
        if ($this->dataType === "xml") {
            return (string) $this->data->channel->item[$id]->{'title'};
        } else {
            try {
                return (string) $this->data->items[$id]->title;
            } catch (ErrorException $ex) {
                return "Missing title";
            }
        }
    }

    /**
     * getDescription
     *
     * @param  int $id
     * @return string
     */
    public function getDescription(int $id): string
    {
        if ($this->dataType === "xml") {
            return (string) $this->data->channel->item[$id]->{'description'};
        } else {
            return (string) substr($this->data->items[$id]->content_html, 0, 250) . " (...)";
        }
    }

    /**
     * getLink
     *
     * @param  int $id
     * @return string
     */
    public function getLink(int $id): string
    {
        if ($this->dataType === "xml") {
            try {
                return $this->data->channel->item[$id]->link;
            } catch (ErrorException $ex) {
                return $this->data->channel[$id]->link;
            }
        } else {
            return $this->data->items[$id]->url;
        }
    }

    /**
     * getPubdate
     *
     * @param  int $id
     * @return string
     */
    public function getPubdate(int $id): string
    {
        if ($this->dataType === "xml") {
            return $this->data->channel->item[$id]->pubDate;
        } else {
            return $this->data->items[$id]->date_published;
        }
    }

    /**
     * getArticleCount
     *
     * @return int
     */
    public function getArticleCount(): int
    {
        return $this->articleCount;
    }


    /**
     * getType
     * Return "xml" or "json"
     * @return string
     */
    public function parse(string $url): string
    {
        try {
            $this->data = new SimpleXMLElement(file_get_contents($url));
            $this->articleCount = count($this->data->channel->item);
            return "xml";
        } catch (Exception $ex) {
            // Log::warning('XML Feed parsing error !' . $ex);
        }

        $this->data = json_decode(file_get_contents($url, false));
        $this->articleCount = count($this->data->items);
        return "json";
    }

    public function getType(): string
    {
        return $this->dataType;
    }

    public function getURL(): string
    {
        return $this->url;
    }
}