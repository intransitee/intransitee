<?php

namespace App\Http\Helpers;

class PushNotifMobile
{
    public static function send_notification_FCM($img_url, $title, $message, $id, $type, $click_action, $data)
    {
        $accesstoken = 'AAAASR0AL_o:APA91bHmPOtQPGOzxhPuoeJD-rgw6qmA9zbMmYx3HaWFNazp092RAuxCpJ5wqT8oBQiM8D3puz72jTFguIymnMZxCSABHBRwGaqXdPXEaiwXeX_bMinx2slW4QWV3aZ1N6163-S7GGxv';
        $URL = 'https://fcm.googleapis.com/fcm/send';
        $url_icon = 'https://hr.ekrutes.id/favicon/favicon-32x32.png';

        $data_ = [
            'to'  => '/topics/talent',
            "data" => $data,
            "notification" => [
                "body"  =>  $message,
                "title"  =>  $title,
                "type"  =>  $type,
                "id"   => $id,
                "message"  => "",
                "icon"  => $url_icon,
                "image"  => $img_url,
                "sound"  => "default",
                "click_action"  => $click_action
            ]
        ];
        $post_data = json_encode($data_);

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization:key=' . $accesstoken;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        // dd($crl);
        $rest = curl_exec($crl);
        if ($rest === false) {
            $result_noti = 0;
        } else {

            $result_noti = 1;
        }
        return $result_noti;
    }
}
