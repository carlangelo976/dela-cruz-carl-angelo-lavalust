<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Products API</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1400px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* =========================
           HEADER
        ========================= */

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .top-bar h1 {
            margin: 0;
            color: #111827;
        }

        .logout-btn {
            display: inline-block;
            background: #dc3545;
            color: white;
            padding: 10px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #bb2d3b;
        }

        /* =========================
           STATUS
        ========================= */

        .status {
            font-size: 18px;
            margin-bottom: 25px;
        }

        .connected {
            color: green;
            font-weight: bold;
        }

        /* =========================
           API BUTTONS
        ========================= */

        .api-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .api-buttons button {
            border: none;
            padding: 12px 22px;
            border-radius: 7px;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-get {
            background: #198754;
        }

        .btn-post {
            background: #0d6efd;
        }

        .btn-put {
            background: #ffc107;
            color: #111 !important;
        }

        .btn-delete {
            background: #dc3545;
        }

        .api-buttons button:hover {
            opacity: 0.85;
        }

        /* =========================
           MESSAGE
        ========================= */

        #message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: none;
        }

        #resultMessage {
            margin-bottom: 15px;
        }

        /* =========================
           TABLE
        ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #343a40;
            color: white;
            padding: 15px;
            text-align: left;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .price {
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        /* =========================
           MODAL
        ========================= */

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: white;
            width: 450px;
            max-width: 90%;
            margin: 7% auto;
            padding: 30px;
            border-radius: 10px;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            height: 90px;
            resize: vertical;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-buttons button {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .submit-btn {
            background: #198754;
            color: white;
        }

        .cancel-btn {
            background: #6c757d;
            color: white;
        }

        .delete-confirm {
            background: #dc3545;
            color: white;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- =========================
         HEADER + LOGOUT
    ========================= -->

    <div class="top-bar">

        <h1>Products API</h1>

        <!-- CORRECT LOGOUT URL -->
        <a
            href="/index.php/logout"
            class="logout-btn"
        >
            Logout
        </a>

    </div>


    <!-- =========================
         API STATUS
    ========================= -->

    <div class="status">

        API Status:

        <span class="connected">
            Connected
        </span>

    </div>


    <!-- =========================
         API BUTTONS
    ========================= -->

    <div class="api-buttons">

        <button
            class="btn-get"
            onclick="loadProducts()"
        >
            GET
        </button>

        <button
            class="btn-post"
            onclick="openAddModal()"
        >
            POST
        </button>

        <button
            class="btn-put"
            onclick="openUpdateModal()"
        >
            PUT/PATCH
        </button>

        <button
            class="btn-delete"
            onclick="openDeleteModal()"
        >
            DELETE
        </button>

    </div>


    <!-- =========================
         MESSAGE
    ========================= -->

    <div id="message"></div>

    <h3 id="resultMessage"></h3>


    <!-- =========================
         PRODUCTS TABLE
    ========================= -->

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Created At</th>
            </tr>

        </thead>

        <tbody id="productsTable">

            <tr>

                <td colspan="6" class="empty">
                    Click GET to load products.
                </td>

            </tr>

        </tbody>

    </table>

</div>


<!-- =====================================================
     ADD PRODUCT MODAL
===================================================== -->

<div id="addModal" class="modal">

    <div class="modal-content">

        <h2>POST – Add Product</h2>

        <div class="form-group">

            <label>Product Name</label>

            <input
                type="text"
                id="addProductName"
            >

        </div>

        <div class="form-group">

            <label>Description</label>

            <textarea id="addDescription"></textarea>

        </div>

        <div class="form-group">

            <label>Price</label>

            <input
                type="number"
                id="addPrice"
            >

        </div>

        <div class="form-group">

            <label>Quantity</label>

            <input
                type="number"
                id="addQuantity"
            >

        </div>

        <div class="modal-buttons">

            <button
                class="submit-btn"
                onclick="addProduct()"
            >
                Add Product
            </button>

            <button
                class="cancel-btn"
                onclick="closeAddModal()"
            >
                Cancel
            </button>

        </div>

    </div>

</div>


<!-- =====================================================
     UPDATE PRODUCT MODAL
===================================================== -->

<div id="updateModal" class="modal">

    <div class="modal-content">

        <h2>PUT – Update Product</h2>

        <div class="form-group">

            <label>Product ID</label>

            <input
                type="number"
                id="updateId"
            >

        </div>

        <div class="form-group">

            <label>Product Name</label>

            <input
                type="text"
                id="updateProductName"
            >

        </div>

        <div class="form-group">

            <label>Description</label>

            <textarea id="updateDescription"></textarea>

        </div>

        <div class="form-group">

            <label>Price</label>

            <input
                type="number"
                id="updatePrice"
            >

        </div>

        <div class="form-group">

            <label>Quantity</label>

            <input
                type="number"
                id="updateQuantity"
            >

        </div>

        <div class="modal-buttons">

            <button
                class="submit-btn"
                onclick="updateProduct()"
            >
                Update Product
            </button>

            <button
                class="cancel-btn"
                onclick="closeUpdateModal()"
            >
                Cancel
            </button>

        </div>

    </div>

</div>


<!-- =====================================================
     DELETE PRODUCT MODAL
===================================================== -->

<div id="deleteModal" class="modal">

    <div class="modal-content">

        <h2>DELETE – Delete Product</h2>

        <div class="form-group">

            <label>Product ID</label>

            <input
                type="number"
                id="deleteId"
            >

        </div>

        <div class="modal-buttons">

            <button
                class="delete-confirm"
                onclick="deleteProduct()"
            >
                Delete Product
            </button>

            <button
                class="cancel-btn"
                onclick="closeDeleteModal()"
            >
                Cancel
            </button>

        </div>

    </div>

</div>


<script>

/* =====================================================
   API BASE URL
===================================================== */

const API_URL = "/index.php/api/products";


/* =====================================================
   SHOW MESSAGE
===================================================== */

function showMessage(message, success = true)
{
    const box = document.getElementById("message");

    box.style.display = "block";

    box.style.background =
        success ? "#d1e7dd" : "#f8d7da";

    box.style.color =
        success ? "#0f5132" : "#842029";

    box.innerText = message;
}


/* =====================================================
   GET PRODUCTS
===================================================== */

function loadProducts()
{
    fetch(API_URL)

        .then(response => {

            if (!response.ok) {
                throw new Error(
                    "HTTP Error " + response.status
                );
            }

            return response.json();
        })

        .then(result => {

            const table =
                document.getElementById("productsTable");

            table.innerHTML = "";


            if (!result.data || result.data.length === 0)
            {
                table.innerHTML = `
                    <tr>
                        <td colspan="6" class="empty">
                            No products found.
                        </td>
                    </tr>
                `;

                return;
            }


            result.data.forEach(product => {

                table.innerHTML += `
                    <tr>

                        <td>${product.id}</td>

                        <td>${product.product_name}</td>

                        <td>${product.description}</td>

                        <td class="price">
                            ₱${Number(product.price).toLocaleString(
                                'en-PH',
                                {
                                    minimumFractionDigits: 2
                                }
                            )}
                        </td>

                        <td>${product.quantity}</td>

                        <td>${product.created_at}</td>

                    </tr>
                `;

            });


            document.getElementById(
                "resultMessage"
            ).innerText = result.message;


            showMessage(
                "Products retrieved successfully.",
                true
            );

        })

        .catch(error => {

            showMessage(
                "Error loading products: " + error,
                false
            );

        });
}


/* =====================================================
   ADD PRODUCT
===================================================== */

function openAddModal()
{
    document.getElementById(
        "addModal"
    ).style.display = "block";
}


function closeAddModal()
{
    document.getElementById(
        "addModal"
    ).style.display = "none";
}


function addProduct()
{
    const data = {

        product_name:
            document.getElementById(
                "addProductName"
            ).value,

        description:
            document.getElementById(
                "addDescription"
            ).value,

        price:
            document.getElementById(
                "addPrice"
            ).value,

        quantity:
            document.getElementById(
                "addQuantity"
            ).value
    };


    fetch(API_URL, {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify(data)

    })

    .then(response => {

        if (!response.ok) {
            throw new Error(
                "HTTP Error " + response.status
            );
        }

        return response.json();
    })

    .then(result => {

        if (result.status)
        {
            showMessage(
                "Product added successfully.",
                true
            );

            closeAddModal();

            loadProducts();
        }
        else
        {
            showMessage(
                result.message ||
                "Failed to add product.",
                false
            );
        }

    })

    .catch(error => {

        showMessage(
            "Error: " + error,
            false
        );

    });
}


/* =====================================================
   UPDATE PRODUCT
===================================================== */

function openUpdateModal()
{
    document.getElementById(
        "updateModal"
    ).style.display = "block";
}


function closeUpdateModal()
{
    document.getElementById(
        "updateModal"
    ).style.display = "none";
}


function updateProduct()
{
    const id =
        document.getElementById(
            "updateId"
        ).value;


    if (!id)
    {
        showMessage(
            "Please enter Product ID.",
            false
        );

        return;
    }


    const data = {

        product_name:
            document.getElementById(
                "updateProductName"
            ).value,

        description:
            document.getElementById(
                "updateDescription"
            ).value,

        price:
            document.getElementById(
                "updatePrice"
            ).value,

        quantity:
            document.getElementById(
                "updateQuantity"
            ).value
    };


    fetch(
        API_URL + "/" + id,
        {
            method: "PUT",

            headers: {
                "Content-Type":
                    "application/json"
            },

            body: JSON.stringify(data)
        }
    )

    .then(response => {

        if (!response.ok) {
            throw new Error(
                "HTTP Error " + response.status
            );
        }

        return response.json();
    })

    .then(result => {

        if (result.status)
        {
            showMessage(
                "Product updated successfully.",
                true
            );

            closeUpdateModal();

            loadProducts();
        }
        else
        {
            showMessage(
                result.message ||
                "Failed to update product.",
                false
            );
        }

    })

    .catch(error => {

        showMessage(
            "Error: " + error,
            false
        );

    });
}


/* =====================================================
   DELETE PRODUCT
===================================================== */

function openDeleteModal()
{
    document.getElementById(
        "deleteModal"
    ).style.display = "block";
}


function closeDeleteModal()
{
    document.getElementById(
        "deleteModal"
    ).style.display = "none";
}


function deleteProduct()
{
    const id =
        document.getElementById(
            "deleteId"
        ).value;


    if (!id)
    {
        showMessage(
            "Please enter Product ID.",
            false
        );

        return;
    }


    if (!confirm(
        "Are you sure you want to delete Product ID "
        + id
        + "?"
    ))
    {
        return;
    }


    fetch(
        API_URL + "/" + id,
        {
            method: "DELETE",

            headers: {
                "Content-Type":
                    "application/json"
            }
        }
    )

    .then(response => {

        if (!response.ok) {
            throw new Error(
                "HTTP Error " + response.status
            );
        }

        return response.json();
    })

    .then(result => {

        if (result.status)
        {
            showMessage(
                "Product deleted successfully.",
                true
            );

            closeDeleteModal();

            loadProducts();
        }
        else
        {
            showMessage(
                result.message ||
                "Failed to delete product.",
                false
            );
        }

    })

    .catch(error => {

        showMessage(
            "Error: " + error,
            false
        );

    });
}


/* =====================================================
   CLOSE MODAL WHEN CLICKING OUTSIDE
===================================================== */

window.onclick = function(event)
{
    if (
        event.target.classList.contains("modal")
    )
    {
        event.target.style.display = "none";
    }
};

</script>

</body>

</html>