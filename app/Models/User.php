<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'address',
        'is_wholeseller',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Custom code
    public static function getPermissionGroupsForAdminHealperRole()
    {
      $permissionGroups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
      return $permissionGroups;
    }
    public static function permissionsByGroupNameForAdminHealperRole($groupname)
    {
      $permissions = DB::table('permissions')->where('group_name', $groupname)->orderBy('name', 'asc')->get();
      return $permissions;
    }

    public static function checkPermission($permissionName) {
        if(Auth::user()->can($permissionName) || Auth::user()->type == 'admin') {
            return true;
        }
      }
  
      public static function checkMultiplePermission($permissionName) {
        if(Auth::user()->hasAnyPermission($permissionName) || Auth::user()->type == 'admin') {
            return true;
        }
      }


      public static function send_sms($phone, $message) {

        $number = $phone;
        $number = preg_replace('#[ -]+#', '', $number);
        $number = preg_replace('#[=]+#', '', $number);
        if(strlen($number)==10 || strlen($number)==13){
            $number = "0".$number; 
        }

        $msg = $message;

        $msg = str_replace("<br>","\n",$msg);
        $msg = str_replace(" ","+",$msg);
        $msg = strip_tags($msg);

        // new sms
        $apiKey = 'YbKEMMIjYocPZZS0wJZXIx7VBo1dxQW7';
        $apiToken = 'iZwp1685783712';
        $senderID = '8809601004664';
        $to = $number;
        $text = $msg;
        $scheduleDate = '';
        $route = '0';

        $url = "http://mimsms.com.bd/smsAPI?sendsms&apikey=$apiKey&apitoken=$apiToken&type=sms&from=$senderID&to=$to&text=$text&scheduledate=$scheduleDate&route=$route";
        $response = file_get_contents($url);
        return $response;

         /*
         $url = "https://isms.mimsms.com/smsapi";
          $data = [
            "api_key" =>env('SMS_API_KEY'),
            "type" => "text",
            "contacts" => $number,
            "senderid" =>env('SMS_SENDER_ID'),
            "msg" => $msg,
          ];
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          $response = curl_exec($ch);
          curl_close($ch);
          return $response;
          */
     }



}
