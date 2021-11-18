<?php

$html = "<!-- user menu -->";
$html.= "<div class='collapse' id='user-menu'>";
$html.= "<div class='row justify-content-center'>";
$html.= "<div class='col-md-9'>";
$html.= "<div class='d-grid gap-2' id='user-menu-items' style='margin-top:0.5rem'>";
$html.= "<button class='btn btn-user-menu' type='button' onclick='location.href=\"./new_item.php\"'>Přidat položku</button>";
$html.= "<button class='btn btn-user-menu' type='button'>Editovat položku</button>";
$html.= "<button class='btn btn-user-menu' type='button'>Změnit heslo</button>";
$html.= "<button class='btn btn-user-menu' id='logout-btn' type='button'>Odhlásit</button>";
$html.= "</div>";
$html.= "</div>";
$html.= "</div>";
$html.= "</div>";
$html.= "<!-- end of user menu -->";

echo $html;

?>
