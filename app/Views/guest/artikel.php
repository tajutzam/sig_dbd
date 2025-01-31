<?= $this->include('templates/header_user.php'); ?>

<div class="container py-5">

    <style>
        .card-text {
            max-height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
    </style>
    <div class="row justify-content-center">
        <?php foreach ($artikel as $item) : ?>
            <div class="col-md-6 col-lg-5 mb-4">
                <div class="card">
                    <div class="card-body text-center" style="background-color: rgba(217, 217, 217, 1); color: black;">
                        <h5 class="card-title fw-bold"><?= $item['judul']; ?></h5>
                        <img src="<?= base_url('/uploads/') . $item['image']; ?>" class="img-fluid mb-3" alt="Gejala DBD">
                        <p><small><?= $item['author']; ?> - <?= $item['updated_at']; ?></small></p>
                        <p class="card-text"><?= $item['description']; ?></p>
                        <a href="#" class="btn btn-read btn-primary">READ MORE</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>


<?= $this->include('templates/footer_user.php'); ?>