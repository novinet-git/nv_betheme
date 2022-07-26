<?php
if (!$this->getConfig("active")) {
    return;
}

if ($this->getConfig('generatefiles')) {
    $oBeTheme = new nvBeTheme;
    $oBeTheme->generateFiles();
    $this->removeConfig('generatefiles');
}

$oBeTheme = new nvBeTheme;

// debug mode, bei jedem aufruf wird die css-datei neu generiert
// $oBeTheme->generateFiles();

if (file_exists($oBeTheme->addon->getAssetsPath("css/style.css"))) {
    rex_view::addCssFile($oBeTheme->addon->getAssetsUrl("css/style.css"));
}

if (!rex_plugin::get('ui_tools', 'selectize')->isAvailable()) {
    rex_view::addCssFile($this->getAssetsUrl('vendor/selectize/selectize/dist/css/selectize.css'));
    rex_view::addCssFile($this->getAssetsUrl('vendor/selectize/selectize/dist/css/selectize.bootstrap3.css'));
    rex_view::addJsFile($this->getAssetsUrl('vendor/selectize/selectize/dist/js/standalone/selectize.min.js'));
    rex_view::addJsFile($this->getAssetsUrl('vendor/selectize/rex_selectize.js'));
}

// Include backend assets
if (rex::isBackend() && $oBeTheme->addon->getConfig("active")) {
    rex_extension::register('PACKAGES_INCLUDED', 'nvBeTheme_add_backend_assets', rex_extension::LATE);

    rex_extension::register('OUTPUT_FILTER', static function($ep) {
        
        $sSubject = $ep->getSubject();
        $sSubject = str_replace('class="form-control selectpicker"','class="form-control selectpicker w-100" data-live-search="true"',$sSubject);
        $sSubject = str_replace('class="form-control  selectpicker"','class="form-control  selectpicker w-100" data-live-search="true"',$sSubject);
        $sSubject = str_replace('<div class="checkbox','<div class="checkbox toggle',$sSubject);
        $sSubject = str_replace('<div class="radio','<div class="radio toggle switch',$sSubject);
        $ep->setSubject($sSubject);

    }, rex_extension::LATE);






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

    rex::setProperty('theme', 'light');
    // CKE5 fix   
    rex_view::setJsProperty('cke5theme', 'light');
}

if (rex::isBackend()) {
    if ($this->getConfig("login_background_active") == "|1|") {
        rex_fragment::addDirectory($this->getPath("lib/fragments/login_background/"));
    }
    if ($this->getConfig("login_branding_active") == "|1|") {
        rex_fragment::addDirectory($this->getPath("lib/fragments/login_branding/"));
    }
}
