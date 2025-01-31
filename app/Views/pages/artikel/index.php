<?= $this->include('templates/header.php'); ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Artikel</h1>
            <div class="d-flex justify-content-between">
                <div>
                    <a href="<?= base_url('/admin/artikel/create'); ?>" class="btn btn-primary btn-sm">Tambah Artikel</a>
                </div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Artikel</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Image</th>
                                    <th>Author</th>
                                    <th>Description</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($artikels as $item) : ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $item['judul']; ?></td>
                                        <td>
                                            <?php if ($item['image']) : ?>
                                                <img src="<?= base_url('uploads/' . $item['image']); ?>" alt="Image" style="width: 100px; height: auto;">
                                            <?php else : ?>
                                                <span>No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $item['author']; ?></td>
                                        <td><?= substr($item['description'], 0, 100) . '...'; ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="<?= base_url('/admin/artikel/edit/' . $item['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="<?= base_url('/admin/artikel/delete/' . $item['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $no++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->include('templates/footer.php'); ?>