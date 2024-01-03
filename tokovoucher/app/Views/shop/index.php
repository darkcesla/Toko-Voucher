<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Voucher</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <br><br><h1>Waduhhh Belanja Tapi Dapet Voucher!</h1>
        <h3>Kapan lagi!</h3>
        <p>Saldo Saya: Rp. <?= number_format($balance, 0, ',', '.') ?></p>
        <?php if ($voucherAmount > 0): ?>
        <p>Voucher Saya: Rp. <?= number_format($voucherAmount, 2) ?></p>
        <p>Batas Penggunaan: <?= date('d M Y H:i:s', strtotime($voucherExpiration)) ?></p>
        <?php endif; ?>
        <div style="text-align: right;">
        <a href="<?= site_url('shop/viewCart') ?>" class="btn btn-info">Keranjang Saya</a>
        </div><br>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text">Stok: <?= $product['qty'] ?></p>
                            <p class="card-text">Harga: <?= $product['price'] ?></p>
                            <a href="<?= site_url('shop/addProductToCart/' . $product['id']) ?>" class="btn btn-primary" onclick="addToCart(<?= $product['id'] ?>)">Keranjangkan</a>
                            <a href="#" class="btn btn-success">Beli</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <script>
    function addToCart(productId) {
        $.ajax({
            url: '<?= site_url('shop/addProductToCart/') ?>' + productId,
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk Anda dimasukkan ke Keranjang.',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Ada kesalahan!',
                });
            }
        });
    }
</script>
</body>
</html>
    <?php if (session()->get('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= session()->get('success') ?>',
            });
        </script>
    <?php endif; ?>
    <?php if (session()->get('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= session()->get('error') ?>',
            });
        </script>
    <?php endif; ?>