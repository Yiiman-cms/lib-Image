<?php

namespace system\lib\imageManager\Gd\Commands;

class ContrastCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Changes contrast of image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $level = $this->argument(0)->between(-100, 100)->required()->value();

        return imagefilter($image->getCore(), IMG_FILTER_CONTRAST, ($level * -1));
    }
}
