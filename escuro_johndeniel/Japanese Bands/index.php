<?php
// Add your PHP code here
$edit_band = []; 

$bandId = $edit_band['id'] ?? '';
$bandName = $edit_band['name'] ?? '';
$dateFormed = $edit_band['date_formed'] ?? '';
$bestHitAlbum = $edit_band['best_hit_album'] ?? '';
$genre = $edit_band['genre'] ?? '';
$submitButton = isset($edit_band) ? 'Update Band' : 'Add Band';

echo json_encode([
    'bandId' => $bandId,
    'bandName' => $bandName,
    'dateFormed' => $dateFormed,
    'bestHitAlbum' => $bestHitAlbum,
    'genre' => $genre,
    'submitButton' => $submitButton
]);
?>