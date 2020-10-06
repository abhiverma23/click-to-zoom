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
            'enabled' => true,
            'provider' => 1, // Default => 1, zooming => 2
            'listenFor' => 1, // Attribute => 1, Class => 2
            'listenForAttribute' => 'click-to-zoom',
            'zoomingConfiguration' => "bgColor: 'black', bgOpacity: '0.96', zIndex: 9",
            'enableFor' => 2, // All place => 1, Pages => 2
        );
    }

    public function form()
    {
        global $L;

        $html  = '<div class="alert alert-primary" role="alert">';
        $html .= $this->description();
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('Do you want to use click to zoom?').'</label>';
        $html .= '<select name="enabled">';
        $html .= '<option value="true" '.($this->getValue('enabled')===true?'selected':'').'>'.$L->get('Yes').'</option>';
        $html .= '<option value="false" '.($this->getValue('enabled')===false?'selected':'').'>'.$L->get('No').'</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('Which provider you want use?').'</label>';
        $html .= '<select name="provider">';
        $html .= '<option value="1" '.($this->getValue('provider')===1?'selected':'').'>'.$L->get('Default').'</option>';
        $html .= '<option value="2" '.($this->getValue('provider')===2?'selected':'').'>'.$L->get('Zooming').'</option>';
        //$html .= '<option value="3" '.($this->getValue('corner')===3?'selected':'').'>'.$L->get('Bottom Left').'</option>';
        //$html .= '<option value="4" '.($this->getValue('corner')===4?'selected':'').'>'.$L->get('Bottom Right').'</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('What type of listener you want to use?').'</label>';
        $html .= '<select name="listenFor">';
        $html .= '<option value="1" '.($this->getValue('listenFor')===1?'selected':'').'>'.$L->get('When attribute is present').'</option>';
        $html .= '<option value="2" disabled '.($this->getValue('listenFor')===2?'selected':'').'>'.$L->get('When class is present').'</option>';
        //$html .= '<option value="3" '.($this->getValue('direction')===3?'selected':'').'>'.$L->get('Up').'</option>';
        //$html .= '<option value="4" '.($this->getValue('direction')===4?'selected':'').'>'.$L->get('Down').'</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('For which attribute presence you want image zooming?').'</label>';
        $html .= '<input name="listenForAttribute" id="listenForAttribute" type="text" placeholder="'.$L->get('Mention attribute name for which zooming will listen for click.').'" value="'.$this->getValue('listenForAttribute').'">';
        //$html .= '<p>'.$L->get('some tool tip if you like to mention').'</p>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('For zooming provider, mention the configuration?').'</label>';
        $html .= '<input name="zoomingConfiguration" id="zoomingConfiguration" type="text" placeholder="'.$L->get('Optional: mention the configuration to customize zooming.').'" value="'.$this->getValue('zoomingConfiguration').'">';
        $html .= '<a><a href="https://kingdido999.github.io/zooming/docs/#/">'.$L->get('Click here to get more details').'</a></p>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('For which place of your website you want it to work?').'</label>';
        $html .= '<select name="enableFor">';
        $html .= '<option value="1" '.($this->getValue('enableFor')===1?'selected':'').'>'.$L->get('All Places').'</option>';
        $html .= '<option value="2" '.($this->getValue('enableFor')===2?'selected':'').'>'.$L->get('Page').'</option>';
        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

    public function siteHead()
    {
        global $L, $url, $site, $page, $users, $login, $security;
        $html = '';
        if ($this->getValue('enabled')) {
            if ($this->getValue('enableFor') == 1 || ($this->getValue('enableFor') == 2 && $url->whereAmI() == 'page')) {
                if ($this->getValue('provider') == 1) {
                    $html .= '<link href="' . HTML_PATH_PLUGINS . 'click-to-zoom/css/style.css" rel="stylesheet">';
                }
            }
        }
        return $html;
    }

    public function siteBodyEnd()
    {
        global $L, $url, $site, $page, $users, $login, $security;

        $html = '';

        if ($this->getValue('enabled')) {
            if ($this->getValue('enableFor') == 1 || ($this->getValue('enableFor') == 2 && $url->whereAmI() == 'page')) {
                if ($this->getValue('provider') == 1) {
                    $html .= PHP_EOL . '<script src="' . HTML_PATH_PLUGINS . 'click-to-zoom/js/script.js"></script>' . PHP_EOL;
                    $config = '';
                    if ($this->getValue('listenFor') == 1) {
                        $config = "attribute: '" . $this->getValue('listenForAttribute') . "'";
                    } else if ($this->getValue('listenFor') == 2) {
                        $config = "class: '" . $this->getValue('listenForAttribute') . "'";
                    }
                    $html .= '<script>
                            new ClickToZoom({' . $config . '}).init();
                            </script>';
                } else if ($this->getValue('provider') == 2) {
                    $html .= '<script src="https://unpkg.com/zooming/build/zooming.min.js"></script>';
                    $html .= '<script> document.addEventListener("DOMContentLoaded", function () {
                            const zooming = new Zooming({' . $this->getValue('zoomingConfiguration') . '}),
                            imgs = document.querySelectorAll("img[' . $this->getValue('listenForAttribute') . ']");
                            imgs.forEach(element => {
                                zooming.listen(element);
                            });
                        }); </script>';

                }
            }
        }
        return $html;
    }

}

?>