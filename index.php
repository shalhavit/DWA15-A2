<?php require('php/getTweetEngine.php'); ?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tweet Inspector | DWA15 Assignment 2</title>
        <meta charset='utf-8' />

        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css'>
        <link rel='stylesheet' href='css/custom.css'>

    </head>

    <body id="home">
        <div class="content row">
            <?php include "php/header.php";?>
        </div> <!-- header -->
        <section class="container">
            <div class="content row">

                <div class="sidebar col col-lg-3">
                    <form method="GET">

                        <label for="filter">Filter by user:</label>
                        <input type="text" name="filter" id="filter" value="<?=sanitize($filter) ?>">
                        <br/>
                        <br/>
                        <label for='numTweets'>Max. number of tweets:</label>
                        <br/>
                        <br/>
                        <select name='numTweets' id='numTweets'>
                            <option value='choose'>Choose one...</option>
                            <option value='1' <?php if($numTweets == '1') echo 'SELECTED'?>>1</option>
                            <option value='2' <?php if($numTweets == '2') echo 'SELECTED'?>>2</option>
                            <option value='3' <?php if($numTweets == '3') echo 'SELECTED'?>>3</option>
                            <option value='4' <?php if($numTweets == '4') echo 'SELECTED'?>>4</option>
                            <option value='5' <?php if($numTweets == '5') echo 'SELECTED'?>>5</option>
                            <option value='6' <?php if($numTweets == '6') echo 'SELECTED'?>>6</option>
                            <option value='7' <?php if($numTweets == '7') echo 'SELECTED'?>>7</option>
                            <option value='8' <?php if($numTweets == '8') echo 'SELECTED'?>>8</option>
                            <option value='9' <?php if($numTweets == '9') echo 'SELECTED'?>>9</option>
                            <option value='10' <?php if($numTweets == '10') echo 'SELECTED'?>>10</option>
                        </select>

                        <br/>
                        <br/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>

                    <div class="col col-lg-9">
                        <br/>
                        <?php if (!$valid): ?>
                            <p class="text-center alert alert-danger extra_padding_all" role="alert">
                                Number of tweets outside range :: Using default (<?=$numTweets?>)
                            </p>
                        <?php endif; ?>
                    </div>
                </div> <!-- sidebar -->

                <section class="main col col-lg-9">
                    <h2 class="text-center">Tweets Timeline</h2>
                    <div class="row">

                        <?php if ($filter): ?>
                            <h3 class="text-center alert <?=$alertType?>" role="alert">
                                <?=$labelResponse ?>
                            </h3>

                            <?php foreach ($array_user_timeline as $tstatus => $tweet): ?>
                                <div>
                                    <h6 class="small text-success"><?=$tweet['created_at']?></h6>
                                    <?php
                                    if (isset($tweet['entities']['media'])) {
                                        $media_url = $tweet['entities']['media'][0]['media_url'];
                                        echo "<img class='img-rounded img_b_padding' src='{$media_url}' width='100px' />";
                                    }
                                    ?>

                                    <p class="text-info"><?=$tweet['text']?></p>
                                    <hr/>
                                </div>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <?php foreach ($array_user_timeline as $publish => $tweet): ?>
                                <div>
                                    <h4><?=$tweet['user']['name']?></h4>
                                    <h6 class="small text-success"><?=$tweet['created_at']?></h6>
                                    <?php
                                    if (isset($tweet['entities']['media'])) {
                                        $media_url = $tweet['entities']['media'][0]['media_url'];
                                        echo "<img class='img-rounded img_b_padding' src='{$media_url}' width='100px' />";
                                    }
                                    ?>
                                    <p class="text-info"><?=$tweet['text']?></p>
                                    <hr/>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </section> <!-- main -->

            </div> <!-- content -->

        </section> <!-- container -->

        <div class="content row">
            <?php include "php/footer.php";?>
        </div> <!-- Footer -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
