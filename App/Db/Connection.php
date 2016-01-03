<?php

namespace App\Db;

use PDO;

/**  
 * @author Muhammad Cahya <muhammadcahyax@gmail.com>
 * @link http://mynacreative.com/
 * @since 1.0 
 */

class Connection extends PDO {
    
	private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME;
	
	public function __construct(){
         // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    	=> true,
			PDO::ATTR_EMULATE_PREPARES 	=> false,
            PDO::ATTR_ERRMODE       	=> PDO::ERRMODE_EXCEPTION
        );
		parent::__construct($dsn, $this->user, $this->pass, $options);
    }
}