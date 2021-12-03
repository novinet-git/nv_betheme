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
            $sFilenameTmp = "backend_".$iRand.".scss";

            $sFileCssData = file_get_contents($this->addon->getPath("tpl/backend.scss"));
            $sFileCssData .= file_get_contents($this->addon->getPath("tpl/backend_".$sStyle.".scss"));
            
            
            $sFileJsData = file_get_contents($this->addon->getPath("tpl/backend.js.tpl"));
            
            $aSettings = $this->addon->getConfig();
    
            if ($aSettings["logo"]) {
                $aSettings["serverName"] = '<img src="'.rex_url::media($aSettings["logo"]).'">';
            }
    
            foreach ($aSettings as $sKey => $sVal) {
                $sFileCssData = str_replace("$" . $sKey, $sVal, $sFileCssData);
                $sFileJsData = str_replace("$" . $sKey, $sVal, $sFileJsData);
            }

            file_put_contents($this->addon->getAssetsPath($sFilenameTmp),$sFileCssData);
            file_put_contents($this->addon->getAssetsPath("backend.js"), $sFileJsData);

            $compiler = new rex_scss_compiler();
            $compiler->setScssFile([$this->addon->getAssetsPath($sFilenameTmp)]);
            $compiler->setCssFile($this->addon->getAssetsPath('backend.css'));
            $compiler->compile();
            
            unlink($this->addon->getAssetsPath($sFilenameTmp));

    }
}
