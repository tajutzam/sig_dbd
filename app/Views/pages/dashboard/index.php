<?= $this->include('templates/header.php'); ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-end">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Web Admin</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="" method="get">
                        <select name="tahun" class="form-select" id="tahun_filter" onchange="this.form.submit()">
                            <?php foreach ($tahun as $item) : ?>
                                <option
                                    <?php if ($item['tahun'] == $tahunRequest) : ?>
                                    selected
                                    <?php endif ?>
                                    value="<?= $item['tahun']; ?>"><?= $item['tahun']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row mt-4">
                <!-- Chart 1 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Data Kasus Kematian
                        </div>
                        <div class="card-body">
                            <canvas id="chart1" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 2 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            ABJ
                        </div>
                        <div class="card-body">
                            <canvas id="chart2" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 3 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            IR
                        </div>
                        <div class="card-body">
                            <canvas id="chart3" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 4 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            CFR
                        </div>
                        <div class="card-body">
                            <canvas id="chart4" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const dataKasus = <?= json_encode($kasus) ?>;

    // Mengambil data untuk grafik
    const labels = dataKasus.map(item => item.nama_kecamatan);
    const jumlahKasus = dataKasus.map(item => parseInt(item.jumlah_kasus));
    const jumlahKematian = dataKasus.map(item => parseInt(item.jumlah_kematian));
    const abj = dataKasus.map(item => parseFloat(item.ABJ)); // Data ABJ
    const ir = dataKasus.map(item => parseFloat(item.IR)); // Data IR
    const cfr = dataKasus.map(item => parseFloat(item.CFR)); // Data CFR

    // Konfigurasi grafik untuk Data Kasus Kematian
    const config1 = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Jumlah Kasus DBD',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: jumlahKasus,
                },
                {
                    label: 'Jumlah Kematian',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    data: jumlahKematian,
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Inisialisasi grafik untuk Data Kasus Kematian
    const chart1 = new Chart(document.getElementById('chart1'), config1);

    // Grafik ABJ
    const config2 = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'ABJ',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: abj,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    const chart2 = new Chart(document.getElementById('chart2'), config2);

    // Grafik IR
    const config3 = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'IR',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1,
                data: ir,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    const chart3 = new Chart(document.getElementById('chart3'), config3);

    // Grafik CFR
    const config4 = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'CFR',
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1,
                data: cfr,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    const chart4 = new Chart(document.getElementById('chart4'), config4);
</script>


<?= $this->include('templates/footer.php'); ?>