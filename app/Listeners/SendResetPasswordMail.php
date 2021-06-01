<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UpdatedResetPassword;

class SendResetPasswordMail
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
    public function handle(UpdatedResetPassword $event)
    {
        $user = $event->user;
        $pass = $event->password;
        $name = $user->name;
        $email = $user->email;

        $message = "Hello $name, <br><br> Thank you for signing up at Homeflex. your password is $pass<br><br>Do not hesitate to contact us if you have any further questions. We look forward to hearing from you.<br><br><br><br><br>Best Regards,<br><h3><b>Homeflex Team</b></h3>";

        $subject = "Autorespond - Password Recovery";
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
                                <img src=\"http://homeflex.ng/images/logo.jpg\" alt=\"logo\" style=\" width:290px  \" /> 
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
        mail($email, $subject, $fullMessage, $headers);
    }
}
