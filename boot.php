<?php
$oBeTheme = new nvBeTheme;
// debug mode, bei jedem aufruf wird die css-datei neu generiert
// $oBeTheme->generateFiles();

if (file_exists($oBeTheme->addon->getAssetsPath("css/style.css"))) {
    rex_view::addCssFile($oBeTheme->addon->getAssetsUrl("css/style.css"));
}

// Include backend assets
if (rex::isBackend() && $oBeTheme->addon->getConfig("active")) {
    rex_extension::register('PACKAGES_INCLUDED', 'nvBeTheme_add_backend_assets', rex_extension::LATE);
}


function nvBeTheme_add_backend_assets(rex_extension_point $ep)
{
    $oBeTheme = new nvBeTheme;

    if ($oBeTheme->addon->getConfig("serverName") != rex::getServerName()) {
        $oBeTheme->addon->setConfig("serverName",rex::getServerName());
        $oBeTheme->generateFiles();
    }


    if (file_exists($oBeTheme->addon->getAssetsPath("backend.css"))) {
        rex_view::addCssFile($oBeTheme->addon->getAssetsUrl("backend.css"));
    }
    if (file_exists($oBeTheme->addon->getAssetsPath("backend.js"))) {
        rex_view::addJsFile($oBeTheme->addon->getAssetsUrl("backend.js"));
    }
}
