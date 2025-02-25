<?php include('partials/menu.php'); ?>

<div class="main">
    <h1>Add Admin</h1>
    </br>


    <form action="" method="POST">
        <table>
            <tr>
                <td>Title: </td>
                <td><input type="text" name="title" placeholder="Enter title"></td>
            </tr>
            <tr>
                <td>Feature: </td>
                <td><input type="radio" name="feature" value="Yes">Yes</td>
                <td><input type="radio" name="feature" value="No">No</td>
            </tr>
            <tr>
                <td>Active: </td>
                <td><input type="radio" name="active" value="Yes">Yes</td>
                <td><input type="radio" name="active" value="No">No</td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Add Category" class="btn-primary"></td>
            </tr>
        </table>
    </form>
    <?php
        if(isset($_POST['submit'])){
            echo "click";
        }
    ?>
</div>
<?php include('partials/footer.php') ?>