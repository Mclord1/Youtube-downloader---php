<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Youtube Video Downloader</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/bootstrap.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3" id="header">
            <img src="https://goo.gl/3TsUGi" alt="Header Image" id="HeaderImage">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3" id="container-body">
            <p>Youtube Video Downloader</p>
            <hr>
            <form action="getdata.php" method="get" autocomplete="off">
                <label for="link">Youtube Video Link</label>
                <input name="link" type="text" class="form-control" autofocus>
                <br>
                <button class="btn btn-sm btn-outline-danger" type="submit">Get Download Links</button>
                <br>
                <hr>
            </form>
        </div>
    </div>
</div>

</body>
</html>