<?php

namespace system\lib\imageManager\Filters;

interface FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return \system\lib\imageManager\Image
     */
    public function applyFilter(\system\lib\imageManager\Image $image);
}
