<?= $this->include('templates/header.php'); ?>

<div id="layoutSidenav_content">

    <main>
        <div class="container mt-5">
            <h2>Edit Artikel</h2>
            <form action="<?= base_url('/admin/artikel/update/' . $artikel['id']); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul', $artikel['judul']); ?>" required>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('judul') : ''; ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('image') : ''; ?>
                    </div>
                    <?php if ($artikel['image']) : ?>
                        <img src="<?= base_url('uploads/' . $artikel['image']); ?>" alt="current image" width="150" class="mt-3">
                    <?php endif; ?>
                    <input type="text" name="old_image" value="<?= $artikel['image']; ?>" hidden>
                </div>

                <div class="form-group mb-3">
                    <label for="author">Author</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?= old('author', $artikel['author']); ?>" required>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('author') : ''; ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required><?= old('description', $artikel['description']); ?></textarea>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('description') : ''; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </main>
</div>

<?= $this->include('templates/footer.php'); ?>