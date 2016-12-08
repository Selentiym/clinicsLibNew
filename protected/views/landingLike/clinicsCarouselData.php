<?php
$clinics_to_map = $this -> giveClinics();
foreach ($clinics_to_map as $cl) {
    $this -> renderPartial("//landingLike/clinicsViewForScroller", ['model' => $cl]);
}
?>