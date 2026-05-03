<?php
$logo_url = !empty($header['logo']) ? htmlspecialchars($header['logo']) : '';
?>
<style>
    header#inicio {
        background-image: url('<?php echo $logo_url; ?>');
        background-size: cover;
        background-position: top center;
        background-repeat: no-repeat;
        width: 100%;
        min-height: 99vh;
        display: flex;
        justify-content: center;
        position: relative;
        border-bottom: 2px solid #4B1E78;
    }

    @media screen and (max-width: 1440px) {
        header#inicio {
            background-image: url('img/Carlos_cabecera3.jpg');
            min-height: 95vh;
            padding: 2rem;
            background-size: cover;
            background-position: center top;
            background-attachment: scroll;
        }
    }

    @media screen and (max-width: 1024px) {
        header#inicio {
            background-image: url('img/Carlos_cabecera33.jpg');
            min-height: 43vh;
            padding: 1.5rem;
            background-position: center center;
            background-size: cover;
        }
    }

    @media screen and (max-width: 768px) {
        header#inicio {
            min-height: 47vh;
            padding: 2rem;
            background-position: center center;
            background-attachment: scroll;
        }
    }

    @media screen and (max-width: 480px) {
        header#inicio {
            background-image: url('img/Carlos_cabeceramedia.jpg');
            min-height: 24vh;
            padding: 1.2rem;
            background-position: right center;
            background-size: cover;
            -webkit-text-size-adjust: 100%;
        }
    }
</style>