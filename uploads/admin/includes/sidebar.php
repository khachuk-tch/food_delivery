
<!-- Sidebar -->
<style>
.sidebar {
    position: fixed;
    top: 60px; /* below header */
    left: 0;
    width: 250px;
    height: calc(100vh - 60px);
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    color: #fff;
    padding: 1rem;
    transition: 0.3s ease;
    z-index: 2000;
}
.sidebar a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 8px 12px;
    border-radius: 6px;
    margin: 6px 0;
}
.sidebar a:hover {
    background-color: rgba(255,255,255,0.2);
}
.main-content {
    margin-left: 250px;
    margin-top: 70px;
    padding: 20px;
}
@media (max-width: 992px) {
    .sidebar {
        left: -260px;
        position: fixed;
    }
    .sidebar.show {
        left: 0;
    }
    .main-content {
        margin-left: 0;
    }
}
.toggle-btn {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 3500;
    background-color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
@media (min-width: 993px) {
    .toggle-btn {
        display: none;
    }
}
</style>

<button class="toggle-btn" id="toggleSidebar"><i class="bi bi-list"></i></button>

<div class="sidebar" id="sidebarMenu">
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="add_food.php"><i class="bi bi-plus-square"></i> Add Food Item</a>
    <a href="manage_food_items.php"><i class="bi bi-pencil-square"></i> Edit Food</a>
    <a href="manage_orders.php"><i class="bi bi-list-ul"></i> Manage Orders</a>
    <a href="user_details.php"><i class="bi bi-people"></i> User Details</a>
</div>

<script>
document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.getElementById('sidebarMenu').classList.toggle('show');
});
</script>


