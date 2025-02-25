<?php include('partials/menu.php') ?>
        <div class="main">
            <h1>Dashboard</h1>
            <br/>
            <?php 
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; // Display session message
                    unset($_SESSION['login']); // Remove session message                
                }
            ?>
            <br/>
            <div class="block_container">
                <div class="block">
                    5
                </div>
                <div class="block">
                    5
                </div>
                <div class="block">
                    5
                </div>
                <div class="block">
                    5
                </div>
            </div>
        </div>
<?php include('partials/footer.php') ?>
    