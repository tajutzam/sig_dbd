<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Kasus DBD</h1>
            <div class="d-flex justify-content-between">
                <div><a href="<?= base_url('/admin/dbd/create'); ?>" class="btn btn-primary btn-sm">Tambah Data Kasus DBD</a></div>
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
<?= $this->include('/templates/footer.php'); ?>