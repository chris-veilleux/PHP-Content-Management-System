<?php
require 'includes/auth.php';
$title = 'Page Info';
require 'includes/header.php';
?>

<main class="container mt-3">
    <h1>Page Information</h1>
    <form method="POST" action="save-page.php">
        <?php
        try {
            // variables will be used to store information about an existing page, if a url param exists
            $pageId = null;
            $pageTitle = null;
            $pageContent = null;

            // check for a url param
            if (isset($_GET['pageId'])) {
                if (is_numeric($_GET['pageId'])) {
                    $pageId = $_GET['pageId'];

                    // if a url param exists, retrieve the info about the page from the database
                    require 'includes/db.php';

                    // fetch the title and content of the specified page
                    $sql = "SELECT pageTitle, pageContent
                            FROM pages
                            WHERE pageId = :pageId";
                    $cmd = $db->prepare($sql);
                    $cmd->bindParam(':pageId', $pageId, PDO::PARAM_INT);
                    $cmd->execute();
                    $page = $cmd->fetch();

                    // if the record does not exist in the database, disconnect from the database and redirect the user to the error page
                    if (empty($page)) {
                        $db = null;
                        header('location:error.php');
                        exit();
                    }
                    // if the record does exists, save the page title and content to local variables and disconnect from the database
                    else {
                        $pageTitle = $page['pageTitle'];
                        $pageContent = $page['pageContent'];
                        $db = null;
                    }
                }
            }
        } catch (Exception $error) {
            // if the database connection fails, redirect user to error page
            header('location:error.php');
        }
        ?>

        <fieldset class="mb-3">
            <label for="pageTitle" class="form-label">Page Title</label>
            <input name="pageTitle" id="pageTitle" class="form-control" required maxlength=20 value="<?php echo $pageTitle; ?>" />
        </fieldset>

        <fieldset class="mb-3">
            <label for="pageContent" class="form-label">Page Content</label>
            <textarea name="pageContent" id="pageContent" class="form-control" required><?php echo $pageContent; ?></textarea>
        </fieldset>

        <input type="hidden" name="pageId" id="pageId" value="<?php echo $pageId; ?>" />
        <button class="btn btn-primary">Save</button>
    </form>
</main>