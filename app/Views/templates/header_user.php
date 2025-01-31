<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="<?= base_url('/css/styles.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('/map/leaflet.css'); ?>" />


    <style>
        body {
            background-color: rgba(248, 233, 192, 1);
        }

        .active {
            color: black;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <div class="d-flex gap-3 align-items-center">
                        <img src="/logo.png" alt="Logo" height="50">
                        <div class="d-flex flex-column align-items-start">
                            <h5 class="font-weight-bold" style="line-height: 1.1; font-weight: bold;">SIG DBD</h5>
                            <p class="font-weight-bold" style="font-size: 15px; margin-bottom: 0; font-weight: bold;">Kabupaten Probolinggo</p>
                        </div>
                    </div>

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="/" class="nav-link <?= (current_url() == base_url()) ? 'active' : '' ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a href="/pemetaan" class="nav-link <?= (current_url() == base_url('pemetaan')) ? 'active' : '' ?>">Pemetaan</a>
                        </li>
                        <li class="nav-item">
                            <a href="/artikel" class="nav-link <?= (current_url() == base_url('artikel')) ? 'active' : '' ?>">Artikel</a>
                        </li>
                    </ul>
                    <a href="<?= base_url('/login'); ?>" class="btn" style="background-color: rgba(98, 166, 222, 1); font-weight:bold">Login</a>
                </div>
            </div>
        </nav>
    </div>