<?= $this->include('/templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data tahun</h1>
            <div class="d-flex justify-content-between">
                <div><a href="<?= base_url('/admin/tahun/create'); ?>" class="btn btn-primary btm-sm">Tambah Tahun</a></div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">dashboard</li>
                    <li class="breadcrumb-item active">Tahun</li>
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($tahun as $item) : ?>
                                    <tr>
                                        <td style="width: 100px;"><?= $no ?></td>
                                        <td>
                                            <span class="badge text-bg-secondary">
                                                <?= $item['tahun'] ?>
                                            </span>
                                        </td>
                                        <td style="width: 200px;">
                                            <div class="d-flex gap-2">
                                                <a href="<?= base_url('/admin/tahun/edit/' . $item['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="<?= base_url('/admin/tahun/delete/' . $item['id']); ?>" class="btn  btn-danger btm-sm">Delete</a>
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