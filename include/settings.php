<?php
$settings = mysqli_query($db, "SELECT * FROM setting") or die('query failed');
$fetchSettings = [];
if(mysqli_num_rows($settings) > 0){
    $fetchSettings = mysqli_fetch_assoc($settings);
}
$settingName = $fetchSettings['pageant_name'] ?? '';
$isGeneral = $fetchSettings['isGeneral'] ?? 0;
$weightedScoring = $fetchSettings['weighted_scoring'] ?? 0;
$logo = $fetchSettings['logo'] ?? 'logo.png';
$cover = $fetchSettings['cover_photo'] ?? 'pageant-background.png';
?>