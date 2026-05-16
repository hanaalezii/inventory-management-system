<?php
session_start();
include 'panel.php';
include 'db.php';
?>


<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <title>Rreth Nesh - ADI Conditioner</title>
    <style>
    

        .rn-container {
            max-width: 1100px;
            margin: 100px auto;
            padding: 40px;
            background: linear-gradient(135deg, #6842b3, #695CFE);
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 12px;
        }

   
        .rn-title {
            text-align: center;
            color: #d4ccff;
            margin-bottom: 30px;
        }


        .rn-intro {
            font-size: 18px;
            line-height: 1.8;
            text-align: center;
            color: #d4ccff;
             box-shadow: 0px 0px 15px 15px rgba(0,0,0,0.2);
            
        }


        .rn-features {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
             transition: transform 0.9s ease-out;
        }
        .rn-features:hover{
            transform: translateY(-20px);
        }

 
        .rn-feature {
            background-color: #ECF0F1;
            border-left: 6px solid rgba(32, 24, 93, 0.9);
            padding: 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        
        }

        .rn-feature h3 {
            margin-top: 0;
            color: rgba(32, 24, 93, 0.9);
            
        }


        @media(max-width: 768px) {
            .rn-container {
                margin: 40px 20px;
                padding: 20px;
            }

            .rn-intro {
                font-size: 16px;
            }
        }
    </style>
</head>
<body class="rn-body">

    <div class="rn-container">
        <h1 class="rn-title">Rreth Nesh</h1>
        <div class="rn-intro">
            <p>
                ADI Conditioner është një kompani lider në tregun e sistemeve të klimatizimit në Kosovë.
                Me përvojë shumëvjeçare, ne ofrojmë produkte cilësore nga markat më të njohura si BRUNO, TCL dhe MIDEA.
                Qëllimi ynë është të ofrojmë rehati dhe efikasitet energjetik për çdo klient.
            </p>
            <p>
                Ne jemi të përkushtuar për të ofruar shërbim profesional, instalime të sigurta dhe këshilla të specializuara
                për zgjedhjen e klimës më të përshtatshme për hapësirën tuaj. Na besoni për cilësi, çmime të arsyeshme dhe përkushtim të plotë.
            </p>
        </div>

        <div class="rn-features">
            <div class="rn-feature">
                <h3>Përvojë Profesionale</h3>
                <p>Staf me përvojë të gjatë në fushën e klimatizimit, të gatshëm për t'ju ndihmuar në çdo hap.</p>
            </div>
            <div class="rn-feature">
                <h3>Produkte Origjinale</h3>
                <p>Vetëm produkte të certifikuara dhe origjinale nga brendet më të mira ndërkombëtare.</p>
            </div>
            <div class="rn-feature">
                <h3>Instalim i Sigurt</h3>
                <p>Shërbim i plotë instalimi me pajisje moderne dhe teknologji të avancuar.</p>
            </div>
            <div class="rn-feature">
                <h3>Garanci dhe Shërbim</h3>
                <p>Garanci për çdo produkt dhe mirëmbajtje profesionale pas instalimit.</p>
            </div>
            <div class="rn-feature">
                <h3>Këshillim Falas</h3>
                <p>Ofrojmë udhëzim të personalizuar për të zgjedhur klimën që i përshtatet ambientit tuaj.</p>
            </div>
            <div class="rn-feature">
                <h3>Çmime Konkurruese</h3>
                <p>Çmime të përballueshme për çdo buxhet pa kompromentuar cilësinë.</p>
            </div>
        </div>

     
    </div>

</body>
</html>
