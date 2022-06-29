<?php

if (!$this->hasConfig()) {
    $this->setConfig([
            "serverName" => rex::getServerName(),
            "color" => "#009ed1",
            "active" => "|1|",
            "style" => "light",
            "login_branding_active" => "|1|",
            "login_background_active" => "|1|"
    ]);
}
$this->setConfig('generatefiles',true);