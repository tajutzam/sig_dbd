<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mt-4">Tambah Data Kasus DBD</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin'); ?>">dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/admin/dbd'); ?>">data kasus dbd</a>
                    </li>
                    <li class="breadcrumb-item active">tambah kasus dbd</li>
                </ol>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('/admin/dbd/store'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="tahun_id" class="form-label">Tahun</label>
                            <select name="tahun_id" class="form-control" required>
                                <option>Pilih Tahun</option>
                                <?php foreach ($tahun as $item) : ?>
                                    <option value="<?= $item['id']; ?>"><?= $item['tahun']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="puskesmas_id" class="form-label">Nama Puskesmas</label>
                            <select name="puskesmas_id" class="form-control" required>
                                <option>Pilih Puskesmas</option>
                                <?php foreach ($puskesmas as $item) : ?>
                                    <option value="<?= $item['id']; ?>"><?= $item['nama_puskesmas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_penduduk" class="form-label">Jumlah Penduduk</label>
                            <input type="number" class="form-control" name="jumlah_penduduk" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_kasus" class="form-label">Jumlah Kasus</label>
                            <input type="number" class="form-control" name="jumlah_kasus" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_kematian" class="form-label">Jumlah Kematian</label>
                            <input type="number" class="form-control" name="jumlah_kematian" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_rumah_diperiksa" class="form-label">Jumlah Rumah Diperiksa</label>
                            <input type="number" class="form-control" name="jumlah_rumah_diperiksa" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_rumah_bebas_jentik" class="form-label">Jumlah Rumah Bebas Jentik</label>
                            <input type="number" class="form-control" name="jumlah_rumah_bebas_jentik" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('/admin/kasus_dbd'); ?>" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->include('/templates/footer.php'); ?>