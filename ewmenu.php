<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(9, "mi_home_php", $Language->MenuPhrase("9", "MenuText"), "home.php", -1, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}home.php'), FALSE, TRUE, "far fa-home");
$RootMenu->AddMenuItem(3, "mi_leave_form", $Language->MenuPhrase("3", "MenuText"), "leave_formlist.php", -1, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_form'), FALSE, FALSE, "far fa-building");
$RootMenu->AddMenuItem(19, "mci_Admin_Only", $Language->MenuPhrase("19", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "fa-sharp fa-solid fa-users");
$RootMenu->AddMenuItem(4, "mi_status", $Language->MenuPhrase("4", "MenuText"), "statuslist.php", 19, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}status'), FALSE, FALSE, "far fa-building");
$RootMenu->AddMenuItem(6, "mi_userlevelpermissions", $Language->MenuPhrase("6", "MenuText"), "userlevelpermissionslist.php", 19, "", IsAdmin(), FALSE, FALSE, "fa-sharp fa-solid fa-user");
$RootMenu->AddMenuItem(7, "mi_userlevels", $Language->MenuPhrase("7", "MenuText"), "userlevelslist.php", 19, "", IsAdmin(), FALSE, FALSE, "fa-sharp fa-solid fa-users");
$RootMenu->AddMenuItem(22, "mi_report", $Language->MenuPhrase("22", "MenuText"), "reportlist.php", -1, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}report'), FALSE, FALSE, "far fa-building");
$RootMenu->AddMenuItem(21, "mci_User2dmanagement", $Language->MenuPhrase("21", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "fa-sharp fa-solid fa-user");
$RootMenu->AddMenuItem(5, "mi_user_profile", $Language->MenuPhrase("5", "MenuText"), "user_profilelist.php", 21, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}user_profile'), FALSE, FALSE, "far fa-user-secret");
$RootMenu->AddMenuItem(10, "mi_company", $Language->MenuPhrase("10", "MenuText"), "companylist.php", 21, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}company'), FALSE, FALSE, "far fa-building");
$RootMenu->AddMenuItem(1, "mi_department", $Language->MenuPhrase("1", "MenuText"), "departmentlist.php", 21, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}department'), FALSE, FALSE, "fa-sharp fa-solid fa-users");
$RootMenu->AddMenuItem(8, "mi_leave_type", $Language->MenuPhrase("8", "MenuText"), "leave_typelist.php", 21, "", AllowListMenu('{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_type'), FALSE, FALSE, "far fa-building");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
