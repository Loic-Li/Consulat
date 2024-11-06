<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

$cssFile='country' ?>
<?php include '../includes/header.php'; ?>


    <header class="text-center py-5">
        <h1>Bienvenue en Chine</h1>
    </header>

    <main class="container my-5">
        <section class="section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="../assets/img/histoire_img.png" alt="Histoire de la Chine" class="img-fluid histoire-img">
                </div>
                <div class="col-md-6">
                    <h2 class="histoire-title">Histoire</h2>
                    <p class="histoire-para">La Chine possède l'une des plus anciennes civilisations du monde, avec plus
                        de 5 000 ans
                        d'histoire. Des premières dynasties comme les Zhou et les Qin à l'ère moderne, ce pays a marqué
                        le monde avec des inventions telles que le papier, l'imprimerie, la boussole et la poudre à
                        canon. La Grande Muraille et la Cité Interdite sont des témoignages vivants de ce riche passé.
                    </p>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="../assets/img/globe-china.png" alt="Globe montrant la chine" class="img-fluid globe-china-img">
                </div>
                <div class="col-md-6">
                    <ul>
                        <li>Monnaie    : Renminbi (RMB)</li>
                        <li>Langue     : Mandarin</li>
                        <li>Superficie  : 9,596,961 km²</li>
                        <li>Population : 1,41 milliard d'habitants</li>
                        <li>Situation politique : État socialiste</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="../assets/img/geographie_img.png" alt="Géographie de la Chine"
                        class="img-fluid geograpgie-img">
                </div>
                <div class="col-md-6">
                    <h2 class="geographie-title">Géographie</h2>
                    <p class="geograpgie-para">S'étendant sur plus de 9,6 millions de kilomètres carrés, la Chine est le
                        troisième plus grand pays au monde. Elle offre des paysages variés, allant des montagnes de
                        l'Himalaya au désert de Gobi, en passant par les forêts subtropicales et les rizières en
                        terrasse du sud. Les fleuves comme le Yangtsé et le Fleuve Jaune sont essentiels à la vie et à
                        l'histoire du pays.
                    </p>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="../assets/img/economie_img.png" alt="Économie de la Chine" class="img-fluid economie_img">
                </div>
                <div class="col-md-6">
                    <h2 class="economie_img">Économie</h2>
                    <p class="economie_img">La Chine est aujourd'hui la deuxième économie mondiale et un acteur majeur
                        du commerce international. Avec des industries dynamiques dans les technologies, le textile, et
                        une main-d'œuvre qualifiée, elle se développe à une vitesse fulgurante. Ses grandes métropoles
                        comme Shanghai et Shenzhen sont des symboles de son essor économique.
                    </p>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="../assets/img/technologie_img.png" alt="Technologie de la Chine"
                        class="img-fluid technologie-img">
                </div>
                <div class="col-md-6">
                    <h2 class="technologie-title">Technologie</h2>
                    <p class="technologie-para">La Chine est également à la pointe de la technologie avec des géants
                        comme Huawei, Alibaba et Tencent. Les villes modernes regorgent d'innovations, allant des
                        paiements sans contact omniprésents aux systèmes de transport futuristes comme les trains à
                        grande vitesse. Le pays investit massivement dans la recherche et les énergies renouvelables
                        pour soutenir son développement durable.
                    </p>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="../assets/img/gastronomie_img.png" alt="Gastronomie de la Chine"
                        class="img-fluid gastronomie_img">
                </div>
                <div class="col-md-6">
                    <h2 class="gastronomie_img">Gastronomie</h2>
                    <p class="gastronomie_img">La cuisine chinoise est réputée dans le monde entier pour sa diversité et
                        ses saveurs uniques. Des raviolis de Shanghai au canard laqué de Pékin, chaque région offre ses
                        spécialités. La variété des ingrédients, les techniques de cuisson sophistiquées et l'équilibre
                        des saveurs font de la cuisine chinoise une expérience culinaire incontournable.
                    </p>
                </div>
            </div>
        </section>

        <footer class="text-center">
            <a href="culture.php" class="btn btn-primary">Notre culture</a>
            <p>&copy; 2024 Consulat de Chine. Tous droits réservés.</p>
        </footer>

    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


<?php include '../includes/footer.php'; ?>
