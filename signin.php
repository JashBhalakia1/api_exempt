<?php
require "AutoLoad.php";
$ObjLayouts->heading($conf);
$ObjMenus->main_menu($conf);
$ObjHeadings->main_banner();
$ObjForm->sign_in_form($ObjGlob);
$ObjCont->side_bar();
$ObjLayouts->footer($conf);