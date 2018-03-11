<?php

require 'init.php';

$link = $_GET['link'];
parse_str($link, $urlData);
$my_id = array_values($urlData)[0];

$videoFetchURL = "http://www.youtube.com/get_video_info?video_id=" . $my_id . "&asv=3&el=detailpage&hl=en_US";
$videoData = get($videoFetchURL);

parse_str($videoData, $video_info);
$video_info = json_decode(json_encode($video_info));

if (!$video_info->status == 'ok') {
    die("Error in fetching youtube video data.");
}

$videoTitle = $video_info->title;
$videoAuthor = $video_info->author;
$videoDurationSecs = $video_info->length_seconds;
$videoDuration = secToDuration($videoDurationSecs);
$videoViews = $video_info->view_count;

//Change hqdefault.jpg to default.jpg for downgrading the thumbnail quality
$videoThumbURL = "http://i1.ytimg.com/vi/{$my_id}/hqdefault.jpg";

if (!isset($video_info->url_encoded_fmt_stream_map)) {
    die("No data found");
}

$streamFormats = explode(",", $video_info->url_encoded_fmt_stream_map);

if (isset($video_info->adaptive_fmts)) {
    $streamSFormats = explode(",", $video_info->adaptive_fmts);
    $pStreams = parseStream($streamSFormats);
}

$cStreams = parseStream($streamFormats);

function dd($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    die();
}

?>

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
            <a href="index.php"><img src="https://goo.gl/3TsUGi" alt="Header Image" id="HeaderImage"></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3" id="header">
            <br>
            <h4><?php echo $videoTitle ?></h4>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <!--humbnail-->
                    <img src="<?php echo $videoThumbURL; ?>" alt="Video Thumbnail" id="thumbnail">
                </div>

                <div class="col-md-8">
                    <h6 id="author">Channel</h6>
                    <h6 id="authorName"><?php echo $videoAuthor; ?></h6>
                    <h6 id="author">Duration</h6>
                    <h6 id="authorName"><?php echo $videoDuration; ?></h6>
                    <h6 id="author">Views</h6>
                    <h6 id="authorName"><?php echo $videoViews; ?></h6>
                </div>
            </div>

<!--            --><?php //if (isset($pStreams)): ?>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h5>Video+audio Formats</h5>
                    <br>
                    <?php foreach ($cStreams as $stream): ?>
                        <?php $stream = json_decode(json_encode($stream)); ?>

                        <div class="row" id="videoDetails">
                            <div class="col-md-3"><?php echo $stream->type; ?></div>
                            <div class="col-md-3"><?php echo $stream->quality; ?></div>
                            <div class="col-md-3"><?php echo $stream->size; ?></div>
                            <div class="col-md-3"><a href="<?php echo $stream->url; ?>" target="_blank" download="<?php echo $videoTitle ?>">
                                    <button class="btn btn-sm btn-outline-success">Download</button>
                                </a></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
<!--            --><?php //endif ?>
        </div>

    </div>
</div>

</body>
</html>