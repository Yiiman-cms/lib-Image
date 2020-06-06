<?php

namespace system\lib\imageManager\Gd\Commands;

class InvertCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Inverts colors of an image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        return imagefilter($image->getCore(), IMG_FILTER_NEGATE);
    }
}
