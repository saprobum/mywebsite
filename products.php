<?php
require 'db.php'; // session already started inside here

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$errors = [];
$editProduct = null;

// Determine action: list (default), create, edit
$action = $_GET['action'] ?? 'list';

// ---------- HANDLE DELETE ----------
if ($action === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $userId]);
    header('Location: products.php');
    exit;
}

// ---------- HANDLE CREATE / UPDATE (POST) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $productId = $_POST['product_id'] ?? null;

    if ($name === '') $errors[] = "Product name is required.";
    if (!is_numeric($price) || $price < 0) $errors[] = "Price must be a valid number.";
    if (!is_numeric($stock) || $stock < 0) $errors[] = "Stock must be a valid number.";

    if (empty($errors)) {
        if ($productId) {
            // UPDATE — only if it belongs to this user
            $stmt = $pdo->prepare(
                "UPDATE products SET name = ?, description = ?, price = ?, stock = ?
                 WHERE id = ? AND user_id = ?"
            );
            $stmt->execute([$name, $description, $price, $stock, $productId, $userId]);
        } else {
            // CREATE
            $stmt = $pdo->prepare(
                "INSERT INTO products (user_id, name, description, price, stock)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$userId, $name, $description, $price, $stock]);
        }
        header('Location: products.php');
        exit;
    }
}

// ---------- LOAD PRODUCT FOR EDIT ----------
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $userId]);
    $editProduct = $stmt->fetch();
    if (!$editProduct) {
        header('Location: products.php');
        exit;
    }
}

// ---------- FETCH ALL PRODUCTS FOR THIS USER ----------
$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$products = $stmt->fetchAll();

$showForm = ($action === 'create' || $action === 'edit');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="dashboard.php" class="font-bold text-gray-800">← Dashboard</a>
            <a href="logout.php" class="text-sm text-red-600 hover:underline">Logout</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Your Products</h1>
            <?php if (!$showForm): ?>
                <a href="products.php?action=create"
                    class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition">
                    + Add Product
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($errors)): ?>
            <ul class="text-red-600 bg-red-50 border border-red-200 rounded px-3 py-2 mb-4 text-sm space-y-1">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($showForm): ?>
            <!-- CREATE / EDIT FORM -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <?= $action === 'edit' ? 'Edit Product' : 'Add New Product' ?>
                </h2>
                <form method="POST" action="products.php" class="space-y-4">
                    <?php if ($editProduct): ?>
                        <input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>">
                    <?php endif; ?>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name"
                            value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <input type="number" step="0.01" name="price"
                                value="<?= htmlspecialchars($editProduct['price'] ?? '') ?>"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" name="stock"
                                value="<?= htmlspecialchars($editProduct['stock'] ?? '') ?>"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                            <?= $action === 'edit' ? 'Update Product' : 'Save Product' ?>
                        </button>
                        <a href="products.php" class="text-gray-500 text-sm px-4 py-2 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <!-- PRODUCT LIST -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <?php if (empty($products)): ?>
                <p class="text-gray-500 text-center py-8">No products yet. Add your first one above.</p>
            <?php else: ?>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Stock</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800"><?= htmlspecialchars($product['name']) ?></div>
                                    <div class="text-gray-400 text-xs"><?= htmlspecialchars($product['description']) ?></div>
                                </td>
                                <td class="px-4 py-3">$<?= number_format($product['price'], 2) ?></td>
                                <td class="px-4 py-3"><?= (int)$product['stock'] ?></td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="products.php?action=edit&id=<?= $product['id'] ?>"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <a href="products.php?action=delete&id=<?= $product['id'] ?>"
                                        onclick="return confirm('Delete this product?')"
                                        class="text-red-600 hover:underline">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
