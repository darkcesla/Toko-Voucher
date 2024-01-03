<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <br><br><h1>Keranjang Saya</h1>
        <?php if (empty($cart)): ?>
            <h4>Keranjang mu kosong! Ayo Belanja Sekarang!</h4>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga per satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            $total = 0;
            foreach ($cart as $productId => $item):
                $subTotal = $item['price'] * $item['qty'];
                $total += $subTotal; // Akumulasi total
            ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td>Rp. <?= number_format($item['price'], 2, ',', '.') ?></td>
                    <td>Rp. <?= number_format($subTotal, 2, ',', '.') ?></td>
                    <td><a href="<?= site_url('shop/removeProductFromCart/' . $productId) ?>" class="btn btn-danger" onclick="removeFromCart(<?= $productId ?>)">Hapus</a></td>
                </tr>
            <?php endforeach; ?>

            <!-- Tampilkan total -->
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td>Rp. <?= number_format($total, 2, ',', '.') ?></td>
                <td>
                <form id="useVoucherForm" action="<?= site_url('shop/useVoucher') ?>" method="post">
                    <button type="button" class="btn btn-success" onclick="useVoucher()">Gunakan Voucher</button>
                </form>
                </td>
            </tr>

        </tbody>
    </table>
            <a href="<?= site_url('shop/checkout') ?>" class="btn btn-primary">Checkout</a>
        <?php endif; ?>
        <a href="<?= site_url('/') ?>" class="btn btn-secondary">Kembali</a>
    </div>

    <script>
    function removeFromCart(productId) {
        $.ajax({
            url: '<?= site_url('shop/removeProductFromCart/') ?>' + productId,
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    location.reload();
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
                    text: 'Something went wrong.',
                });
            }
        });
    }
</script>
<script>
    function useVoucher() {
            if (result.isConfirmed) {
                document.getElementById('useVoucherForm').submit();
            }
    }
</script>
</body>
</html>
