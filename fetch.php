<?php
    require 'env.php';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://discord.com/api/v9/guilds/'. $_env["guild_id"] .'/messages/search?channel_id='. $_env["channel_id"] .'&mentions=' . $_env["user_id"]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: " . $_env["access_token"],
        "Content-Type: application/json"
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    print_r($response);
?>