<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  </head>
  <body>
    <div class="col-md-6 m-auto main">
      <div class="card card-body mt-5 shadow">
        <div class="text-center">
          <h2>HomeFlex Global Password Reset</h2>
          <div class="alert-body">
            <p>Hello {{ $fullName }}, proceed on your HomeFlex portal with the temporary password below:</p>
            <div>
              <h3>
                <strong>{{ $password }}</strong>
              </h3>
            </div>
          </div>

          <small class="footer"
            >N.B: Kindly change password on your account dashboard after loggin in. If this password reset wasn't you initiated by you
            Kindly ignore/delete this mail. <br/><br/> Contact us support via: <a href="mailto:support@homeflexglobal.com">support@homeflexglobal.com</a> Thank you.</small
          >
        </div>
      </div>
    </div>
  </body>
</html>
