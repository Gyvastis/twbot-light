<?php

namespace Twbot\Entity;


class Image
{
    /**
     * @var string
     */
    protected $imagePath;

    /**
     * Image constructor.
     * @param string $imagePath
     */
    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }
}