<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return \DB::table('MyGuests')->get();
});

Route::get('/welcome', function () {
   
});

Route::get('/phpinfo', function () {
    //return view('welcome');
    echo phpinfo();
});

Route::get('/mail', function(){

    $to_name = 'Juwel';
    $to_email = 'bounce@simulator.amazonses.com';
    $data = ['name' => 'test'];


    Mail::send('emails.test', $data, function ($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)->subject('GREETINGS FROM INSTIBT');
        $message->from('admin@halofloss.com', 'BLUETECH');
    });

    if(count(Mail::failures()) > 0) {
        foreach(Mail::failures() as $email){
            echo $email;
        }
    } else {
        echo 'email sent';
    }

});

Route::get('/sqs', function(){

   // \App\Jobs\ProcessPodcast::dispatch();

});

Route::get('/test', function(){

    echo 200;

});
