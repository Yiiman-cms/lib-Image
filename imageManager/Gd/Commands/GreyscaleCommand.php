<?php

namespace system\lib\imageManager\Gd\Commands;

class GreyscaleCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Turns an image into a greyscale version
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        return imagefilter($image->getCore(), IMG_FILTER_GRAYSCALE);
    }
}
