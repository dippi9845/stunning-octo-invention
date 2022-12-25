<!DOCTYPE html>
<html lang="en">

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/profile/globals.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/profile/post-handling.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/profile/user-getters.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/html-snippets/post.php');

if (!isUserLoggedIn(true)) {
    header('Location: /login.php');
}

$file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../setup.json');
$data = json_decode($file, false);

if (isset($_GET['user'])) {
    $visitedUser = $_GET['user'];
} else {
    $visitedUser = $_SESSION['userID'];
}

$conn = new mysqli("localhost", $data->dbName, $data->dbPassword, $data->dbUserName);

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Roddit</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Brand-icons.css">
    <link rel="stylesheet" href="assets/css/post.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
                        <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                        <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                    </svg></span><span>Roddit</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-4"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse flex-grow-0 order-md-first" id="navcol-4">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">First Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Second Item</a></li>
                </ul>
                <div class="d-md-none my-2"><button class="btn btn-light me-2" type="button">Button</button><button class="btn btn-primary" type="button">Button</button></div>
            </div>
            <div class="d-none d-md-block"><button class="btn btn-light me-2" type="button">Button</button><a class="btn btn-primary" role="button" href="#">Button</a></div>
        </div>
    </nav>
    <div class="container">
        <div class="row text-center">
            <div class="col">
                <p>Biografia</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col">
                <p><?php echo(getUserNameByID($conn, $visitedUser)); ?></p>
            </div>
            <div class="col">
            <?php if ($visitedUser == $_SESSION['userID']) {
            } elseif (isFollowing($conn, $visitedUser, $_SESSION['userID'])) { ?>
                <form id="unfollow-form" action="profile/unfollow.php" method="post">
                    <input type="hidden" name="unfollowedUser" value="<?php echo($visitedUser); ?>">
                    <button type="submit" name="unfollow-submit" class="btn btn-primary">Unfollow</button>
                </form>
            <?php } else { ?>
                <form id="follow-form" action="profile/follow.php" method="post">
                    <input type="hidden" name="followedUser" value="<?php echo($visitedUser); ?>">
                    <button type="submit" name="follow-submit" class="btn btn-primary">Follow</button>
                </form>
            <?php } ?>
            </div>
        </div>
        <div class="row text-center">
            <div class="col">
                <p>Profile pic</p>
            </div>
            <div class="col">
                <p><?php echo(getUserFollowerCount($conn, $visitedUser)); ?><br/>Followers</p>
            </div>
            <div class="col">
                <p><?php echo(getUserFollowingCount($conn, $visitedUser)); ?><br/>Following</p>
            </div>
        </div>

        <?php
        $posts = getUsersPosts($conn, $visitedUser);

        foreach ($posts as $post) {
            drawPost($post['Title'], $post['Text'], $post['Likes'], null, $post['PathToImage']);
        }
        
        $conn->close();
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <script>
        $("#follow-form").ajaxForm({success: function() {
            location.reload();
        }});
        $("#unfollow-form").ajaxForm({success: function() {
            location.reload();
        }});
    </script>
</body>

</html>
