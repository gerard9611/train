<?php
session_start();
include_once('head.html');

if($_SESSION['email'] == null || strcmp($_SESSION['email'], '0')==0 || $_SESSION['pass'] == null || strcmp($_SESSION['pass'], '0')==0)
{
	echo '<script>window.location.replace("index.php");</script>';
	exit();
}
?>
    <div class="container">
    	<h1>My Teams</h1>
    	<button data-toggle="modal" data-target="#myModal" id="btnadd" class="btn btn-warning">New Team</button>
    	<table class="table">
    		<thead>
			  	<th>Team ID</th>
			  	<th>Project ID</th>
			  	<th>Owner ID</th>
			  	<th>Created At</th>
			  	<th>Summary</th>
		  	</thead>
		  	<tbody id="tbodyid">

		  	</tbody>
		</table>
    </div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create a new team</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <select class="form-control" id="project_id" required>
              	<!-- Projects options Added in JQUERY -->
              </select>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="summary" placeholder="Summary" required>
          </div>
          <button type="submit" onclick="insertteam();" id="btnsubmit" class="btn btn-success">Submit</button>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="editTeamModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit team</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <input type="text" class="form-control" id="editSummary" placeholder="Summary" required>
          </div>
          <div class="form-group" id="team_members">
          		<!-- Team Members Added in JQUERY -->
          		
          </div>
          <button type="submit" onclick="editTeam();" id="btnsubmit" class="btn btn-success">Submit</button>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<?php
include_once('foot.html');
?>
<script type="text/javascript">
function getTeams()
{
	$("#tbodyid").empty();
	$.ajax({
		url:"rest/getteams.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    success: function(data,status)
	    {
	    	//console.log(data.trim());
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
	        		var team_id = '<td>'+obj.team_id+'</td>';
	        		var owner_id = '<td>'+obj.owner_id+'</td>';
	        		var project_id = '<td>'+obj.project_id+'</td>';
	        		var created_at = '<td>'+obj.created_at+'</td>';
	        		var summary = '<td>'+obj.summary+'</td>';
	        		var btnedit = '<td><button onclick="editTeamUI(\''+obj.team_id+'\',\''+obj.summary+'\',\''+obj.project_id+'\')" id="btnedit" class="btn btn-warning">Edit Team</button></td>';
	        		var btndelete = '<td><button onclick="deleteTeam('+obj.team_id+')" id="btndelete" class="btn btn-danger">Delete Team</button></td>';
	        		var btnview = '<td><button onclick="viewTeam('+obj.team_id+')"  id="btndetails" class="btn btn-success">View Team</button></td>';
	        		$('.table > tbody:last-child').append('<tr>'+team_id+project_id+owner_id+created_at+summary+btnedit+btndelete+btnview+'</tr>');
	        	}
	    	}
    	}
	});
}
function deleteTeam(team_id)
{
    $.ajax({
        url:"rest/deleteteam.php",
        type: "POST",
        headers: {
            'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
            'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
        },
        data:{
            team_id:team_id
        },
        success: function(data,status)
        {
            //console.log(data.trim());
            if(data.trim() === 'error')
            {
                alert(data.trim());
            }
            else
            {
                getTeams();
                console.log(data.trim());
            }
        }
    });
}
function viewTeam(team_id)
{
	window.location.replace("team.php?team_id="+team_id);
}
function getMembers(team_id,project_id)
{
	$("#team_members").html();
	console.log(team_id);
	$.ajax({
		url:"rest/getmembers.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	team_id: team_id,
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
	        	$('#team_members').html(data.trim());
	    	}
    	}
	});
}
function btnAdd(team_id, person_id, project_id)
{
	$.ajax({
		url:"rest/addteamperson.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	team_id:team_id,
	    	person_id:person_id
	    },
	    success: function(data,status)
	    {
	    	if(data.trim() === 'error')
	    	{
	    		alert('error');
	    	}
	      	else
	      	{
	        	getMembers(team_id,project_id);
	    	}
    	}
	});
}
function btnRemove(team_id, person_id, project_id)
{
	$.ajax({
		url:"rest/removeteamperson.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	team_id:team_id,
	    	person_id:person_id
	    },
	    success: function(data,status)
	    {
	    	if(data.trim() === 'error')
	    	{
	    		alert('error');
	    	}
	      	else
	      	{
	        	getMembers(team_id,project_id);
	    	}
    	}
	});
}
var selectedTeam = 0;

function editTeamUI(team_id,summary, project_id)
{
	selectedTeam = team_id;
	getMembers(team_id, project_id);
	$('#editTeamModal').modal('toggle');
}
function editTeam()
{
	var summary = $("#editSummary").val();
	console.log(summary);
	$.ajax({
		url:"rest/editteam.php",
		type: "PUT",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	team_id:selectedTeam,
	    	summary:summary
	    },
	    success: function(data,status)
	    {
	    	console.log(data.trim());
	    	if(data.trim() === 'error')
	    	{
	    		alert('error');
	    	}
	      	else
	      	{
	        	$('#editTeamModal').modal('toggle');
	        	getTeams();
	    	}
    	}
	});
}

function getProjects()
{
	$.ajax({
		url:"rest/getprojects.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    success: function(data,status)
	    {
	    	//console.log(data.trim());
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
	        		var project_id = '<option value="'+obj.project_id+'">'+obj.title+'</option>';
	        		$('#project_id').append(project_id);
	        	}
	    	}
    	}
	});
}

function insertteam()
{
	var project_id = $("#project_id").val();
	var summary = $("#summary").val();
	$.ajax({
		url:"rest/insertteam.php",
		type: "POST",
		headers: {
	        'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
	        'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
	    },
	    data:{
	    	project_id:project_id,
	    	summary:summary
	    },
	    success: function(data,status)
	    {
	    	//console.log(data.trim());
	    	if(data.trim() === 'error')
	    	{
	    		alert(data);
	    	}
	      	else
	      	{
	      		$('#myModal').modal('toggle');
	        	console.log("success");
	    	}
    	}
	});
}
</script>
<?php
echo '<script type="text/javascript">getTeams()</script>';
echo '<script type="text/javascript">getProjects()</script>';
?>