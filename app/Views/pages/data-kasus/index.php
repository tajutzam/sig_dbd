<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Kasus DBD</h1>
            <div class="d-flex justify-content-between">
                <div class="d-flex gap-2">
                    <div><a href="<?= base_url('/admin/dbd/create'); ?>" class="btn btn-primary btn-sm">Tambah Data Kasus DBD</a></div>
                    <div>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Export Data
                        </button>
                    </div>
                </div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">dashboard</li>
                    <li class="breadcrumb-item active">Kasus DBD</li>
                </ol>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Nama Puskesmas</th>
                                    <th>Jumlah Penduduk</th>
                                    <th>Jumlah Kasus</th>
                                    <th>Jumlah Kematian</th>
                                    <th>Jumlah Rumah Diperiksa</th>
                                    <th>Jumlah Rumah Bebas Jentik</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($kasus_dbd as $item) : ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>
                                            <span class="badge text-bg-secondary">
                                                <?= $item['tahun'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-secondary">
                                                <?= $item['nama_puskesmas'] ?>
                                            </span>
                                        </td>
                                        <td><?= $item['jumlah_penduduk'] ?></td>
                                        <td><?= $item['jumlah_kasus'] ?></td>
                                        <td><?= $item['jumlah_kematian'] ?></td>
                                        <td><?= $item['jumlah_rumah_diperiksa'] ?></td>
                                        <td><?= $item['jumlah_rumah_bebas_jentik'] ?></td>
                                        <td style="width: 200px;">
                                            <div class="d-flex gap-2">
                                                <a href="<?= base_url('/admin/dbd/edit/' . $item['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="<?= base_url('/admin/dbd/delete/' . $item['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $no++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('/admin/dbd/export'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Export Data Kasus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun" class="form-label"><i class="fas fa-calendar-alt"></i> Tahun</label>
                        <select name="tahun" class="form-select" id="tahun">
                            <?php foreach ($tahun as $item) : ?>
                                <option value="<?= $item['id']; ?>"><?= $item['tahun']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-file-alt"></i> Pilih Format</label>
                        <div class="form-check">
                            <input type="radio" name="tipe" id="pdf" class="form-check-input" value="pdf">
                            <label for="pdf" class="form-check-label"><i class="fas fa-file-pdf text-danger"></i> PDF</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="tipe" id="excel" class="form-check-input" value="excel">
                            <label for="excel" class="form-check-label"><i class="fas fa-file-excel text-success"></i> Excel</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->include('/templates/footer.php'); ?>