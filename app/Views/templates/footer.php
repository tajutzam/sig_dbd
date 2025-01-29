</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('/js/scripts.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url('/js/datatables-simple-demo.js'); ?>"></script>


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