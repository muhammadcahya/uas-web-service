<?php

/**  
 * @author Muhammad Cahya <muhammadcahyax@gmail.com>
 * @link http://mynacreative.com/
 * @since 1.0 
 */
 
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get(
    '/',
    function () {
		$html = <<<HTM
			<h1>UAS Web Service</h1>
			<p>
				Web applications & APIs to providing a core structure that enables requests to the API 
				to be properly <i>routed</i> - i.e. sent on to the correct handler that additional capabilities such as high level database access.
			</p>
HTM;
		echo $html;
    }
);

//Connection
define('DB_HOST', 'localhost');
define('DB_NAME', 'uas');
define('DB_USER', 'root');
define('DB_PASS', '');

//Laptop
$app->get	('/laptop',			'\App\Routes\Laptop:index');
$app->get	('/laptop/find',	'\App\Routes\Laptop:find');
$app->get	('/laptop/:id',		'\App\Routes\Laptop:view');
$app->post 	('/laptop',			'\App\Routes\Laptop:create');
$app->map	('/laptop/:id',		'\App\Routes\Laptop:update')->via('PUT', 'PATCH');
$app->delete('/laptop/:id',		'\App\Routes\Laptop:delete');

//PartCategory
$app->get	('/part-category',			'\App\Routes\PartCategory:index');
$app->get	('/part-category/find',		'\App\Routes\PartCategory:find');
$app->get	('/part-category/:id',		'\App\Routes\PartCategory:view');
$app->post 	('/part-category',			'\App\Routes\PartCategory:create');
$app->map	('/part-category/:id',		'\App\Routes\PartCategory:update')->via('PUT', 'PATCH');
$app->delete('/part-category/:id',		'\App\Routes\PartCategory:delete');

//Part
$app->get	('/part',					'\App\Routes\Part:index');
$app->get	('/part/find',				'\App\Routes\Part:find');
$app->get	('/part/by-laptop',			'\App\Routes\Part:byLaptop');
$app->get	('/part/by-laptop/:id',		'\App\Routes\Part:byLaptopId');
$app->get	('/part/by-category',		'\App\Routes\Part:byCategory');
$app->get	('/part/by-category/:id',	'\App\Routes\Part:byCategoryId');
$app->get	('/part/:id',				'\App\Routes\Part:view');
$app->post 	('/part',					'\App\Routes\Part:create');
$app->map	('/part/:id',				'\App\Routes\Part:update')->via('PUT', 'PATCH');
$app->delete('/part/:id',				'\App\Routes\Part:delete');

$app->run();