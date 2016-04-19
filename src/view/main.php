<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $pageTitle; ?> - Simple RSS Feeds Manager</title>
        <link rel="stylesheet" type="text/css" href="./view/css/layout.css">
        <link rel="stylesheet" type="text/css" href="./view/css/bootstrap.min.css">
    </head>

    <body>
        <div class="project-container">
            <div class="project-heading">
                <div class="btn-home">
                    <h2><a href="index.php">Home</a></h2>
                </div>

                <div class="logo">
                    <h1>Simple RSS Feeds Manager</h1>
                </div>

                <div class="user-details">
                    <?php
                        $authentication = new Service_Authentication();
                        $loggedInUser = $authentication->getLoggedInUser();
                        if ($loggedInUser instanceof Model_User) {
                            echo '<p>You are logged in as <b>' . htmlentities($loggedInUser->getUsername()) 
                                . '</b> (<a href="logout.php">Log out</a>)</p>';
                        }
                    ?>
                </div>
            </div>

            <div class="project-content clearfix">
                <?php echo $pageContent; ?>
            </div>

            <div class="project-footer">
                <small>Simple RSS Feeds Manager by Zahiar Ahmed</small>
            </div>
        </div>

        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="./view/js/bootstrap.min.js"></script>
    </body>
</html>