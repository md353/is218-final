<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
$csv = new CSVLoader();
$data = $csv->openFile('effy2011.csv');
$csv->writeToDatabase($data);
class CSVLoader{
	
	public function openFile($f){
		$firstLine = true;
		$fields;
		$data;
		//Open the $f file and use r for read mode.
		if($handle = fopen($f,"r")){
			//Getting the csv data.
			while($line = fgetcsv($handle)){
				//Was it the first time?
				if($firstLine == true){
					$firstLine = false;
					$fields = $line;
				}
				else{
				//Adding the [] adds a new numerical index. 
				$data[] = array_combine($fields,$line);	
				}
			}
		fclose($handle);
		
		return $data;
		
		}
		else{
			//Could not open file!
			echo "Failed to open the file " . $f;
		}
	}
	
	
	public function writeToDatabase($records){
		$host = "localhost";
		$dbname = "colleges";
		$table = "E2011";
		$user = 'root';
		$pass = 'password';
		try{
		$DBH = new PDO('mysql:host=localhost;dbname=colleges',$user, $pass);
		$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//Let's write to the database
		foreach($records as $record){
			$insert = null;
			foreach($record as $key => $value){
				$insert[] = $value;
			}
			
			print_r($insert);
			
			$STH = $DBH->prepare("insert into $table values(?,?)");
			$STH->execute($insert);	
		}
		
		
		$DBH = null;
		
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
	
			
	}
}
?>