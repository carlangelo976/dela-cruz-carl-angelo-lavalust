<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 2rem; background: #f9fafb; }
        .card { background: #fff; max-width: 480px; padding: 1.5rem 2rem; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
        label { display: block; margin-bottom: .3rem; font-size: .9rem; font-weight: 600; }
        input, textarea { width: 100%; padding: .6rem; margin-bottom: 1rem; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: .6rem 1.2rem; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .back { display: inline-block; margin-bottom: 1rem; color: #555; text-decoration: none; }
    </style>
</head>
<body>
    <a class="back" href="<?= site_url('products') ?>">&larr; Back to products</a>
    <div class="card">
        <h1>Edit Product</h1>
        <form action="<?= site_url('products/edit/' . $product['id']) ?>" method="post">
            <label>Product Name</label>
            <input type="text" name="product_name" value="<?= html_escape($product['product_name']) ?>" required>

            <label>Description</label>
            <textarea name="description" rows="3"><?= html_escape($product['description']) ?></textarea>

            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= html_escape($product['price']) ?>" required>

            <label>Quantity</label>
            <input type="number" name="quantity" value="<?= html_escape($product['quantity']) ?>" required>

            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>