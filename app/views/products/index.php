<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 2rem; background: #f9fafb; color: #111; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
        th, td { padding: .7rem 1rem; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f3f4f6; }
        .btn { display: inline-block; padding: .4rem .8rem; border-radius: 4px; text-decoration: none; font-size: .85rem; }
        .btn-add { background: #2563eb; color: #fff; }
        .btn-edit { background: #f59e0b; color: #fff; margin-right: .4rem; }
        .btn-delete { background: #dc2626; color: #fff; }
        .btn-logout { color: #555; text-decoration: none; }
        .empty { padding: 2rem; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="topbar">
        <h1>Products</h1>
        <div>
            <a class="btn btn-add" href="<?= site_url('products/create') ?>">+ Add Product</a>
            <a class="btn-logout" href="<?= site_url('logout') ?>" style="margin-left:1rem;">Logout</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= html_escape($product['id']) ?></td>
                        <td><?= html_escape($product['product_name']) ?></td>
                        <td><?= html_escape($product['description']) ?></td>
                        <td><?= number_format((float) $product['price'], 2) ?></td>
                        <td><?= html_escape($product['quantity']) ?></td>
                        <td><?= html_escape($product['created_at']) ?></td>
                        <td>
                            <a class="btn btn-edit" href="<?= site_url('products/edit/' . $product['id']) ?>">Edit</a>
                            <a class="btn btn-delete" href="<?= site_url('products/delete/' . $product['id']) ?>"
                               onclick="return confirm('Delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="empty">No products yet. Add your first one.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>