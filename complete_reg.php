<?php
require "AutoLoad.php";
$ObjGlob->checksignin();
$ObjLayouts->heading($conf);
$ObjMenus->main_menu($conf);
$ObjHeadings->main_banner();
$ObjForm->complete_reg_form($ObjGlob, $conn);
$ObjCont->side_bar();
$ObjLayouts->footer($conf);