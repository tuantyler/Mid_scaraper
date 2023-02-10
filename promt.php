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
        echo json_encode(
            array(
                "response_code" => $response_code,
            )
        );
    }
?>