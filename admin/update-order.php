<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php

            //Check whether id is set or not
            if(isset($_GET['id']))
            {
                //Get the Order Details
                $id = $_GET['id'];

                //Get all other details based on this id
                //SQL Query to get the order datails
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                //Excute Query
                $res = mysqli_query($conn, $sql);
                //Count Rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Detail Available
                    $row = mysqli_fetch_assoc($res);

                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];


                }
                else
                {
                    //Detail not Available
                    //Redirect to Manage Order
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //Redirect to Manage Order page
                header('location:'.SITEURL.'admin/manage-order.php');
            }

        ?>

        <form action="" method="post">

            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <td><?php echo $food; ?></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <td><?php echo $price; ?></td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" id="" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php echo $selected = ($status == "Ordered") ? "selected" : ""; ?> value="Ordered">Ordered</option>
                            <option <?php echo $selected = ($status == "On Delivery") ? "selected" : ""; ?> value="On Delivery">On Delivery</option>
                            <option <?php echo $selected = ($status == "Delivered") ? "selected" : ""; ?> value="Delivered">Delivered</option>
                            <option <?php echo $selected = ($status == "Cancelled") ? "selected" : ""; ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="email" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" id="" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" class="btn btn-secondary" value="Update Order">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 

    if(isset($_POST['submit']))
    {
        //Get All the values from form
        $id = $_POST['id'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $total = $price * $qty;
        $status = $_POST['status'];
        $customer_name = $_POST['customer_name'];
        $customer_contact = $_POST['customer_contact'];
        $customer_email = $_POST['customer_email'];
        $customer_address = $_POST['customer_address'];

        //Update the values
        $sql = "UPDATE tbl_order SET
        qty = $qty,
        total = $total,
        status = '$status',
        customer_name = '$customer_name',
        customer_contact = '$customer_contact',
        customer_email = '$customer_email',
        customer_address = '$customer_address' WHERE id = $id";

        //Excute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether update or not
        //And redirect to Manage order with Message
        if($res == true)
        {
            $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-order.php');
        }
        else
        {
            //Failed to Update
            $_SESSION['update'] = "<div class='error'>Failed to Update</div>";
            header('location:'.SITEURL.'admin/manage-order.php');
        }
    }
    else
    {

    }
?>


<?php include('partials/footer.php'); ?>