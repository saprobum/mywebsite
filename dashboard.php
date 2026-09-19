<?php
require 'db.php'; // session already started inside here

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Quick stats for this user
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$productCount = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Top nav -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="font-bold text-gray-800">MyWebsite</span>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Hi, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="logout.php" class="text-sm text-red-600 hover:underline">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
        <p class="text-gray-500 mb-8">Here's what's happening with your account.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Stat card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-sm text-gray-500 mb-1">Your Products</p>
                <p class="text-3xl font-bold text-gray-800"><?= $productCount ?></p>
                <a href="products.php" class="text-blue-600 text-sm hover:underline mt-3 inline-block">Manage products →</a>
            </div>

            <!-- Quick action card -->
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Quick Action</p>
                    <p class="text-lg font-semibold text-gray-800">Add a new product</p>
                </div>
                <a href="products.php?action=create"
                    class="mt-4 inline-block bg-blue-600 text-white text-sm text-center py-2 rounded hover:bg-blue-700 transition">
                    + Add Product
                </a>
            </div>
        </div>
    </div>

</body>
</html>
