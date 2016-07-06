<?php
session_start();
include_once('head.html');
if(!isset($_REQUEST['person_id']))
{
	echo '<script>history.go(-1);</script>';
	exit();
}
$person_id = $_REQUEST['person_id'];
if($_SESSION['email'] == null || strcmp($_SESSION['email'], '0')==0 || $_SESSION['pass'] == null || strcmp($_SESSION['pass'], '0')==0)
{
	echo '<script>window.location.replace("index.php");</script>';
	exit();
}
?>
    <div class="container">

    	<h4>Person ID</h4><p id="person_id"></p>
    	<h4>Name</h4><p id="name"></p>
    	<h4>Address</h4><p id="address"></p>
    	<h4>Zip</h4><p id="zip"></p>
    	<h4>Town</h4><p id="town"></p>
    	<h4>Email</h4><p id="email"></p>
    	<h4>Mobile</h4><p id="mobile"></p>
    	<h4>Phone</h4><p id="phone"></p>
    	<h4>Type</h4><p id="type"></p>
    </div>


<?php
include_once('foot.html');
?>
<script type="text/javascript">
function getPerson(person_id)
{
	$.ajax({
		url:"rest/getperson.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	person_id: person_id
	    },
	    success: function(data,status)
	    {
	    	console.log(data.trim());
	    	if(data.trim() === 'error')
	    	{
	    		alert('Error');
	    	}
	      	else
	      	{
	        	var json = JSON.parse(data);
	        	for(var i = 0; i<json.persons.length; i++)
	        	{
	        		var obj = json.persons[i];
	        		$('#person_id').html(obj.person_id);
	        		$('#name').html(obj.first_name+" "+obj.last_name);
	        		$('#address').html(obj.address);
	        		$('#zip').html(obj.zip_code);
	        		$('#town').html(obj.town);
	        		$('#email').html(obj.email);
	        		$('#mobile').html(obj.mobile_phone);
	        		$('#phone').html(obj.phone);
	        		if(obj.is_trainer == 1)
	        			$('#type').html("Trainer");
	        		else if(obj.is_admin == 1)
	        			$('#type').html("Trainer");
	        		else
	        			$('#type').html("Student");
	        	}
	    	}
    	}
	});
}
</script>
<?php
echo '<script type="text/javascript">getPerson('.$person_id.')</script>';
?>