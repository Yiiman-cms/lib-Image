<?php

namespace system\lib\imageManager\Gd\Commands;

use system\lib\imageManager\Size;

class GetSizeCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Reads size of given image instance in pixels
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $this->setOutput(new Size(
            imagesx($image->getCore()),
            imagesy($image->getCore())
        ));

        return true;
    }
}
