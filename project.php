<?php
session_start();
include_once('head.html');
if(!isset($_REQUEST['project_id']))
{
	echo '<script>history.go(-1);</script>';
	exit();
}
$project_id = $_REQUEST['project_id'];
if($_SESSION['email'] == null || strcmp($_SESSION['email'], '0')==0 || $_SESSION['pass'] == null || strcmp($_SESSION['pass'], '0')==0)
{
	echo '<script>window.location.replace("index.php");</script>';
	exit();
}
?>
    <div class="container">

    	<h4>Project ID</h4><p id="project_id"></p>
    	<h4>Title</h4><p id="title"></p>
    	<h4>Subject</h4><p id="subject"></p>
    	<h4>Class</h4><p id="class"></p>
    	<h4>Created Date</h4><p id="created"></p>
    	<h4>Deadline</h4><p id="deadline"></p>
    </div>


<?php
include_once('foot.html');
?>
<script type="text/javascript">
function getProject(project_id)
{
	$.ajax({
		url:"rest/getproject.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	project_id: project_id
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
	        	for(var i = 0; i<json.projects.length; i++)
	        	{
	        		var obj = json.projects[i];
	        		$('#project_id').html(obj.project_id);
	        		$('#title').html(obj.title);
	        		$('#subject').html(obj.subject);
	        		$('#class').html(obj.name);
	        		$('#created').html(obj.created_at);
	        		$('#deadline').html(obj.deadline);
	        	}
	    	}
    	}
	});
}
</script>
<?php
echo '<script type="text/javascript">getProject('.$project_id.')</script>';
?>