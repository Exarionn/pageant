<?php
$settings = mysqli_query($db, "SELECT * FROM setting") or die('query failed');
if(mysqli_num_rows($settings) > 0){
            $fetchSettings = mysqli_fetch_assoc($settings);
}
$settingName = $fetchSettings['pageant_name'];
$isGeneral = $fetchSettings['isGeneral'];
$weightedScoring = $fetchSettings['weighted_scoring'];
$logo = $fetchSettings['logo'];
$cover = $fetchSettings['cover_photo'];
?>