<?php
$oBeTheme = new nvBeTheme;


$form = rex_config_form::factory($oBeTheme->addon->name);



$field = $form->addSelectField('style',$value = null,['class'=>'form-control selectpicker']);
$field->setLabel($this->i18n('nv_betheme_navigation'));
$select = $field->getSelect();
$select->addOption('Dunkle Navigation', 'dark');
$select->addOption('Helle Navigation',"light");

$field = $form->addInputField('text', 'color', null, ["class" => "form-control"]);
$field->setLabel($this->i18n('nv_betheme_color'));

$field = $form->addMediaField('logo', null, ["class" => "form-control"]);
$field->setLabel($this->i18n('nv_betheme_logo'));

$field = $form->addCheckboxField('active');
$field->addOption('','1');
$field->setLabel($this->i18n('nv_betheme_active'));





$field = $form->addCheckboxField('login_branding_active');
$field->addOption('','1');
$field->setLabel($this->i18n('nv_betheme_login_branding_active'));

$field = $form->addMediaField('login_branding_image', null, ["class" => "form-control"]);
$field->setLabel($this->i18n('nv_betheme_login_branding_image'));


$field = $form->addCheckboxField('login_background_active');
$field->addOption('','1');
$field->setLabel($this->i18n('nv_betheme_login_background_active'));

$field = $form->addMediaField('login_background_image', null, ["class" => "form-control"]);
$field->setLabel($this->i18n('nv_betheme_login_background_image'));

$field = $form->addInputField('text', 'login_background_credits', null, ["class" => "form-control"]);
$field->setLabel($this->i18n('nv_betheme_login_background_credits'));


$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('nv_betheme_settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');


if (rex_post($form->getName() . '_save')) {
    $oBeTheme->generateFiles();
}

return;

$content = '';

$func = rex_request('func', 'string');

if ($func == 'update') {

    $this->setConfig('color', rex_post('color', 'string'));

    $oBeTheme->generateFiles();

    echo rex_view::success($this->i18n('config_saved'));
}


/* form */

$formElements = [];
$n = [];
$n['label'] = '<label for="color">' . $this->i18n('color') . '</label>';
$n['field'] = '<input type="text" class="form-control" id="color" name="color" value="' . $this->getConfig('color') . '">';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');



/*
$formElements = [];
$n = [];
$n['label'] = '<label for="autoload_css">' . $this->i18n('config_assets_css') . '</label>';
$n['field'] = '<input type="checkbox" id="autoload_css" name="config[autoload_css]" value="1" ' . ($this->getConfig('autoload_css') ? ' checked="checked"' : '') . '>';
$formElements[] = $n;

$n = [];
$n['label'] = '<label for="autoload_js">' . $this->i18n('config_assets_js') . '</label>';
$n['field'] = '<input type="checkbox" id="autoload_js" name="config[autoload_js]" value="1" ' . ($this->getConfig('autoload_js') ? ' checked="checked"' : '') . '>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$assets = $fragment->parse('core/form/checkbox.php');

$formElements = [];
$n = [];
$n['label'] = $this->i18n('config_load_assets');
$n['field'] = $assets;
$n['note'] = rex_i18n::rawMsg('emailobfuscator_config_assets_note', rex_url::backendPage('packages', ['subpage' => 'help', 'package' => $this->getPackageId()]));
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');

$n['label'] = '<label for="mailto_only">' . $this->i18n('config_mailto_only') . '</label>';
$n['field'] = '<input type="checkbox" id="mailto_only" name="config[mailto_only]" value="1" ' . ($this->getConfig('mailto_only') ? ' checked="checked"' : '') . '>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');
*/


/* buttons */

$formElements = [];
$n = [];
$n['field'] = '<a class="btn btn-abort" href="' . rex_url::currentBackendPage() . '">' . rex_i18n::msg('form_abort') . '</a>';
$formElements[] = $n;

$n = [];
$n['field'] = '<button class="btn btn-apply rex-form-aligned" type="submit" name="send" value="1"' . rex::getAccesskey(rex_i18n::msg('update'), 'apply') . '>' . rex_i18n::msg('update') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');



/* generate page */

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('settings'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$content = $fragment->parse('core/page/section.php');

$content = '
    <form action="' . rex_url::currentBackendPage() . '" method="post">
        <input type="hidden" name="func" value="update">
        ' . $content . '
    </form>';

echo $content;
