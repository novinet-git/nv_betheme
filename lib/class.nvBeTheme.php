<?php class nvBeTheme
{


    public function __construct()
    {
        $this->addon = rex_addon::get('nv_betheme');
        $this->install();
    }

    public function install()
    {
        if (!file_exists($this->addon->getAssetsPath("backend.css"))) {
            $this->generateFiles();
        }
    }

    public function generateFiles()
    {

        $sStyle = $this->addon->getConfig("style") ?: "light";

        $iRand = rand(0, 100) * rand(0, 100);
        $sFilenameTmp = "backend_" . $iRand . ".scss";

        $sFileCssData = file_get_contents($this->addon->getPath("tpl/backend.scss"));
        $sFileCssData .= file_get_contents($this->addon->getPath("tpl/backend_" . $sStyle . ".scss"));


        $sFileJsData = file_get_contents($this->addon->getPath("tpl/backend.js.tpl"));

        $aSettings = $this->addon->getConfig();

        if ($aSettings["logo"]) {
            $aSettings["serverName"] = '<img src="' . rex_url::media($aSettings["logo"]) . '">';
        }

        if (!$aSettings["color"]) {
            $aSettings["color"] = "#0084A4";
        }

        $aSettings["brightcolor"] = $this->hex2rgba($aSettings["color"],"0.2");

        foreach ($aSettings as $sKey => $sVal) {
            $sFileCssData = str_replace("$" . $sKey, $sVal, $sFileCssData);
            $sFileJsData = str_replace("$" . $sKey, $sVal, $sFileJsData);
        }



        file_put_contents($this->addon->getAssetsPath($sFilenameTmp), $sFileCssData);
        file_put_contents($this->addon->getAssetsPath("backend.js"), $sFileJsData);

        $compiler = new rex_scss_compiler();
        $compiler->setScssFile([$this->addon->getAssetsPath($sFilenameTmp)]);
        $compiler->setCssFile($this->addon->getAssetsPath('backend.css'));
        $compiler->compile();

        unlink($this->addon->getAssetsPath($sFilenameTmp));
    }

    public static function hex2rgba($color, $opacity = false) {
 
        $default = 'rgb(0,0,0)';
     
        //Return default if no color provided
        if(empty($color))
              return $default; 
     
        //Sanitize $color if "#" is provided 
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }
     
            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                    return $default;
            }
     
            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);
     
            //Check if opacity is set(rgba or rgb)
            if($opacity){
                if(abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = 'rgb('.implode(",",$rgb).')';
            }
     
            //Return rgb(a) color string
            return $output;
    }

}
