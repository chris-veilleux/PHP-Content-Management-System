<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PHP CMS | <?php echo $title;  ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <Script src="js/scripts.js" type="text/javascript" defer></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?pageId=1">PHP CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <?php
                    try {
                        // check if session start has already been called in this http request
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }

                        // if user is not logged in, display the public header
                        if (empty($_SESSION['username'])) {

                            // connect to database
                            require 'includes/db.php';

                            // set up query
                            $sql = "SELECT pageTitle, pageId
                                    FROM pages";

                            // prepare and execute the query, and fetch all of the records
                            $cmd = $db->prepare($sql);
                            $cmd->execute();
                            $pages = $cmd->fetchAll();

                            // iterate over the results and display the page names as list elements
                            foreach ($pages as $pageTitle) {
                                echo '<li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php?pageId=' . $pageTitle['pageId'] . '">'
                                . $pageTitle['pageTitle'] . '</a>
                            </li>';
                            }

                            //disconnect from the database
                            $db = null;


                            echo '<li class="nav-item">
                            <a class="nav-link" aria-current="page" href="register.php">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="login.php">Login</a>
                            </li>';

                        } else {
                            // if the user is logged in, display the admin header
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="admins.php">Administrators</a> 
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="pages.php">Pages</a> 
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>';
                        }
                    }
                    catch (Exception $error) {
                        header('location:error.php');
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>