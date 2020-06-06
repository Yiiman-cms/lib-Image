<?php

namespace system\lib\imageManager\Imagick\Commands;

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
        return $image->getCore()->modulateImage(100, 0, 100);
    }
}
