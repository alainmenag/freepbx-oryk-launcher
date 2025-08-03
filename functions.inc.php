<?php

// functions.inc.php

// function Oryk_launcher_configpageinit($page)
// {
// }


function oryk_launcher_hook_core() {
    global $admin;
    $admin->addJS('/admin/modules/oryk_launcher/js/launcher.js'); // if needed
    $admin->addCSS('/admin/modules/oryk_launcher/css/launcher.css');
}


?>