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

class Part {
	
	public $tableName = 'parts';
	public $tableLaptop = 'laptops';
	public $tablePartCategory = 'parts_categories';
    
	function index() {
		$app = Slim::getInstance();
		$request = $app->request->get();
		try {
			$db = new Connection();
			if(!isset($request['expand'])){
				$sql = "SELECT * FROM {$this->tableName}";
			}else{
				if($request['expand'] == 'laptop'){
					$sql = "SELECT p.*,l.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`)";
				}
				if($request['expand'] == 'part-category'){
					$sql = "SELECT p.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`)";
				}
				if($request['expand'] == 'all'){
					$sql = "SELECT p.*,l.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`)
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`)";
				}
			}
			
			$sth = $db->prepare($sql);
			$sth->execute();
	 
			$laptop = [];
			foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $data){
				if(!isset($request['expand'])){
					$laptop[] = [
						'id' => $data['id'],
						'laptop_id' => $data['laptop_id'],
						'part_category' => $data['part_category'],
						'part_number' => $data['part_number'],
						'description' => $data['description']
					];
				}else{
					if($request['expand'] == 'laptop'){
						$laptop[] = [
							'part_number' => $data['part_number'],
							'description' => $data['description'],
							'laptop' => [
								'id' => $data['laptop_id'],
								'brand' => $data['brand'],
								'model' => $data['model'],
								'release_year' => $data['release_year']
							]
						];
					}
					if($request['expand'] == 'part-category'){
						$laptop[] = [
							'part_number' => $data['part_number'],
							'description' => $data['description'],
							'part_category' => [
								'id' => $data['part_category'],
								'name' => $data['categories_name']
							]
						];
					}
					if($request['expand'] == 'all'){
						$laptop[] = [
							'part_number' => $data['part_number'],
							'description' => $data['description'],
							'laptop' => [
								'id' => $data['laptop_id'],
								'brand' => $data['brand'],
								'model' => $data['model'],
								'release_year' => $data['release_year']
							],
							'part_category' => [
								'id' => $data['part_category'],
								'name' => $data['categories_name']
							]
						];
					}
				}
			}
	 
			if($data) {
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
		$request = $app->request->get();
		try {
			$db = new Connection();
			if(!isset($request['expand'])){
				$sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
			}else{
				if($request['expand'] == 'laptop'){
					$sql = "SELECT p.*,l.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`)
					WHERE p.id = :id";
				}
				if($request['expand'] == 'part-category'){
					$sql = "SELECT p.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`)
					WHERE p.id = :id";
				}
				if($request['expand'] == 'all'){
					$sql = "SELECT p.*,l.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`)
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`)
					WHERE p.id = :id";
				}
			}
			
			$sth = $db->prepare($sql);
			$sth->bindParam('id', $id);
			$sth->execute();
			
			$laptop = [];
			$data = $sth->fetch(PDO::FETCH_ASSOC);
			
			if(!isset($request['expand'])){
				$laptop[] = [
					'id' => $data['id'],
					'laptop_id' => $data['laptop_id'],
					'part_category' => $data['part_category'],
					'part_number' => $data['part_number'],
					'description' => $data['description']
				];
			}else{
				if($request['expand'] == 'laptop'){
					$laptop[] = [
						'id' => $data['id'],
						'part_number' => $data['part_number'],
						'description' => $data['description'],
						'laptop' => [
							'id' => $data['laptop_id'],
							'brand' => $data['brand'],
							'model' => $data['model'],
							'release_year' => $data['release_year']
						]
					];
				}
				if($request['expand'] == 'part-category'){
					$laptop[] = [
						'id' => $data['id'],
						'part_number' => $data['part_number'],
						'description' => $data['description'],
						'part_category' => [
							'id' => $data['part_category'],
							'name' => $data['categories_name']
						]
					];
				}
				if($request['expand'] == 'all'){
					$laptop[] = [
						'id' => $data['id'],
						'part_number' => $data['part_number'],
						'description' => $data['description'],
						'laptop' => [
							'id' => $data['laptop_id'],
							'brand' => $data['brand'],
							'model' => $data['model'],
							'release_year' => $data['release_year']
						],
						'part_category' => [
							'id' => $data['part_category'],
							'name' => $data['categories_name']
						]
					];
				}
			}
			
			if($data) {
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
	
	function byLaptop() {
		$app = Slim::getInstance();
		$request = $app->request->get();
		try {
			$db = new Connection();
			$sql = "SELECT p.*,l.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`)
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`)
					ORDER BY laptop_id";
			$sth = $db->prepare($sql);
			$sth->execute();
	 
			$parts = [];
			$fetch = $sth->fetchAll(PDO::FETCH_ASSOC);
			foreach($fetch as $data){
				$part = $data['brand'].' - '.$data['model'].' ('.$data['release_year'].')';
				$parts[$part][] = [
					'part_number' => $data['part_number'],
					'name' => $data['categories_name'],
					'description' => $data['description']
				];
			}
	 
			if($fetch) {
				$app->response->setStatus(200);
				$app->contentType('application/json');
				echo json_encode($parts);
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
	
	function byLaptopId($id) {
		$app = Slim::getInstance();
		$request = $app->request->get();
		try {
			$db = new Connection();
			$sql = "SELECT p.*,l.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`) 
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`) 
					WHERE laptop_id = :id ORDER BY laptop_id";
			
			$sth = $db->prepare($sql);
			$sth->bindParam('id', $id);
			$sth->execute();
			
			$parts = [];
			$fetch = $sth->fetchAll(PDO::FETCH_ASSOC);
			foreach($fetch as $data){
				$part = $data['brand'].' - '.$data['model'].' ('.$data['release_year'].')';
				$parts[$part][] = [
					'part_number' => $data['part_number'],
					'name' => $data['categories_name'],
					'description' => $data['description']
				];
			}
			
			if($fetch) {
				$app->response->setStatus(200);
				$app->contentType('application/json');
				echo json_encode($parts);
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
	
	function byCategory() {
		$app = Slim::getInstance();
		$request = $app->request->get();
		try {
			$db = new Connection();
			$sql = "SELECT p.*,l.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`)
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`)
					ORDER BY part_category";
			$sth = $db->prepare($sql);
			$sth->execute();
	 
			$categories = [];
			$fetch = $sth->fetchAll(PDO::FETCH_ASSOC);
			foreach($fetch as $data){
				$category = $data['categories_name'];
				$categories[$category][] = [
					'brand' => $data['brand'],
					'model' => $data['model'],
					'release_year' => $data['release_year']
				];
			}
	 
			if($fetch) {
				$app->response->setStatus(200);
				$app->contentType('application/json');
				echo json_encode($categories);
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
	
	function byCategoryId($id) {
		$app = Slim::getInstance();
		$request = $app->request->get();
		try {
			$db = new Connection();
			$sql = "SELECT p.*,l.*,pc.* FROM {$this->tableName} AS `p` 
					INNER JOIN {$this->tableLaptop} AS `l` ON (`p`.`laptop_id` = `l`.`id`) 
					INNER JOIN {$this->tablePartCategory} AS `pc` ON (`p`.`part_category` = `pc`.`id`) 
					WHERE part_category = :id ORDER BY part_category";
			
			$sth = $db->prepare($sql);
			$sth->bindParam('id', $id);
			$sth->execute();
			
			$categories = [];
			$fetch = $sth->fetchAll(PDO::FETCH_ASSOC);
			foreach($fetch as $data){
				$category = $data['categories_name'];
				$categories[$category][] = [
					'brand' => $data['brand'],
					'model' => $data['model'],
					'release_year' => $data['release_year']
				];
			}
			
			if($fetch) {
				$app->response->setStatus(200);
				$app->contentType('application/json');
				echo json_encode($categories);
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
		
		if(!isset($request['laptop_id'])){
			$required[] = 'Parameter `laptop_id` required';
		}else{
			if(empty($request['laptop_id'])){ $required[] = 'Parameter `laptop_id` is empty'; }
		}
		
		if(!isset($request['part_category'])){
			$required[] = 'Parameter `part_category` required';
		}else{
			if(empty($request['part_category'])){ $required[] = 'Parameter `part_category` is empty'; }
		}
		
		if(!isset($request['part_number'])){
			$required[] = 'Parameter `part_number` required';
		}else{
			if(empty($request['part_number'])){ $required[] = 'Parameter `part_number` is empty'; }
		}
		
		if(!isset($request['description'])){
			$required[] = 'Parameter `description` required';
		}
		
		if(count($required) > 0){
			$app->contentType('application/json');
			$app->halt(500, json_encode(['status' => 'warning', 'message' => $required]));
		}
		try {
			$db = new Connection();
			$sth = $db->prepare("INSERT INTO {$this->tableName} (`laptop_id`,`part_category`,`part_number`,`description`) VALUES (:laptop_id,:part_category,:part_number,:description)");
 
			$sth->bindParam('laptop_id', $request['laptop_id']);
			$sth->bindParam('part_category', $request['part_category']);
			$sth->bindParam('part_number', $request['part_number']);
			$sth->bindParam('description', $request['description']);
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
		
		if(!isset($request['laptop_id']) && !isset($request['part_category']) && !isset($request['part_number']) && !isset($request['description'])){
			$required[] = 'Minimum parameters required `laptop_id`, `part_category`, `part_number` or `description`';
		}
		
		if(isset($request['laptop_id']) && empty($request['laptop_id'])){
			$required[] = 'Parameter `laptop_id` is empty';
		}
		
		if(isset($request['part_category']) && empty($request['part_category'])){
			$required[] = 'Parameter `part_category` is empty';
		}
		
		if(isset($request['part_number']) && empty($request['part_number'])){
			$required[] = 'Parameter `part_number` is empty';
		}
		
		if(isset($request['description']) && empty($request['description'])){
			$required[] = 'Parameter `description` is empty';
		}
		
		if(count($required) > 0){
			$app->contentType('application/json');
			$app->halt(500, json_encode(['status' => 'warning', 'message' => $required]));
		}
		try {
			$db = new Connection();
			$sql = "UPDATE {$this->tableName} ";
			$params = [];
			
			foreach($request as $name => $value) {
				if($name != 'id'){
					$params[] = $name." = :".$name;
				}
			}
			
			if(count($params) > 0){
				$sql .= 'SET ' .implode(', ', $params). ' WHERE id = :id';
			}
			
			$sth = $db->prepare($sql);
			$sth->bindParam('id', $id);
			foreach($request as $name => $value) {
				$sth->bindValue($name, $value);
			}
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