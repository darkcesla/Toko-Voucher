<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <p>Total Purchase: <?= number_format($totalPurchase, 0, ',', '.') ?> IDR</p>
        <p>Discount Amount: <?= number_format($discountAmount, 0, ',', '.') ?> IDR</p>

        <?php if ($voucher): ?>
            <p>Voucher Code: <?= $voucher['code'] ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
