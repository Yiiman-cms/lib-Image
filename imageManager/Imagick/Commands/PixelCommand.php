<?php

namespace system\lib\imageManager\Imagick\Commands;

use system\lib\imageManager\Imagick\Color;

class PixelCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Draws one pixel to a given image
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $color = $this->argument(0)->required()->value();
        $color = new Color($color);
        $x = $this->argument(1)->type('digit')->required()->value();
        $y = $this->argument(2)->type('digit')->required()->value();

        // prepare pixel
        $draw = new \ImagickDraw;
        $draw->setFillColor($color->getPixel());
        $draw->point($x, $y);

        // apply pixel
        return $image->getCore()->drawImage($draw);
    }
}
