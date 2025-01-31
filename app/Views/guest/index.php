<?= $this->include('/templates/header_user.php'); ?>

<main class="min-vh-100 d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row g-3">
            <!-- Left Column (Card 1) -->
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="card px-3 py-3" style="background-color: rgba(246, 230, 109, 1);">
                    <h4 class="font-weight-bold">Demam Berdarah</h4>
                    <p>
                        Demam Berdarah adalah penyakit yang disebabkan oleh infeksi virus Dengue dan ditularkan melalui gigitan nyamuk <i>Aedes aegypti</i>. Apabila tidak ditangani dengan tepat, maka penyakit demam berdarah dapat berisiko mengancam nyawa.
                    </p>
                </div>
            </div>

            <!-- Right Column (Image) -->
            <div class="col-12 col-md-6 text-center text-md-end">
                <img src="/nyamuk.jpeg" alt="Nyamuk" class="img-fluid" style="max-height: 300px;">
            </div>

            <!-- Left Column (Card 2) -->
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="card px-3 py-3" style="background-color: rgba(246, 230, 109, 1);">
                    <h4 class="font-weight-bold">Visi Misi</h4>
                    <p class="text-justify">
                        Sistem pemetaan ini berfungsi untuk melihat wilayah mana yang penyebaran kasus penyakit DBD tertinggi sehingga diharapkan dapat upaya untuk mengurangi atau mencegah risiko terjadinya penularan DBD dengan efektif, efisien dan tepat sasaran.
                    </p>
                </div>
            </div>

            <!-- Right Column (Button) -->
            <div class="col-12 col-md-6 text-center text-md-end">
                <a href="<?= base_url('/pemetaan'); ?>" class="btn" style="background-color: rgba(98, 166, 222, 1);">
                    <div class="d-flex gap-3 align-items-center justify-content-center justify-content-md-end">
                        <h5 class="text-white mb-0">
                            Lihat Peta Penyebaran DBD
                        </h5>
                        <img src="/next.png" alt="Next" height="30px">
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?= $this->include('/templates/footer_user.php'); ?>