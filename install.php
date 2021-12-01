<?php

if (!$this->hasConfig()) {
    $this->setConfig([
            "serverName" => rex::getServerName(),
            "color" => "#009ed1",
            "active" => "1",
            "style" => "light",
    ]);
}
$oBeTheme = new nvBeTheme;
$oBeTheme->generateFiles();