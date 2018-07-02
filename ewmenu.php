<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(1, "mi_college", $Language->MenuPhrase("1", "MenuText"), "collegelist.php", -1, "", IsLoggedIn() || AllowListMenu('{7dac28fc-e6ee-49d2-b722-398a2b30146f}college'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_faculty", $Language->MenuPhrase("2", "MenuText"), "facultylist.php", -1, "", IsLoggedIn() || AllowListMenu('{7dac28fc-e6ee-49d2-b722-398a2b30146f}faculty'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_result", $Language->MenuPhrase("3", "MenuText"), "resultlist.php", -1, "", IsLoggedIn() || AllowListMenu('{7dac28fc-e6ee-49d2-b722-398a2b30146f}result'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_student", $Language->MenuPhrase("4", "MenuText"), "studentlist.php", -1, "", IsLoggedIn() || AllowListMenu('{7dac28fc-e6ee-49d2-b722-398a2b30146f}student'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(5, "mi_subject", $Language->MenuPhrase("5", "MenuText"), "subjectlist.php", -1, "", IsLoggedIn() || AllowListMenu('{7dac28fc-e6ee-49d2-b722-398a2b30146f}subject'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
