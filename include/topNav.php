<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <?php
                $pageantName = isset($fetchSettings['pageant_name']) && $fetchSettings['pageant_name'] !== '' ? htmlspecialchars($fetchSettings['pageant_name']) : 'Pageant';
            ?>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0 ms-2 border border-secondary" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <div class="mx-auto d-flex align-items-center">
                <img src="../assets/img/<?=$logo?>" alt="Logo" height="40" class="me-2">
                <span class="text-warning fw-bold" style="font-size: 1rem;"><?= $pageantName ?></span>
            </div>
</nav>