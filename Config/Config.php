<?php 
	class DbConnect {
		private $host 	= 'localhost';
		private $dbName = 'mysql';
		private $user 	= 'root';
		private $pass 	= '';
		private $SNCFT_db_Name = '';

		public function connecting() {
			try {
				$conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch( PDOException $e) {
				echo 'Database Error: ' . $e->getMessage();
			}
		}
		public function  Connect ()
    {
      $link = mysqli_connect( $this->host, $this->user, $this->pass, $this->dbName);
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 
return $link;
	}
	public function  Connect_To_SNCFT_db ()
    {
      $link = mysqli_connect( $this->host, $this->user, $this->pass, $this->SNCFT_db_Name);
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 
return $link;
    }
	}
 ?>
