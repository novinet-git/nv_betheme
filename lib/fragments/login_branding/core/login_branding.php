<?php

/**
 * @var rex_fragment $this
 * @psalm-scope-this rex_fragment
 */
$oAddon = rex_addon::get('nv_betheme');
?>
<div class="rex-branding">
    <?php $sLogo = $oAddon->getConfig('login_branding_image') ? rex_url::media($oAddon->getConfig('login_branding_image')) : $oAddon->getAssetsUrl(('images/novinet-logo.png')); ?>
    <img src="<?= $sLogo ?>" width="200">
</div>
