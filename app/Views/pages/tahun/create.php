<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Tahun</h1>
            <div class="d-flex justify-content-end">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin'); ?>">dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin/tahun'); ?>">tahun</a>
                    </li>
                    <li class="breadcrumb-item active">tambah tahun</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('/admin/tahun/store'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="kode_wilayah" class="form-label">Tahun</label>
                            <input type="number" class="form-control" name="tahun" id="tahun" required min="1900" max="2100">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('/admin/kecamatan'); ?>" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->include('/templates/footer.php'); ?>