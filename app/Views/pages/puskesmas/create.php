<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Puskesmas</h1>
            <div class="d-flex justify-content-end">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin'); ?>">dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin/puskesmas'); ?>">Puskesmas</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Puskesmas</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('/admin/puskesmas/store'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="kode_wilayah" class="form-label">Kecamatan</label>
                            <select name="kecamatan_id" class="form-control" required>
                                <option>Pilih Kecamatan</option>
                                <?php foreach ($kecamatan as $item) : ?>
                                    <option value="<?= $item['id']; ?>"><?= $item['nama_kecamatan']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Nama Puskesmas</label>
                            <input type="text" class="form-control" name="nama_puskesmas" required>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Masukkan Latitude" required>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Masukkan Longitude" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('/admin/puskesmas'); ?>" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->include('/templates/footer.php'); ?>