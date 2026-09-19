# MyWebsite — A Simple PHP Project 🚀

Hi! This is a small website built with plain PHP (no framework).
It has **Register**, **Login**, **Dashboard**, and **Products** pages.

Follow these steps ONE BY ONE. Don't skip any step!

---

## What You Need First

1. **XAMPP** installed on your computer.
   - Don't have it? Download from: https://www.apachefriends.org
2. That's it! XAMPP gives you everything else (PHP + MySQL).

---

## Step 1: Turn On the Engines 🔌

1. Open **XAMPP Control Panel**.
2. Find the row that says **Apache** → click **Start**.
3. Find the row that says **MySQL** → click **Start**.
4. Both rows should turn **green**. That means they are running.

---

## Step 2: Put Your Project in the Right Folder 📁

1. Open your XAMPP folder (usually `C:\xampp`).
2. Go inside the `htdocs` folder. Full path: `C:\xampp\htdocs`.
3. Create a new folder here called `mywebsite`.
4. Put ALL your project files inside this folder:
   - `db.php`
   - `register.php`
   - `login.php`
   - `dashboard.php`
   - `products.php`
   - `logout.php`
   - `schema.sql`
   - `seed.sql`
   - `seed_users.php`

---

## Step 3: Create the Database 🗄️

1. Open your web browser.
2. Go to this address: `http://localhost/phpmyadmin`
3. On the left side, click **New**.
4. Type the database name: `mywebsite`
5. Click **Create**.

---

## Step 4: Create the Tables (users & products) 🏗️

1. Make sure you're inside the `mywebsite` database (click it on the left if not).
2. Click the **Import** tab at the top.
3. Click **Choose File** and select `schema.sql` from your project folder.
4. Scroll down and click **Go**.
5. You should now see two tables: `users` and `products`. 🎉

---

## Step 5: Add Some Fake Users 👤

We can't add users through SQL directly because passwords need special "locking" (called hashing). So we run a tiny PHP page instead.

1. Open your browser.
2. Go to: `http://localhost/mywebsite/seed_users.php`
3. You should see 4 lines saying "Created: ...".
4. This means 4 users were added! Their password is: `password123`

**Important:** After this works once, don't run this page again (or you might get an error about duplicate emails — that's OK, it just means it already worked).

---

## Step 6: Add Some Fake Products 📦

1. Go back to `http://localhost/phpmyadmin`
2. Click on the `mywebsite` database.
3. Click the **Import** tab again.
4. Choose the file `seed.sql`.
5. Click **Go**.
6. Now you should have 8 products, split between the 4 users.

---

## Step 7: Try the Website! 🌐

1. Open your browser.
2. Go to: `http://localhost/mywebsite/login.php`
3. Type this to log in:
   - **Email:** `alice@example.com`
   - **Password:** `password123`
4. Click **Login**.
5. You should land on the **Dashboard** — it will say "Welcome back, Alice Johnson".

---

## Step 8: Explore! 🕹️

From the Dashboard, you can:

- Click **Manage products** → see Alice's 2 products.
- Click **+ Add Product** → add a brand new product.
- Click **Edit** on any product → change its name/price/stock.
- Click **Delete** on any product → remove it (it will ask "Are you sure?").
- Click **Logout** (top right) → this logs you out and sends you back to Login.

Try logging in as the other users too:
- `bob@example.com`
- `carol@example.com`
- `david@example.com`

(All passwords are `password123`)

---

## Something Not Working? 🔧

| Problem | Fix |
|---|---|
| Page says "Connection failed" | Make sure MySQL is **green/started** in XAMPP |
| Page is blank/white | Check for typos in the PHP file you edited last |
| "Table doesn't exist" error | Go back to Step 4, import `schema.sql` again |
| Can't log in | Make sure you ran Step 5 (`seed_users.php`) |
| Forgot the password | It's always `password123` for all 4 seed users |

---

## What Each File Does (Simple Explanation)

| File | What it does |
|---|---|
| `db.php` | Connects PHP to the MySQL database |
| `register.php` | Page to create a new account |
| `login.php` | Page to log in |
| `dashboard.php` | The "home" page after logging in |
| `products.php` | Add / Edit / Delete / View products |
| `logout.php` | Logs you out |
| `schema.sql` | Creates the `users` and `products` tables |
| `seed.sql` | Fills the `products` table with sample data |
| `seed_users.php` | Fills the `users` table with 4 sample accounts |

---

## Want to Start Fresh? 🔄

If you want to wipe everything and start over:

1. Go to phpMyAdmin → `mywebsite` database → **Import** tab.
2. Import `schema.sql` again (it deletes old tables and makes new empty ones).
3. Run Step 5 and Step 6 again to refill the data.

---

That's it! You now have a working PHP website with login, logout, and full product management. 🎉