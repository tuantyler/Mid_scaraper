<!DOCTYPE html>
<html>
<head>
    <title>PHP Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body>
    <div class="container">
        <div class="container mt-5">
            <form method="post">
                <div class="row">
                    <div class="col-md-6 m-auto">
                        <form method="post">
                            <div class="form-group">
                                <label for="input">Enter your promt:</label>
                                <input type="text" class="form-control" id="input" name="input">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                        <br>
                        <?php
                            require 'env.php';
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $input = $_POST["input"];
                                $ch = curl_init("https://discord.com/api/v9/interactions");
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                    "Authorization: " . $_env["access_token"],
                                    "Content-Type: application/json"
                                ));
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                                    array(
                                        "type" => 2,
                                        "application_id" => $_env["application_id"],
                                        "channel_id" => $_env["channel_id"],
                                        "guild_id" => $_env["guild_id"],
                                        "session_id" => " ",
                                        "data" => array(
                                            "version" => $_env["version"],
                                            "id" => $_env["id"],
                                            "name" => $_env["name"],
                                            "type" => 1,
                                            "options" => array(
                                                array(
                                                    "type" => 3,
                                                    "name" => $_env["promt_field"],
                                                    "value" => $input
                                                )
                                            ),
                                        )
                                    )
                                ));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_exec($ch);
                                $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                if ($response_code == 204) {
                                    echo "Generating image for promt: " . $input;  
                                    echo '<div id="displayImg"></div>';   
                                    echo '
                                    <script>
                                    setInterval(function() {
                                        console.log("fetching...");
                                        $.get("fetch.php", function(data) {
                                          $("#displayImg").html(data);
                                        });
                                    }, 20000);
                                    </script>
                                    ';
                                }
                                else {
                                    var_dump($response_code);
                                    echo "Something wrong just happened";
                                }
                            }
                        ?>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</body>
</html>