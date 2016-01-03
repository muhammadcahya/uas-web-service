<?php

namespace App\Routes;

use PDO;
use PDOException;

use Slim\Slim;
use App\Db\Connection;

/**  
 * @author Muhammad Cahya <muhammadcahyax@gmail.com>
 * @link http://mynacreative.com/
 * @since 1.0 
 */

class PartCategory {
	
	public $tableName = 'parts_categories';
    
	function index() {
		$app = Slim::getInstance();
		try {
			$db = new Connection();
			$sth = $db->prepare("SELECT * FROM {$this->tableName}");
			$sth->execute();
	 
			$laptop = $sth->fetchAll(PDO::FETCH_ASSOC);
	 
			if($laptop) {
				$app->response->setStatus(200);
				$app->contentType('application/json');
				echo json_encode($laptop);
				$db = null;
			} else {
				throw new PDOException('No records found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			$app->contentType('application/json');
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}
	
	function view($id) {
		$app = Slim::getInstance();
		try {
			$db = new Connection();
			$sth = $db->prepare("SELECT * FROM {$this->tableName} WHERE id = :id");
			$sth->bindParam('id', $id);
			$sth->execute();
	 
			$laptop = $sth->fetch(PDO::FETCH_ASSOC);
	 
			if($laptop) {
				$app->response->setStatus(200);
				$app->contentType('application/json');
				echo json_encode($laptop);
				$db = null;
			} else {
				throw new PDOException('Data not found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			$app->contentType('application/json');
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}
	
	
	function create() {
		$app = Slim::getInstance();
		$request = $app->request->post();
		
		$required = [];
		
		if(!isset($request['categories_name'])){
			$required[] = 'Parameter `categories_name` required';
		}else{
			if(empty($request['categories_name'])){ $required[] = 'Parameter `categories_name` is empty'; }
		}
		
		if(count($required) > 0){
			$app->contentType('application/json');
			$app->halt(500, json_encode(['status' => 'warning', 'message' => $required]));
		}
		try {
			$db = new Connection();
			$sth = $db->prepare("INSERT INTO {$this->tableName} (`categories_name`) VALUES (:categories_name)");
 
			$sth->bindParam('categories_name', $request['categories_name']);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->contentType('application/json');
			echo json_encode(['status' => 'success', 'message' => 'Record has been successfully created', 'data' => [ 'id' => $db->lastInsertId()]]);
			$db = null;
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			$app->contentType('application/json');
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}
	
	function update($id) {
		$app = Slim::getInstance();
        $request = $app->request->params();
		
		$required = [];
		
		if(isset($request['id'])){
			$required[] = 'Parameter `id` cannot changed';
		}
		
		if(!isset($request['categories_name'])){
			$required[] = 'Parameter `categories_name` required';
		}else{
			if(empty($request['categories_name'])){ $required[] = 'Parameter `categories_name` is empty'; }
		}
		
		if(count($required) > 0){
			$app->contentType('application/json');
			$app->halt(500, json_encode(['status' => 'warning', 'message' => $required]));
		}
		try {
			$db = new Connection();
			$sth = $db->prepare("UPDATE {$this->tableName} SET categories_name = :categories_name WHERE id = :id");
			
			$sth->bindParam('id', $id);
			$sth->bindParam('categories_name', $request['categories_name']);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->contentType('application/json');
			echo json_encode(['status' => 'success', 'message' => 'Record has been successfully updated']);
			$db = null;
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			$app->contentType('application/json');
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}
	
	function delete($id) {
		$app = Slim::getInstance();
		try {
			$db = new Connection();
			$sth = $db->prepare("DELETE FROM {$this->tableName} WHERE id = :id");
			
			$sth->bindParam('id', $id);
			$result = $sth->execute();
	 
			$app->response->setStatus(200);
			$app->contentType('application/json');
			echo json_encode(['status' => 'success', 'message' => 'Record has been successfully deleted']);
			$db = null;
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			$app->contentType('application/json');
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}
	
	function find() {
		$app = Slim::getInstance();
        $request = $app->request->get();
		try {
			$db = new Connection();
			$sql = "SELECT * FROM {$this->tableName} ";
			$where = [];
			
			foreach($request as $name => $value) {
				$where[] = $name." = :".$name;
			}
			
			if(count($where) > 0){
				$sql .= 'WHERE ' . implode(' AND ', $where);
			}
			
			$sth = $db->prepare($sql);
			foreach($request as $name => $value) {
				$sth->bindValue($name, $value);
			}
			$sth->execute();
	 
			$laptop = $sth->fetchAll(PDO::FETCH_ASSOC);
	 
			if($laptop) {
				$app->response->setStatus(200);
				$app->contentType('application/json');
				echo json_encode($laptop);
				$db = null;
			} else {
				throw new PDOException('No records found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			$app->contentType('application/json');
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}
}