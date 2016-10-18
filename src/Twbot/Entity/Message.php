<?php

namespace Twbot\Entity;


class Message
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $tags = $this->getTags();
        $tagString = '';

        foreach($tags as $tag){
            $tagString .= '#' . $tag;
        }

        return $this->getMessage() . ' ' . $tagString;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param string $tag
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;
        $this->tags = array_filter($this->tags);
    }

}