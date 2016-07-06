<?php
session_start();
include_once('head.html');
if(!isset($_REQUEST['team_id']))
{
	echo '<script>history.go(-1);</script>';
	exit();
}
$team_id = $_REQUEST['team_id'];
if($_SESSION['email'] == null || strcmp($_SESSION['email'], '0')==0 || $_SESSION['pass'] == null || strcmp($_SESSION['pass'], '0')==0)
{
	echo '<script>window.location.replace("index.php");</script>';
	exit();
}
?>
    <div class="container">

    	<h4>Team ID</h4><p id="team_id"></p>
    	<h4>Team Created Date</h4><p id="team_date"></p>
    	<h4>Project Title</h4><p id="team_project_title"></p>
    	<h4>Project Deadline</h4><p id="team_project_date"></p>
    	<h4>Project Subject</h4><p id="team_project_subject"></p>
    	<h4>Team Owner</h4><p id="team_owner"></p>
    	<table class="table">
			<thead>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
			</thead>
			<tbody>

			</tbody>
    	</table>
    </div>


<?php
include_once('foot.html');
?>
<script type="text/javascript">
function getTeamInfo(team_id)
{
	$.ajax({
		url:"rest/getteaminfo.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	team_id: team_id
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
	        	for(var i = 0; i<json.teams.length; i++)
	        	{
	        		var obj = json.teams[i];
	        		$('#team_id').html(obj.team_id);
	        		$('#team_date').html(obj.created_at);
	        		$('#team_project_title').html(obj.title);
	        		$('#team_project_date').html(obj.deadline);
	        		$('#team_project_subject').html(obj.subject);
	        		$('#team_owner').html('<a href="person.php?person_id='+obj.person_id+'"> '+obj.first_name+" "+obj.last_name+'</a>');
	        	}
	    	}
    	}
	});
}
function getTeamMembers(team_id)
{
	$.ajax({
		url:"rest/getteammembers.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	team_id: team_id
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
	        	for(var i = 0; i<json.members.length; i++)
	        	{
	        		var obj = json.members[i];
	        		var first_name = '<td><a href="person.php?person_id='+obj.person_id+'">'+obj.first_name+'</a></td>';
	        		var last_name = '<td>'+obj.last_name+'</td>';
	        		var email = '<td>'+obj.email+'</td>';
	        		var mobile_phone = '<td>'+obj.mobile_phone+'</td>';
	        		$('.table > tbody:last-child').append('<tr>'+first_name+last_name+email+mobile_phone+'</tr>');
	        	}
	    	}
    	}
	});
}
</script>
<?php
echo '<script type="text/javascript">getTeamInfo('.$team_id.')</script>';
echo '<script type="text/javascript">getTeamMembers('.$team_id.')</script>';
?>