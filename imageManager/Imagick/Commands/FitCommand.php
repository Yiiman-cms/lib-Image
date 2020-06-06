<?php

namespace system\lib\imageManager\Imagick\Commands;

use system\lib\imageManager\Size;

class FitCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Crops and resized an image at the same time
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $width = $this->argument(0)->type('digit')->required()->value();
        $height = $this->argument(1)->type('digit')->value($width);
        $constraints = $this->argument(2)->type('closure')->value();
        $position = $this->argument(3)->type('string')->value('center');

        // calculate size
        $cropped = $image->getSize()->fit(new Size($width, $height), $position);
        $resized = clone $cropped;
        $resized = $resized->resize($width, $height, $constraints);

        // crop image
        $image->getCore()->cropImage(
            $cropped->width,
            $cropped->height,
            $cropped->pivot->x,
            $cropped->pivot->y
        );

        // resize image
        $image->getCore()->scaleImage($resized->getWidth(), $resized->getHeight());
        $image->getCore()->setImagePage(0,0,0,0);

        return true;
    }
}
