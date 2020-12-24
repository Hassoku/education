<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAEg6w1bs:APA91bEWwVNO2tXL21cJpxQgEt_nG_QO4YRCLtKeXWLtHvezENvStRmfYvqebBwZ8OwXkJSnS4suKcwJoicTLMfod_vbi_p8hwqwsIpyuG7v0thoeBjSwqhYZRfbaW_8eADauXcWG44c'),
        'sender_id' => env('FCM_SENDER_ID', '77555881403'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
