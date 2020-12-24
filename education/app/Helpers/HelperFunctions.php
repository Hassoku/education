<?php

    namespace App\Helpers;


    use App\Models\Notification;
    use http\Env\Request;

    class HelperFunctions
    {
        public static function sendWebNotification($data)
        {
//            Import Syntax = use App\Helpers\HelperFunctions;
            /*
             $domainPieces = explode('.', request()->getHost());
             $domainSlug = $domainPieces[0];
             $msg = array(
                'title' => 'Guard Availability Updated',
                'user_id' => Auth::user()->id,
                'notification_type' => $domainSlug,
                'route' => 'guards_availability_index',
                'message' => $guard->FullName.' updated his availability'
            );

            HelperFunctions::sendWebNotification($msg);*/
            Notification::create($data);
            return 1;
        }

        public static function getAllWebNotifications($id)
        {
            $domainPieces = explode('.', request()->getHost());
            $domainSlug = $domainPieces[0];
            return Notification::where(['status' => 0, 'user_id' => $id, 'notification_type' => $domainSlug])->get()->toArray();
        }
    }