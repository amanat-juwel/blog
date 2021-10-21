<?php
//https://vannstudios.com/handling-email-bounce-and-complaints-for-amazon-aws-ses-in-laravel
// set verify csrf token to false

/*
Steps to follow
1. Create SNS Topic

2. Create subscription

3. Confirm subscription
*/
namespace App\Http\Controllers;
use App\WrongEmail;

class AmazonController extends Controller
{
  public function handleBounceOrComplaint(Request $request)
  {
    Log::info($request->json()->all());
    $data = $request->json()->all();
    if($request->json('Type') == 'SubscriptionConfirmation')
      Log::info("SubscriptionConfirmation came at: ".$data['Timestamp']);
    if($request->json('Type') == 'Notification'){
      $message = $request->json('Message');
      switch($message['notificationType']){
        case 'Bounce':
          $bounce = $message['bounce'];
          foreach ($bounce['bouncedRecipients'] as $bouncedRecipient){
            $emailAddress = $bouncedRecipient['emailAddress'];
            $emailRecord = WrongEmail::firstOrCreate(['email' => $emailAddress, 'problem_type' => 'Bounce']);
            if($emailRecord){
              $emailRecord->increment('repeated_attempts',1);
            }
          }
          break;
        case 'Complaint':
          $complaint = $message['complaint'];
          foreach($complaint['complainedRecipients'] as $complainedRecipient){
            $emailAddress = $complainedRecipient['emailAddress'];
            $emailRecord = WrongEmail::firstOrCreate(['email' => $emailAddress, 'problem_type' => 'Complaint']);
            if($emailRecord){
              $emailRecord->increment('repeated_attempts',1);
            }
          }
          break;
        default:
          // Do Nothing
          break;
      }
    }
    return Response::json(['status' => 200, "message" => 'success']);
  }
}