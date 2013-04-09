<?php
/**
 * structure_separators - be_style Plugin for Redaxo
 *
 * @version 0.5.1
 * @package redaxo 4.3.x/4.4.x/4.5.x
 */

$error = '';

if ($error != '') {
  $REX['ADDON']['installmsg']['structure_separators'] = $error;
} else {
  $REX['ADDON']['install']['structure_separators'] = true;
}
