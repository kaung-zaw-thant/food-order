<?php 
include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        
        <!-- Add Category form Starts -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" id="" placeholder="Category Title"></td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" id="image">
                        <!-- <input type="file" accept="image/*"> -->
                    </td>
                    <td><img src="" alt="" class="img-category"></td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" id="" value="Yes"> Yes 
                        <input type="radio" name="featured" id="" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" id="" value="Yes">Yes
                        <input type="radio" name="active" id="" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" id="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <!-- Add Category form Ends -->

        <?php 
            //Check whether the Submit Button is Clicked or not
            if(isset($_POST['submit']))
            {
                //1. Get the value from category form
                $title = $_POST['title'];
                //For Radio input, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    //set the default value
                    $active = "No";
                }


                //Check whethr the image is selected or not and set the value for image name according
                //print_r($_FILES['image']);

                if($_FILES['image']['name'] != "")
                {
                    //Upload the Image
                    //To upload image we need image name , source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //Auto Rename our Image
                    //Get the Extension of our image(jpg, png, gif, etc) e.g. "special.food.jpg"
                    $ext = end(explode('.', $image_name));

                    //Rename the Image
                    $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. Food_Category_001.jpg



                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    //Finally Upload the Image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //Check whether the image is uploaded or not
                    //And if the image is not uploaded then we will stop the process and redirect with error message
                     if(!$upload)
                     {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                     }
                }
                else
                {
                    //Don't Upload Image and set the image_name value as blank
                    $image_name = "";
                }

                // 2. Create SQL Query to Inset Category into Database
                $sql = "INSERT INTO tbl_category SET 
                title='$title',image_name='$image_name',featured='$featured',active='$active'";

                // 3.Excute the Query and Save in Database
                $res = mysqli_query($conn, $sql);

                //4. Check whether the query or not and data added or not
                if($res)
                {
                    //Query Excuted and Category Added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    //Redirect to Manage Category Page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
                else
                {
                    //Failed to Add Category
                    $_SESSION['add'] ="<div class='error'>Failed to add Category</div>";
                    //Redirect to Add Category Page
                    header('location:'.SITEURL.'admin/manage-category.php');

                }
            }
            else
            {

            }
        ?>
    </div>
</div>

<!-- Save Image to Google Drive -->

<script>
        let url = "https://script.google.com/macros/s/AKfycbzb1ZtThJW3acxIWKL9m9tqXzA9_48D4RBi777wH2n7EABU08B0mA-kEPQkomdEGuynGQ/exec";
        //let file = document.querySelector("input");
        let file = document.getElementById("image");
        let img = document.querySelector("img");
        let btn = document.getElementById("submit");

    
        file.addEventListener('change',() => {

            let fr = new FileReader();
            
            fr.addEventListener('loadend',() => {
                
                let res = fr.result;
                img.src = res;

                let spt = res.split("base64,")[1];
                var obj = {
                    base64:spt,
                    type:file.files[0].type,
                    name:file.files[0].name,
                }

                fetch(url,{
                    method: "POST",
                    body:JSON.stringify(obj)
                })
                .then(r=>r.text())
                .then(data=>console.log(data))
            })

            btn.addEventListener("click", () => {
            })

            fr.readAsDataURL(file.files[0]);

        })
            
        
    </script>

<?php include('partials/footer.php'); ?>