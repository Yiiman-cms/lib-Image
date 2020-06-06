<?php

namespace system\lib\imageManager\Gd\Commands;

class InterlaceCommand extends \system\lib\imageManager\Commands\AbstractCommand
{
    /**
     * Toggles interlaced encoding mode
     *
     * @param  \system\lib\imageManager\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $mode = $this->argument(0)->type('bool')->value(true);

        imageinterlace($image->getCore(), $mode);

        return true;
    }
}
