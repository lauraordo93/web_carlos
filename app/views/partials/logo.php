<?php
$header = $header ?? [];
$logo_url = !empty($header['logo']) ? asset_url($header['logo']) : '';
$logo_url = htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8');
?>
<style>
   header#inicio {
    background-image: url('<?php echo $logo_url; ?>');
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
    background-color: #000;
    width: 100%;
    min-height: 900px; /* Ajusta según necesites */
    max-height: none; /* Elimina el max-height */
    display: flex;
    justify-content: center;
    position: relative;
}

@media screen and (max-width: 768px) {
    header#inicio {
        min-height: 400px;
    }
}

@media screen and (max-width: 480px) {
    header#inicio {
        min-height: 300px;
    }
}
</style>