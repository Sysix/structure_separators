<?php
/**
 * structure_separators - be_style Plugin for Redaxo
 *
 * @version 0.5.1
 * @package redaxo 4.3.x/4.4.x/4.5.x
 */

if(!$REX['REDAXO']){
  return;
}


$mypage = 'structure_separators';

$REX['ADDON']['version'][$mypage]     = '0.5.1';
$REX['ADDON']['author'][$mypage]      = 'jdlx';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';


// SETTINGS
////////////////////////////////////////////////////////////////////////////////
# // --- DYN
# $REX["structure_separators"]["settings"] = array (
#   'addon_to_blocks' => 'developer,developer
# mysql_tools,developer
# dev_panel,developer
# __firephp,developer
# ',
#   'block_lang_strings' => 'developer,Developer,Developer',
# );
# // --- /DYN


// SUBPAGE
////////////////////////////////////////////////////////////////////////////////
# rex_register_extension('ADDONS_INCLUDED', 'structure_separators_page_inject');
# function structure_separators_page_inject($params)
# {
#   global $REX;
#
#   // SNEAK INTO BE_STYLE SUBPAGES
#   //////////////////////////////////////////////////////////////////////////////
#   if(!isset($REX['ADDON']['page']['be_style'])){
#     $REX['ADDON']['page']['be_style'] = 'be_style';
#     $REX['ADDON']['name']['be_style'] = 'Backend Style';
#   }
#   $REX['ADDON']['pages']['be_style'][] = array ('structure_separators' , 'Structure Fieldsets');
#   $REX['ADDON']['be_style']['SUBPAGES'] = $REX['ADDON']['pages']['be_style'];
#   if (rex_request('page', 'string') == 'be_style' && rex_request('subpage', 'string') == 'structure_separators')
#   {
#     $REX['ADDON']['navigation']['be_style']['path'] = $REX['INCLUDE_PATH'].'/addons/be_style/plugins/structure_separators/pages/index.php';
#   }
#
#   // ADD ME TO be_style DEFAULT PAGE CONTENT
#   //////////////////////////////////////////////////////////////////////////////
#   rex_register_extension('BE_STYLE_PAGE_CONTENT','structure_separators_be_style_default_page');
#
#   function structure_separators_be_style_default_page($params){
#     return $params['subject'].'
#       <h2 class="settings"><a href="index.php?page=be_style&amp;subpage=structure_separators">Structure Fieldsets</a></h2>
#       <p>Plugin um die Strukturansicht in Bereiche zu gruppieren.</p>
#       <hr />
#       ';
#   }
# }

// MAIN
////////////////////////////////////////////////////////////////////////////////
if(rex_request('page','string')=='structure'){
  rex_register_extension('OUTPUT_FILTER',
    function($params) use($REX){
      if(!isset($params['subject']) || $params['subject']==''){
        return;
      }
      $dom = new DOMDocument();
      $dom->loadHTML($params['subject']);
      $xpath = new DOMXpath($dom);
      $TRs = $xpath->query(".//*[@id='rex-output']/table[1]/tbody/tr");
      if (!is_null($TRs)) {
        foreach ($TRs as $TR) {
          $TDs = $TR->childNodes;
          foreach ($TDs as $TD) {
            if(substr($TD->nodeValue,0,10) == 'separator:'){
              #$TR->setAttribute('class','separator '.strtolower(preg_replace('/[^a-z-]/i','',$TD->nodeValue)));
              $TR->setAttribute('class','separator');
              foreach($TD->getElementsByTagName('a') as $A){
                $A->nodeValue = str_replace('separator:','',$A->nodeValue);
              }
              continue;
            }else{
              continue;
            }
          }
        }
      }
      $html = $dom->saveHtml();
      return $html;
    }
  );
}
