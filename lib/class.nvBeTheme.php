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
        $sFileCssData = file_get_contents($this->addon->getPath("tpl/backend".$this->addon->getConfig("style").".css.tpl"));
        $sFileJsData = file_get_contents($this->addon->getPath("tpl/backend.js.tpl"));

        $aSettings = $this->addon->getConfig();
    
        if ($aSettings["logo"]) {
            $aSettings["serverName"] = '<img src="'.rex_url::media($aSettings["logo"]).'">';
        }

        foreach ($aSettings as $sKey => $sVal) {
            $sFileCssData = str_replace("{{" . $sKey . "}}", $sVal, $sFileCssData);
            $sFileJsData = str_replace("{{" . $sKey . "}}", $sVal, $sFileJsData);
        }

        file_put_contents($this->addon->getAssetsPath("backend.css"), $sFileCssData);
        file_put_contents($this->addon->getAssetsPath("backend.js"), $sFileJsData);
    }
}
