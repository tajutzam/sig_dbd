<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Kecamatan</h1>
            <div class="d-flex justify-content-end">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin'); ?>">dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin/kecamatan'); ?>">Kecamatan</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah kecamatan</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('/admin/kecamatan/store'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="kode_wilayah" class="form-label">Kode Wilayah</label>
                            <input type="text" class="form-control" id="kode_wilayah" name="kode_wilayah" placeholder="Masukkan Kode Wilayah" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kecamatan" class="form-label">Nama Kecamatan</label>
                            <input type="text" class="form-control" id="nama_kecamatan" name="nama_kecamatan" placeholder="Masukkan Nama Kecamatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="file_geojson" class="form-label">File GeoJSON</label>
                            <input type="file" class="form-control" id="file_geojson" name="file_geojson" accept=".geojson" required>
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
                            <a href="<?= base_url('/admin/kecamatan'); ?>" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->include('/templates/footer.php'); ?>