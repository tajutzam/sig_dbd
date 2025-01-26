<?= $this->include('templates/header.php'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Kecamatan</h1>
            <div class="d-flex justify-content-between">
                <div>
                    <a href="" class="btn btn-primary btm-sm">Tambah Kecamatan</a>
                </div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">dashboard</li>
                    <li class="breadcrumb-item active">kecamatan</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Kode Wilayah
                                    </th>
                                    <th>
                                        Nama Kecamatan
                                    </th>
                                    <th>
                                        File Geojson
                                    </th>
                                    <th>
                                        Latitude
                                    </th>
                                    <th>
                                        Longtitude
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($kecamatans as $item) : ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $item['kode_wilayah']; ?></td>
                                        <td><?= $item['nama_kecamatan']; ?></td>
                                        <td><?= $item['file_geojson']; ?></td>
                                        <td><?= $item['longitude']; ?></td>
                                        <td><?= $item['latitude']; ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="" class="btn btn-warning btn-danger">Delete</a>
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
<?= $this->include('templates/footer.php'); ?>