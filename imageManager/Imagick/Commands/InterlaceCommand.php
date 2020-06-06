<?php

namespace system\lib\imageManager\Imagick\Commands;

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

        if ($mode) {
            $mode = \Imagick::INTERLACE_LINE;
        } else {
            $mode = \Imagick::INTERLACE_NO;
        }

        $image->getCore()->setInterlaceScheme($mode);

        return true;
    }
}
