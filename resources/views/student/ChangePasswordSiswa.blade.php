@extends('template.student_master')
@section('title', 'Ganti Password')
@section('content')
 <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Change Password</h1>
            </div>
          </div>
        </div>
      </div>
     
      <section class="content">
        <div class="container-fluid">
        <form method="POST" id="Update-Password" action="/password/student/UpdatePassword">
         	@method('patch')
         	@csrf
          <!-- Main row -->
          <div class="row">

            <div class="col-6">
              <div class="register">
                <div id="password-form">
                <input type="password" name="new-password" id="new-password" maxlength="50" minlength="8" id="password-field" class="form-control password-form-field w-50" placeholder="New Password">
                  <input type="password" name="conf-password" id="conf-password" maxlength="50" minlength="8" id="password-field" class="form-control password-form-field w-50 mt-1" placeholder="Confirm Password">
                </div>
                
                <button type="button" class="btn btn-primary mt-3" id="submit-button">Submit</button>
              </div>
            </div>
          </div>
        </form>      
      </section>
    </div>
  </div>

  <script type="text/javascript">
  $('#submit-button').click(function (e) {
      if($('#new-password').val() == $('#conf-password').val())
      {
        $('#Update-Password').submit();
      }else{
        $.notify({ 
          message: 'Password lu beda tolong disamakan terima kasih!'
        },
          { 
            z_index: 99999, 
            type: 'danger',
            timer: 15000 
          });
      }
  });

  $('#new-password').keyup(function(e){
    if (e.keyCode === 13) {
        $('#conf-password').focus();
    }
  });

  $('#conf-password').keyup(function(e){
    if (e.keyCode === 13) {
        $('#submit-button').click();
    }
  });
  
  </script>
@endsection