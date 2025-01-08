<?php
require "AutoLoad.php";
$ObjLayouts->heading($conf);
$ObjMenus->main_menu($conf);
$ObjHeadings->main_banner();
$ObjCont->about_content();
$ObjCont->side_bar();
$ObjLayouts->footer($conf);