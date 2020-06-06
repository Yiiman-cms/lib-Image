<?php

namespace system\lib\imageManager\Filters;

class DemoFilter implements FilterInterface
{
    /**
     * Default size of filter effects
     */
    const DEFAULT_SIZE = 10;

    /**
     * Size of filter effects
     *
     * @var int
     */
    private $size;

    /**
     * Creates new instance of filter
     *
     * @param int $size
     */
    public function __construct($size = null)
    {
        $this->size = is_numeric($size) ? intval($size) : self::DEFAULT_SIZE;
    }

    /**
     * Applies filter effects to given image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return \system\lib\imageManager\Image
     */
    public function applyFilter(\system\lib\imageManager\Image $image)
    {
        $image->pixelate($this->size);
        $image->greyscale();

        return $image;
    }
}
