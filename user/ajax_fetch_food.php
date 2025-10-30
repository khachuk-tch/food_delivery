<?php
//require '../config.php';

require_once __DIR__ . '/../includes/config.php'; 

$search = $_POST['search'] ?? '';
$category = $_POST['category'] ?? '';

$query = "SELECT * FROM food_items WHERE 1";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query .= " AND food_name LIKE '%$search%'";
}
if (!empty($category)) {
    $category = $conn->real_escape_string($category);
    $query .= " AND restaurant_name = '$category'";
}
$query .= " ORDER BY id DESC";

$result = $conn->query($query);

if ($result->num_rows > 0):
    while ($item = $result->fetch_assoc()):
?>
<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card h-100 shadow-sm">
        <img src="<?= !empty($item['image']) ? "../uploads/{$item['image']}" : 'https://via.placeholder.com/300x150' ?>" class="card-img-top" alt="<?= $item['food_name'] ?>">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-2"><?= htmlspecialchars($item['food_name']) ?></h5>
            <h6 class="text-muted mb-2" style="font-size: 0.9rem;">
                <?= htmlspecialchars($item['restaurant_name']) ?> | <?= htmlspecialchars($item['availability']) ?>
            </h6>
            <p class="text-muted mb-2" style="font-size: 0.9rem;">
                Weight: <?= htmlspecialchars($item['weight']) ?>
            </p>
            <h5 class="price-tag mt-2 mb-3">₹<?= number_format($item['price'], 2) ?></h5>

            <?php if (strtolower($item['availability']) === 'available'): ?>
            <div class="d-flex gap-2 mt-auto">
                <!-- View Button -->
                <button class="btn btn-info w-50 viewBtn"
                    data-name="<?= htmlspecialchars($item['food_name']) ?>"
                    data-description="<?= htmlspecialchars($item['description']) ?>">
                    View
                </button>

                <!-- Add to Cart Button -->
                <button class="btn btn-primary w-50 add-to-cart addToCartBtn" data-id="<?= $item['id'] ?>">Add to Cart</button>
            </div>
            <?php else: ?>
            <button type="button" class="btn btn-danger mt-auto w-100" onclick="showUnavailableAlert()">Add to Cart</button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
    endwhile;
else:
    echo '<div class="col-12"><div class="alert alert-warning text-center">No food items found!</div></div>';
endif;
?>

<!-- Modal (Only one, outside the loop) -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">Food Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 id="foodName" class="fw-bold mb-2"></h4>
        <p id="foodDescription" class="text-muted"></p>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for handling View button -->
<script>
document.querySelectorAll('.viewBtn').forEach(button => {
    button.addEventListener('click', function() {
        const name = this.getAttribute('data-name');
        const description = this.getAttribute('data-description');

        document.getElementById('foodName').innerText = name;
        document.getElementById('foodDescription').innerText = description;

        var viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
        viewModal.show();
    });
});
</script>

