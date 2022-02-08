<?php if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
}
?><?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

        <h1>Image Management</h1>

        <p class="image-p">Welcome to the image management page. Upload a new image or delete existing images.</p>

        <h2 class="image-h2">Add New Vehicle Image</h2>

        <?php if (isset($message)) {
                echo $message;
        }
        ?>

        <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data" class="upload-form">
                <label for="invId">Vehicle</label>
                <?php echo $prodSelect ?>
                <fieldset>
                        <label class="image-main">Is this the main image for the vehicle?</label>

                        <label for="priYes" class="pImage">Yes </label>
                        <input type="radio" name="imgPrimary" id="priYes" class="pImage image-radio1" value="1">
                       
                        
                        <label for="priNo" class="pImage">No</label>
                        <input type="radio" name="imgPrimary" id="priNo" class="pImage image-radio2" checked value="0">
                </fieldset>
                <label>Upload Image</label>
                <input type="file" name="file1">
                <button type="submit" class="form-button">Upload</button>
                <input type="hidden" name="action" value="upload">

        </form>

        <hr>

        <h2 class="image-h2">Existing Images</h2>
        <p>If deleting an image, delete the thumbnail as well and vice versa.</p>
        <?php if (isset($imageDisplay)) {
                echo $imageDisplay;}
        ?>



<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>