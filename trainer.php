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
        <h1>My Projects</h1>
        <button data-toggle="modal" data-target="#myModal" id="btnadd" class="btn btn-warning">New Project</button>
        <table class="table">
            <thead>
                <th>Project ID</th>
                <th>Class ID</th>
                <th>Title</th>
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
        <h4 class="modal-title">Create a new Project</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
              <input type="text" class="form-control" id="title" placeholder="Title" required>
          </div>
          <div class="form-group">
              <select class="form-control" id="class_id" required>
                <!-- Projects options Added in JQUERY -->
              </select>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="subject" placeholder="Subject" required>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="deadline" placeholder="Deadline" readonly required>
          </div>
          <button type="submit" onclick="insertProject();" id="btnsubmit" class="btn btn-success">Submit</button>
        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="editProjectModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Project</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <input type="text" class="form-control" id="etitle" placeholder="Title" required>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="esubject" placeholder="Subject" required>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="edeadline" placeholder="Deadline" readonly required>
          </div>
          <button type="submit" onclick="editProject();" id="btnsubmit" class="btn btn-success">Submit</button>
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
function getTrainerProjects()
{
    $("#tbodyid").empty();
    $.ajax({
        url:"rest/gettrainerprojects/",
        type: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
              xhr.setRequestHeader("email", <?php echo "'".$_SESSION['email']."'"; ?>);
              xhr.setRequestHeader("password", <?php echo "'".$_SESSION['pass']."'"; ?>);
        },
        success: function(data,status)
        {
            console.log(data);
            var json = JSON.stringify(data);
            json = JSON.parse(json);
                for(var i = 0; i<json.projects.length; i++)
                {

                    var obj = json.projects[i];
                    var project_id = '<td>'+obj.project_id+'</td>';
                    var class_id = '<td>'+obj.class_id+'</td>';
                    var title = '<td>'+obj.title+'</td>';
                    var btnedit = '<td><button onclick="editProjectUI(\''+obj.project_id+'\', \''+obj.title+'\', \''+obj.subject+'\', \''+obj.deadline+'\')" id="btnedit" class="btn btn-warning">Edit Project</button></td>';
                    var btndelete = '<td><button onclick="deleteProject('+obj.project_id+')"  id="btndelete" class="btn btn-danger">Delete Project</button></td>';
                    var btnview = '<td><button onclick="viewProject('+obj.project_id+')"  id="btndetails" class="btn btn-success">View Project</button></td>';
                    $('.table > tbody:last-child').append('<tr>'+project_id+class_id+title+btnedit+btndelete+btnview+'</tr>');
                }
        },
        error: function (xhr, string) {
              alert(xhr.status);
        }
    });
}

function deleteProject(project_id)
{
    $.ajax({
        url:"rest/deleteproject.php",
        type: "POST",
        headers: {
            'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
            'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
        },
        data:{
            project_id:project_id
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
                getTrainerProjects();
                console.log(data.trim());
            }
        }
    });
}

function getClasses()
{
    $.ajax({
        url:"rest/getclasses.php",
        type: "POST",
        headers: {
            'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
            'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
        },
        success: function(data,status)
        {
            // console.log(data.trim());
            if(data.trim() === 'error')
            {
                alert('Error');
            }
            else
            {   
                var json = JSON.parse(data);
                for(var i = 0; i<json.classes.length; i++)
                {
                    var obj = json.classes[i];
                    var class_id = '<option value="'+obj.class_id+'">'+obj.name+'</option>';
                    $('#class_id').append(class_id);
                }
            }
        }
    });
}

function insertProject()
{
    var class_id = $("#class_id").val();
    var subject = $("#subject").val();
    var title = $("#title").val();
    var deadline = $("#deadline").val();
    $.ajax({
        url:"rest/insertproject.php",
        type: "POST",
        headers: {
            'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
            'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
        },
        data:{
            class_id:class_id,
            subject:subject,
            title:title,
            deadline:deadline
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
                getTrainerProjects();
                $('#myModal').modal('toggle');
                console.log("success");
            }
        }
    });
}
var selectedProject = 0;
function editProjectUI(project_id, title, subject, deadline)
{
    selectedProject = project_id;
    $('#etitle').val(title);
    $('#esubject').val(subject);
    $('#edeadline').val(deadline);
    $('#editProjectModal').modal('toggle');
}

function editProject()
{
    var title = $('#etitle').val();
    var subject = $('#esubject').val();
    var deadline = $('#edeadline').val();

    $.ajax({
        url:"rest/project/",
        type: "PUT",
        headers: {
            'EMAIL':<?php echo "'".$_SESSION['email']."'"; ?>,
            'PASSWORD':<?php echo "'".$_SESSION['pass']."'"; ?>
        },
        data:{
            project_id:selectedProject,
            title:title,
            subject:subject,
            deadline:deadline
        },
        success: function(data,status)
        {
            $('#editProjectModal').modal('toggle');
            getTrainerProjects();
        },
        error: function (xhr, string) {
              alert(xhr.statusText);
        }
    });
}

function viewProject(project_id)
{
    window.location.replace("project.php?project_id="+project_id);
}

$(function() {
    $( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#edeadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
</script>
<?php
echo '<script type="text/javascript">getTrainerProjects()</script>';
echo '<script type="text/javascript">getClasses()</script>';
?>