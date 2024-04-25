<?php

/**
 * @var rex_fragment $this
 * @psalm-scope-this rex_fragment
 */
$oAddon = rex_addon::get('nv_betheme');
?>
<?php $sBackground = $oAddon->getConfig('login_background_image') ? rex_url::media($oAddon->getConfig('login_background_image')) : rex_url::addonAssets('nv_betheme', 'images/login-background.jpeg'); ?>


<picture class="rex-background">
    <img alt="" src="<?= $sBackground ?>" srcset="
            <?= $sBackground ?> 2100w,
            <?= $sBackground ?> 3300w" sizes="100vw" />
</picture>

<style>
    #rex-page-login {
        background-color: #06061a;
    }

    #rex-page-login .panel-default {
        background-color: rgba(15, 17, 51, 0.9);
    }

    #rex-page-login .btn-primary {
        background-color: <?= $oAddon->getConfig('color'); ?>;
        border-color: rgba(0, 0, 0, 0.5);
    }

    #rex-page-login .btn-primary:hover,
    #rex-page-login .btn-primary:focus {
        background-color: <?= nvBeTheme::hex2rgba($oAddon->getConfig('color'), "0.6"); ?>;
    }
</style>

<script>
    var picture = document.querySelector('.rex-background');
    picture.classList.add('rex-background--process');
    picture.querySelector('img').onload = function() {
        picture.classList.add('rex-background--ready');
    }
</script>

<footer class="rex-global-footer">
    <nav class="rex-nav-footer">
        <ul class="list-inline">
            <li><a href="https://www.yakamara.de" target="_blank" rel="noreferrer noopener">yakamara.de</a></li>
            <li><a href="https://www.redaxo.org" target="_blank" rel="noreferrer noopener">redaxo.org</a></li>

            <li class="rex-background-credits">
                <?php $sCredits = $oAddon->getConfig('login_background_credits') ?: '<a href="https://novinet.de" target="_blank">Developed by NOVINET</a>';
                echo $sCredits; ?></li>
        </ul>
    </nav>
</footer>
