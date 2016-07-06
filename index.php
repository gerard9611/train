<?
include_once('head.html');
?>
    
    <div class="container">
     
      <form id="login-form" onsubmit="login(); return false;">
         <h1>Login</h1>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="text" class="form-control" id="username" placeholder="Email" required>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Password" required>
        </div>
        <button type="submit" id="btnlogin" class="btn btn-success">LOGIN</button>
      </form>
      <div id="regholder">
        <button type="submit" id="btnregister" onclick="btnRegister();" class="btn btn-warning">Register</button>
      </div>
    </div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Register</h4>
      </div>
      <div class="modal-body">
        <!-- <form id="login-form" onsubmit="submit(); return false;"> -->
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Client Name</label> -->
              <input type="text" class="form-control" id="firstname" placeholder="First Name*" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Contact Person</label> -->
              <input type="text" class="form-control" id="lastname" placeholder="Last Name*" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Address</label> -->
              <input type="text" class="form-control" id="address" placeholder="Address*" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Address</label> -->
              <input type="text" class="form-control" id="zip" placeholder="Zip Code" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Area</label> -->
              <input type="text" class="form-control" id="town" placeholder="Town" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Email</label> -->
              <input type="email" class="form-control" id="email" placeholder="Email*" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Phone Number</label> -->
              <input type="text" class="form-control" id="mobile" placeholder="Mobile Number*" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputEmail1">Phone Number</label> -->
              <input type="text" class="form-control" id="phone" placeholder="Phone Number" required>
          </div>
          <div class="form-group">
              <!-- <label for="exampleInputPassword1">Password</label> -->
              <input type="password" class="form-control" id="pass" placeholder="Password*" required>
          </div>
          <button type="submit" onclick="submit();" id="btnsubmit" class="btn btn-success">Submit</button>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?
include_once('foot.html');
?>
<script type="text/javascript">
  function login()
  {
    var email = $('#username').val();
    var pass = $('#password').val();
    console.log(email+", "+pass);

    $.post("rest/login.php",
    {
      email: email,
      pass: pass
    },
    function(data,status)
    {
      console.log(data.trim());
      if(data.trim() === 'success')
      {
        continueLog(email, pass);
      }
      else
        alert('Wrong username or passowrd!');
    });
  }

  function continueLog(email, pass)
  {
    $.post("rest/session.php",
    {
      email: email,
      pass: pass
    },
    function(data,status)
    {
      getType(email, pass);
    });
  }
  function getType(email, pass)
  {
    $.ajax({
      url:"rest/gettype.php",
      type: "POST",
      headers: {
            'EMAIL':email,
            'PASSWORD':pass
      },
      success: function(data,status)
      {
        console.log(data);
        if(data.trim() === 'trainer')
          window.location.replace("trainer.php");
        if(data.trim() === 'student')
          window.location.replace("dashboard.php");
        if(data.trim() === 'admin')
        {
          alert('Not Implemented Yet');
          window.location.replace("logout.php");
        }
      }
    });
    
  }
  function btnRegister()
  {
    $('#myModal').modal('toggle');
  }

  function submit()
  {
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var address = $('#address').val();
    var zip = $('#zip').val();
    var town = $('#town').val();
    var email = $('#email').val();
    var mobile = $('#mobile').val();
    var phone = $('#phone').val();
    var password = $('#pass').val();
    if(!IsEmail(email))
    {
      alert('Please Enter a Valid Email');
      return;
    }
    if(!firstname.trim() || !lastname.trim() || !address.trim() || !email.trim() || !mobile.trim() || !password.trim())
    {
      //console.log(firstname +' '+ lastname +' '+ address +' '+ email +' '+ mobile +' '+ password);
      alert('Please Enter all Required Fields');
      return;
    }
    $.post("rest/register.php",
    {
      firstname: firstname,
      lastname: lastname,
      address: address,
      zip: zip,
      town: town,
      email: email,
      mobile: mobile,
      phone: phone,
      password: password
    },
    function(data,status)
    {
      console.log(data);
      if(data.trim() === 'success')
      {
        $('#myModal').find('input:text').val('');
        $('#myModal').modal('toggle');
        alert('Registered Successfully');
      }
      else
      {
        $('#myModal').modal('toggle');
        alert('Error please Contact System Administrator');
      }
    });
  }

  function IsEmail(email) 
  {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
</script>