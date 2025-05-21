
<?php 
if (isset($_SESSION['status']) && $_SESSION['status'] !='') 
{
    ?>
        <script>

            let timerInterval
            Swal.fire({
            title: '<?php echo $_SESSION['status']; ?>',
            icon: '<?php echo $_SESSION['status_code']; ?>',
            timer: 1800,
            showConfirmButton: false,
            timerProgressBar: true,
            willClose: () => {
                clearInterval(timerInterval)
            }
            })

            </script>
    <?php
    unset($_SESSION['status']);
}
?>