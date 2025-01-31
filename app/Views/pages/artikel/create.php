<?= $this->include('templates/header.php'); ?>

<div id="layoutSidenav_content">

    <main>
        <div class="container mt-5">
            <h2>Tambah Artikel</h2>
            <form action="<?= base_url('/admin/artikel/store'); ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul'); ?>" required>
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
                </div>

                <div class="form-group mb-3">
                    <label for="author">Author</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?= old('author'); ?>" required>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('author') : ''; ?>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required><?= old('description'); ?></textarea>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('description') : ''; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </main>
</div>

<?= $this->include('templates/footer.php'); ?>