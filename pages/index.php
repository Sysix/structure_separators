<?php
/**
 * structure_separators - be_style Plugin for Redaxo
 *
 * @version 0.5.1
 * @package redaxo 4.3.x/4.4.x/4.5.x
 */


// GET PARAMS
////////////////////////////////////////////////////////////////////////////////
$mypage     = 'structure_separators';
$myroot     = $REX['INCLUDE_PATH'].'/addons/be_style/plugins/'.$mypage.'/';
$subpage    = rex_request('subpage', 'string');
$func       = rex_request('func', 'string');


// PAGE HEAD
////////////////////////////////////////////////////////////////////////////////
require $REX['INCLUDE_PATH'] . '/layout/top.php';

rex_title('Backend Style <span style="color:silver;font-size:0.5em;">Navigation Blocks '.$REX['ADDON']['plugins']['be_style']['version'][$mypage].'</span>',$REX['ADDON']['be_style']['SUBPAGES']);


// SAVE SETTINGS
////////////////////////////////////////////////////////////////////////////////
if($func=='save_settings'){
  $settings   = rex_request('settings', 'array');
  foreach($settings as $k => $v){
    $settings[$k] = stripslashes($v);
  }

  $content = '$REX["structure_separators"]["settings"] = '.var_export($settings,true).';';
  if(rex_replace_dynamic_contents($myroot.'config.inc.php', $content)){
    $REX["structure_separators"]["settings"] = $settings;
  }
  echo rex_info('Settings saved.');
}


// PAGE BODY
////////////////////////////////////////////////////////////////////////////////

echo '
<!--<div class="rex-addon-output im-plugins">
  <h2 class="rex-hl2" style="font-size:1em;border-bottom:0;">./*$subsubnavi*/.</h2>
</div>-->

<div class="rex-addon-output im-plugins">
  <div class="rex-form">

    <form action="index.php?page=be_style&subpage='.$mypage.'" method="post">
      <input type="hidden" name="page" value="be_style" />
      <input type="hidden" name="subpage" value="'.$mypage.'" />
      <input type="hidden" name="func" value="save_settings" />

      <fieldset class="rex-form-col-1">
        <legend style="font-size:1.2em">Navigation Blocks</legend>
          <div class="rex-form-wrapper">


            <div class="rex-form-row">
              <p class="rex-form-col-a rex-form-textarea">
                <label for="spectrum_options">Block Definitions</label>
                <textarea id="spectrum_options" style="min-height:80px;font-family:monospace;font-size:1.3em" class="rex-form-textarea rex-codemirror" name="settings[addon_to_blocks]">'.$REX[$mypage]['settings']['addon_to_blocks'].'</textarea>
                <span style="margin-left:155px;color:gray;font-size:10px;font-family:monospace;">[addon,block_name]</span>
              </p>
            </div><!-- .rex-form-row -->


            <div class="rex-form-row">
              <p class="rex-form-col-a rex-form-textarea">
                <label for="spectrum_options">i18n strings</label>
                <textarea id="spectrum_options" style="min-height:80px;font-family:monospace;font-size:1.3em" class="rex-form-textarea rex-codemirror" name="settings[block_lang_strings]">'.$REX[$mypage]['settings']['block_lang_strings'].'</textarea>
                <span style="margin-left:155px;color:gray;font-size:10px;font-family:monospace;">[block_name,lang0_string,lang1_string,..]</span>
              </p>
            </div><!-- .rex-form-row -->


            <div class="rex-form-row rex-form-element-v2">
              <p class="rex-form-submit">
                <input class="rex-form-submit" type="submit" id="sendit" name="sendit" value="Einstellungen speichern" />
              </p>
            </div><!-- /rex-form-row -->


          </div><!-- /rex-form-wrapper -->
        </fieldset>
      </form>
    </div><!-- /rex-form -->
  </div><!-- /rex-addon-output -->
  ';


require $REX['INCLUDE_PATH'] . '/layout/bottom.php';
