<?php
if (!$this->getConfig("active")) {
    return;
}

$oBeTheme = new nvBeTheme;

// debug mode, bei jedem aufruf wird die css-datei neu generiert
// $oBeTheme->generateFiles();

if (file_exists($oBeTheme->addon->getAssetsPath("css/style.css"))) {
    rex_view::addCssFile($oBeTheme->addon->getAssetsUrl("css/style.css"));
}

// Include backend assets
if (rex::isBackend() && $oBeTheme->addon->getConfig("active")) {
    rex_extension::register('PACKAGES_INCLUDED', 'nvBeTheme_add_backend_assets', rex_extension::LATE);

    rex_extension::register('PACKAGES_INCLUDED', static function (rex_extension_point $ep) {
        rex::setProperty('theme', 'light');
        // CKE5 fix   
        rex_view::setJsProperty('cke5theme', 'light');
    }, rex_extension::EARLY);
}


function nvBeTheme_add_backend_assets(rex_extension_point $ep)
{
    $oBeTheme = new nvBeTheme;

    if ($oBeTheme->addon->getConfig("serverName") != rex::getServerName()) {
        $oBeTheme->addon->setConfig("serverName", rex::getServerName());
        $oBeTheme->generateFiles();
    }


    if (file_exists($oBeTheme->addon->getAssetsPath("backend.css"))) {
        rex_view::addCssFile($oBeTheme->addon->getAssetsUrl("backend.css"));
    }
    if (file_exists($oBeTheme->addon->getAssetsPath("backend.js"))) {
        rex_view::addJsFile($oBeTheme->addon->getAssetsUrl("backend.js"));
    }
}

if (rex::isBackend()) {
    if ($this->getConfig("login_background_active") == "|1|") {
        rex_fragment::addDirectory($this->getPath("lib/fragments/login_background/"));
    }
    if ($this->getConfig("login_branding_active") == "|1|") {
        rex_fragment::addDirectory($this->getPath("lib/fragments/login_branding/"));
    }
}
