<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="<?= base_url('/css/styles.css'); ?>" rel="stylesheet" />

    <style>
        body {
            background-color: rgba(255, 246, 180, 0.84);
        }
    </style>

</head>

<body>
    <main class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card" style="width: 90%; height: 600px;">
            <div class="card-header" style="background-color: rgba(242, 245, 200, 0.69);">
                <h1 class="text-center py-4" style="font-weight: bold;">MASUK DASHBOARD ADMIN</h1>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center" style="background-color: rgba(216, 212, 183, 1)">
                <div class="w-50">
                    <form action="" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-4">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukan Username">
                        </div>
                        <div class="mb-4">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukan Username">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-5 font-weight-bold">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastBody">
                    Success message here!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('/js/scripts.js'); ?>"></script>
    <script>
        // Check for server flash messages
        <?php if (session()->getFlashdata('success')) : ?>
            showToast('<?= session()->getFlashdata('success') ?>', 'success');
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            showToast('<?= session()->getFlashdata('error') ?>', 'danger');
        <?php endif; ?>

        // Toast function
        function showToast(message, type) {
            const toastEl = document.getElementById('toastMessage');
            const toastBody = document.getElementById('toastBody');

            // Set the message and background color
            toastBody.textContent = message;
            toastEl.classList.remove('bg-success', 'bg-danger');
            toastEl.classList.add(`bg-${type}`);

            // Initialize and show toast
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    </script>
</body>

</html>