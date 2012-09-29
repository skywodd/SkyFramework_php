<html>
    <head>
        <title>Image upload test</title>
    </head>
    <body>

        <form action="index.php" method="POST" enctype="multipart/form-data">
            <label for="file_upload">Image file</label><br />
            <input type="file" name="file_upload" id="file_upload" />
            <input type="hidden" name="is_uploaded" value="1" />
            <input type="submit" />
        </form>

        <?php
        define('APPS_RUNNING', true);

        include '../SkyFormCheck/SkyFormCheck.class.php';
        include 'SkyImage.class.php';

        try {

            $form = new SkyFormCheck($_POST);
            $form->addInput('is_uploaded');

            if ($form->isComplete()) {
                var_dump($_FILES);
                $img = new SkyImage('file_upload', 1048576, Array('image/jpeg' => 'jpg', 'image/png' => 'png'), 'upload');

                echo '<p>Output file name : ' . $img->getOutputFilename() . '</p>';
                var_dump($img->getInfo());
                
                echo '<p>Miniature file name : ' . $img->getOutputFilename() . '.resized.png</p>';
                $img->resize($img->getOutputFilename() . '.resized.png', 150);
                
            } else 
                echo '<p>Fill form please !</p>';
            
        } catch (Exception $e) {
            echo '<p>Got exception : ' . $e->getMessage() . '</p>';
        }
        ?>
    </body>
</html>