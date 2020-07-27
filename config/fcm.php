<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAARHDMhJg:APA91bG3aMbuACxzfJcR-zUR_TM20N24y9Vdg03jRkQEgxrTBCJW374PjYDBeTo7NsrBtcGH7yJ82bwzsXQvtaLQ5Lv6dRQeYrN2Osb3DB7cn-26T5KPcOoN942mTsBNpuNNes_WNY8t'),
        'sender_id' => env('FCM_SENDER_ID', '293950227608'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
