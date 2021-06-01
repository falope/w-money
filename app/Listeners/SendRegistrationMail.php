<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\UserRegistered;
use App\Models\Referral;
use App\Models\User;

class SendRegistrationMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $registeredUser = $event->user;
        $name = $registeredUser->name;
        $email = $registeredUser->email;
        $message = "Hello $name, <br><br> Thank you for signing up. We are happy to have you on board, kindly login to your dashboard to select and pay for a new membership and begin to enjoy the full benefits of our platform<br><br>Kindly contact us if you have any further questions..<br><br><br><br><br>Best Regards,<br><h3><b>Homeflex.ng</b></h3><p>Email: support@homeflex.ng</p><p>Website: https://homeflex.ng</p>";
        // Your subject
        $subject = "Autorespond - Welcome To Homeflex";
        // From
        $headers  = "From: support@homeflex.ng\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $fullMessage =
            "<html style=\"height: 100%;\">
                         <body style=\"height: 100%;\">
                            <div style=\"min-height: 100%;height: auto !important;height: 100%;margin: 0 auto -63px;\">
                            <div class=\"visitorMessage\">
                                <table style=\"width: 100%;\">
                                <tr> <td>
                                <center>
                                <img src=\"https://homeflex.ng/images/logo.jpg\" alt=\"logo\" style=\" width:170px  \" /> 
                                </center>
                                </td>  
                                </tr>
                                </table>
                                $message
                            </div>
                            <div style=\"min-height:30px;width: 100%;\"></div>
                            </div>
                            <div style=\"margin-left: -20px;margin-right: -20px;padding-left: 20px;padding-right: 20px; color: #fff;background: #333333;padding: 17px 0 18px 0;border-top: 1px solid #BC4E0F; text-align:center;width: 100%;\">
                            </div>
                         </body>
                       </html>";
        // send email
        mail($email, $subject, $fullMessage, $headers);
    }
}
