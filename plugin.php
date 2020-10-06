<?php

class pluginClickToZoom extends Plugin
{
    /*public function siteSidebar()
    {
        echo 'Click To Zoom Is Enabled';
    }*/

    public function init()
    {
        global $L;

        // Fields and default values for the database of this plugin
        $this->dbFields = array(
            'enable' => true,
            'provider' => 1, // Default => 1, zooming => 2
            'enableFor' => 1, // Attribute => 1, Class => 2
            'enableForAttribute' => 'click-to-zoom',
            'zoomingConfiguration' => ''
        );
    }

    public function siteHead()
    {
        $html = '<link href="' . HTML_PATH_PLUGINS . 'click-to-zoom/css/style.css" rel="stylesheet">';
        return $html;
    }

    public function siteBodyEnd()
    {
        $html = PHP_EOL . '<script src="' . HTML_PATH_PLUGINS . 'click-to-zoom/js/script.js"></script>' . PHP_EOL;
        return $html;
    }

}

?>