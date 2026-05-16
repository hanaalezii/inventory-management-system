<?php
session_start();
include 'panel.php';
include 'db.php';
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8" />
    <title>Galeria Jonë</title>
    <style>
        .carousel-container {
            width: 1000px;
            height: 700px;
            margin: 100px auto;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
            background: #000;
        }

        .carousel-slide {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }

        .carousel-item {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .carousel-caption {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: #fff;
            font-size: 18px;
            background: rgba(0, 0, 0, 0.4);
            padding: 8px 12px;
            border-radius: 8px;
            max-width: 90%;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            transition: background 0.3s ease;
            z-index: 100;
        }

        .carousel-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .carousel-btn.prev {
            left: 15px;
        }

        .carousel-btn.next {
            right: 15px;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .indicator.active,
        .indicator:hover {
            background: white;
        }
    </style>
</head>

<body>
    
<div class="carousel-container" aria-label="Galeria e imazheve" tabindex="0">
    
    <div class="carousel-slide" id="carouselSlide">
        <div class="carousel-item active">
            <img src="materiali/epara.jpg" alt="Foto 1" />
            <div class="carousel-caption"> Freski moderne për çdo hapësirë!</div>
        </div>
        <div class="carousel-item">
            <img src="materiali/edyta.jpg" alt="Foto 2" />
            <div class="carousel-caption">Kontroll nga distanca, rehati në çdo kohë.</div>
        </div>
        <div class="carousel-item">
            <img src="materiali/etreta.jpg" alt="Foto 3" />
            <div class="carousel-caption">Ajër i pastër dhe i shëndetshëm në çdo frymëmarrje.</div>
        </div>
        <div class="carousel-item">
            <img src="materiali/ekaterta.jpg" alt="Foto 4" />
            <div class="carousel-caption">Dizajn që i përshtatet çdo interieri.</div>
        </div>
        <div class="carousel-item">
            <img src="materiali/epesta.jpg" alt="Foto 5" />
            <div class="carousel-caption">Fuqishme dhe e qetë.</div>
        </div>
        <div class="carousel-item">
            <img src="materiali/egjashta.jpg" alt="Foto 6" />
            <div class="carousel-caption">Mbrojtje për mjedisin dhe buxhetin tuaj.</div>
        </div>
    </div>

    <button class="carousel-btn prev" id="prevBtn" aria-label="I mëparshmi">&#10094;</button>
    <button class="carousel-btn next" id="nextBtn" aria-label="I ardhshmi">&#10095;</button>

    <div class="carousel-indicators" id="indicators" role="tablist" aria-label="Zgjidh imazhin">
        <div class="indicator active" data-slide="0" tabindex="0" role="tab" aria-selected="true" aria-label="Shfaq imazhin 1"></div>
        <div class="indicator" data-slide="1" tabindex="0" role="tab" aria-selected="false" aria-label="Shfaq imazhin 2"></div>
        <div class="indicator" data-slide="2" tabindex="0" role="tab" aria-selected="false" aria-label="Shfaq imazhin 3"></div>
        <div class="indicator" data-slide="3" tabindex="0" role="tab" aria-selected="false" aria-label="Shfaq imazhin 4"></div>
        <div class="indicator" data-slide="4" tabindex="0" role="tab" aria-selected="false" aria-label="Shfaq imazhin 5"></div>
        <div class="indicator" data-slide="5" tabindex="0" role="tab" aria-selected="false" aria-label="Shfaq imazhin 6"></div>
    </div>
</div>


    <script>
        (function() {
            const carouselSlide = document.getElementById('carouselSlide');
            const indicators = document.getElementById('indicators').children;
            const totalSlides = carouselSlide.children.length;
            let currentIndex = 0;
            let autoSlideInterval;

            function showSlide(index) {
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;

                carouselSlide.style.transform = `translateX(${-index * 100}%)`;

                for (let i = 0; i < indicators.length; i++) {
                    const isActive = (i === index);
                    indicators[i].classList.toggle('active', isActive);
                    indicators[i].setAttribute('aria-selected', isActive ? 'true' : 'false');
                }

                currentIndex = index;
            }

            document.getElementById('nextBtn').addEventListener('click', () => {
                showSlide(currentIndex + 1);
            });

            document.getElementById('prevBtn').addEventListener('click', () => {
                showSlide(currentIndex - 1);
            });

            Array.from(indicators).forEach(indicator => {
                indicator.addEventListener('click', () => {
                    const slideIndex = parseInt(indicator.getAttribute('data-slide'));
                    showSlide(slideIndex);
                });
                indicator.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const slideIndex = parseInt(indicator.getAttribute('data-slide'));
                        showSlide(slideIndex);
                    }
                });
            });

            document.querySelector('.carousel-container').addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    showSlide(currentIndex - 1);
                } else if (e.key === 'ArrowRight') {
                    showSlide(currentIndex + 1);
                }
            });

            function startAutoSlide() {
                autoSlideInterval = setInterval(() => {
                    showSlide(currentIndex + 1);
                }, 6000);
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            const carouselContainer = document.querySelector('.carousel-container');
            carouselContainer.addEventListener('mouseenter', stopAutoSlide);
            carouselContainer.addEventListener('mouseleave', startAutoSlide);

            showSlide(0);
            startAutoSlide();
        })();
    </script>

</body>

</html>