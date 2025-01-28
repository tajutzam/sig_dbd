<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Puskesmas</h1>
            <div class="d-flex justify-content-between">
                <div><a href="<?= base_url('/admin/puskesmas/create'); ?>" class="btn btn-primary btm-sm">Tambah Puskesmas</a></div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">dashboard</li>
                    <li class="breadcrumb-item active">Puskesmas</li>
                </ol>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kecamatan</th>
                                    <th>Nama Puskesmas</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($puskesmas as $item) : ?>
                                    <tr>
                                        <td style="width: 100px;"><?= $no; ?></td>
                                        <td><?= $item['nama_kecamatan']; ?></td>
                                        <td><?= $item['nama_puskesmas']; ?></td>
                                        <td><?= $item['latitude']; ?></td>
                                        <td><?= $item['longitude']; ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="<?= base_url('/admin/puskesmas/edit/' . $item['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="" class="btn btn-sm btn-danger">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->include('/templates/footer.php'); ?>