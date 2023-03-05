<?php
// zona waktu
date_default_timezone_set('Asia/Jakarta');
// Set the API endpoint URL and API key
$api_url = 'https://api.openai.com/v1/engines/davinci-codex/completions';
// $api_key = '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';
$api_key = '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';

// Get the message from the form data
$message = $_POST['tanya'];

// Create the request data
$data = array(
    'prompt' => 'Q: ' . $message . '\nA:',
    'temperature' => 0.7,
    'max_tokens' => 150,
    'stop' => '\n'
);

// Create the cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
));

// Send the request and get the response
$response = curl_exec($ch);
curl_close($ch);

// Parse the response JSON and get the completed text
$response_data = json_decode($response, true);
$completed_text = $response_data['choices'][0]['text'];
$pertanyaan = htmlspecialchars($message);
$jawaban = htmlspecialchars($completed_text);

?>
<!doctype html>
<html>

<head>
    <title>V2-Nzan AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/gaya.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body>

    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="cari">
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            <!-- ini contoh offline
                            <li class="clearfix">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                <div class="about">
                                    <div class="name">Loli Nzan</div>
                                    <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>
                                </div>
                            </li>
                            -->
                            <!-- user -->
                            <li class="clearfix active">
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                <div class="about">
                                    <div class="name">Anda</div>
                                    <div class="status"> <i class="fa fa-circle online"></i> online </div>
                                </div>
                            </li>
                            <!-- BOT -->
                            <li class="clearfix active">
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                <div class="about">
                                    <div class="name">Anda</div>
                                    <div class="status"> <i class="fa fa-circle online"></i> online </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="chat ">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="img/avatar.png" class="bg-light img-thumbnail" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0 text-info">NzanAI - V2</h6>
                                        <small class="text-info">now</small>
                                    </div>
                                </div>
                                <div class="col-lg-6 hidden-sm text-right">
                                    <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0">
                                <li class="clearfix">
                                    <div class="message-data text-right">
                                        <span class="message-data-time"><?php echo date("h:i:s A"); ?></span>
                                        <img src="img/avatar.png" class="bg-light img-thumbnail" alt="avatar">
                                    </div>

                                    <div class="message other-message float-right"><?php echo $pertanyaan; ?></div>
                                </li>
                                <li class="clearfix">
                                    <div class="message-data">
                                        <span class="message-data-time"><?php echo date("h:i:s A"); ?></span>
                                    </div>
                                    <div class="message my-message"><?php echo ($response) ? $jawaban : "NULL"; ?></div>
                                </li>
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <div class="input-group mb-0">
                                <form action="index.php" class="d-flex" method="post">
                                    <div class="input-group-prepend">
                                        <button type="submit" name="kirim" class="btn btn-light input-group-text w-auto"><i class="fa fa-send"></i></button>
                                    </div>
                                    <input type="text" name="tanya" class="form-control" placeholder="Chat Disini...">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</html>