<?= $this->include('templates/header_user.php'); ?>

<style>
    .hero {
        width: 100%;
        height: 300px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
        font-size: 2rem;
        font-weight: bold;
    }
</style>

<div class="hero" style="background-image: url('<?= base_url('/uploads/' . $artikel['image']); ?>');">
    <?= $artikel['judul']; ?>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p><small><strong><?= $artikel['author']; ?></strong> - <?= date('d M Y', strtotime($artikel['updated_at'])); ?></small></p>
            <p><?= $artikel['description']; ?></p>
        </div>
    </div>
</div>

<?= $this->include('templates/footer_user.php'); ?>