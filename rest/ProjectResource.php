<?php
require_once("HttpResource.php");
require_once('db.php');

class ProjectResource extends HttpResource {

	protected function do_put()
	{
		parse_str(file_get_contents("php://input"), $_PUT);
		$project_id = $_PUT['project_id'];
		$title = $_PUT['title'];
		$subject = $_PUT['subject'];
		$deadline = $_PUT['deadline'];
		$conn = db::db_connect();
		$stmt = $conn->prepare("UPDATE project SET
			subject=:f2, title=:f3, deadline=:f4 WHERE project_id=:f1");
		$stmt->bindValue(':f1', $project_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $subject, PDO::PARAM_STR);
		$stmt->bindValue(':f3', $title, PDO::PARAM_STR);
		$stmt->bindValue(':f4', $deadline, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		$this->statusCode = 204;
        $this->body = "";
		if ($tmp == 0) {
          $this->exit_error(404, 'Error');
        }
	}
}
ProjectResource::run();
?>