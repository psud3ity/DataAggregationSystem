<!DOCTYPE html>
<html>
<body>

<?php
class TimeReport
{
    // property declaration
	public $employee_ID;
	public $employee_Name;
	public $start_time;
	public $end_time;
	public $total_time;
	public $client_ID;
	public $client_name;
	public $project_ID;
	public $Date_Created;
	public $Created_By;
	public $status;
	public $timeCorrect = '0';
	public $isError = 0;
	
// Constructor Declaration
	public function __construct($xml, $isXML, $con) {
    //   print "In BaseClass constructor\n" . "<br>";
			if($isXML==0)	{
				$this->employee_ID = $xml->employee_ID;
				$this->employee_Name = $xml->employee_Name;
				$this->start_time = $xml->start_time;
				$this->end_time = $xml->end_time;
				$this->total_time = $xml->total_time;
				$this->client_ID = $xml->client->client_ID;
				$this->client_name = $xml->client->client_name;
				$this->project_ID = $xml->project->project_ID;
				$this->Date_Created = $xml->project->Date_Created;
				$this->Created_By = $xml->project->Created_By;
				$this->status = $xml->project->Status;
			}
 			else	{
				$this->employee_ID = $xml->employee_ID; //
				$this->employee_Name = $xml->employee_name; //
				$this->start_time = $xml->time_record->project_start_time;
				$this->end_time = $xml->time_record->project_end_time;
				
				//Deal with lame XML duration format
				$d = new DateInterval($xml->time_record->project_total_time);
				$this->total_time = $d->format('%H:%I:%S');
				
				$this->client_ID = $xml->client_ID;//
				$this->client_name = $xml->client->client_name;//
				$this->project_ID = $xml->project_ID;//
				$this->Date_Created = $xml->date_created;//
				$this->status = $xml->project_status;//	
				
				}

   }
// method declaration

	public function checkTimeValue($time, $timeType)	{
		
		if(strtotime($time) == false)	{
			$this->isError =1;
			//echo $timeType . " is invalid  " . $time . " Error? " . $this->isError . "<br>";
			return(1);
		}
		else {
			//echo $timeType . " is Valid  " . $time . " <br> <br>";

			return(0);
		}
	
	}
    public function checkTotalTime() {
		// Check to make sure start time, end time, and total time are all valid before trying to calculate.
		if(	($this->checkTimeValue($this->start_time, "Start Time")==0) && ($this->checkTimeValue($this->end_time, "End Time" )) == 0 && ($this->checkTimeValue($this->total_time, "Total Time") == 0))	{
			
			$start = new DateTime($this->start_time);
			$end = new DateTime($this->end_time);
			$interval = $start->diff($end);

			$STR2TIME = new DateTime($this->total_time);
			$MIDNIGHT = new DateTime('00:00:00');
	
			$Total = $MIDNIGHT->diff($STR2TIME);

			if ($Total == $interval)	{
				$this->timeCorrect=0;
			}
			else	{		// CLEANSES DATA FOR INCORRECT TOTAL TIMES
				echo $this->total_time . " Total is mathematically invalid!!! <br>";
				$this->timeCorrect=1;
				echo "Attempting Fix.. " . $interval->format('%H:%I:%S') . "<br>";
				$this->total_time = $interval->format('%H:%I:%S');
				$this->isError =0;
			}
				// If total time checks out, start handling stupidity
			if($start == $end)	{
				//echo "INVALID: Time record is 00:00:00 <br>";
				$this->isError =1;
				return(1);
			}

			// else {
				// echo "Something wrong with this record! <br>";
				// $this->isError =1;
				// return(1);
			// }
		}
	}
	public function checkEmployeeInDB($con) {
			if(empty($this->project_ID)==1)	{
			$this->isError=1;
			}
			if(empty($this->employee_Name)==1)	{
			$this->isError=1;
			}			
			if(empty($this->employee_ID)==1)	{
			$this->isError=1;
			}
			if(empty($this->client_ID)==1)	{
			$this->isError=1;
			}
	// Checks to see if employee is in employees table, if not, employee is added to table.
		
		$query = "SELECT * FROM employees WHERE employee_ID =" . $this->employee_ID;
		//echo "In CheckEmployeeInDB value of employee_ID is " . $this->employee_ID . "<br>";
		
		$data = mysqli_query($con, $query) 
		or die(mysql_error()); 
		
		$testdata = mysqli_fetch_array($data);
		if( empty( $testdata ) )
		{
			//echo "It's empty! <br> <br>";
			// list is empty. Add the thing!
			//echo "<br> Going to add Employee_ID " . $this->employee_ID . "& " . $this->employee_Name . " to employees Table <br>";
			$query = "INSERT INTO employees (employee_ID, employee_Name) VALUES ('" . $this->employee_ID . "','" . $this->employee_Name . "')";
			mysqli_query($con, $query) or die(mysql_error());
		}
	}
	public function checkClientInDB($con) {
		// Checks to see if client is in clients table, if not, client is added to table.
		$query = "SELECT * FROM clients WHERE client_ID =" . $this->client_ID;		
		$data = mysqli_query($con, $query) 
		or die(mysql_error()); 
		
		$testdata = mysqli_fetch_array($data);
		if( empty( $testdata ) )
		{
			$query = "INSERT INTO clients (client_ID, client_name) VALUES ('" . $this->client_ID . "','" . $this->client_name . "')";
			mysqli_query($con, $query) or die(mysql_error());
		}
	}	
	public function checkProjectInDB($con) {
		// Checks to see if project is in projects table, if not, project is added to table.
		
		$query = "SELECT * FROM projects WHERE project_id =" . $this->project_ID;
		//echo "In CheckProjectInDB value of project_id is " . $this->project_ID . "<br>";
		
		$data = mysqli_query($con, $query) 
		or die(mysql_error()); 
		
		$testdata = mysqli_fetch_array($data);
		if( empty( $testdata ) )
		{
			//echo "It's empty! <br> <br>";
			// list is empty. Add the thing!
			//echo "<br> Going to add project_ID " . $this->project_ID . " to projects Table <br>";
			
			// <project>
			// <project_ID>7</project_ID>
			// <Date_Created>2009-07-28</Date_Created>
			// <Status>Closed</Status>
			// <Created_By>Mary Beth</Created_By>
			// </project>
			
			// Also need to add client_ID and use employee_ID instead of employee name!  Going to have to query employees table to return employee_ID based on name, unfortunatley, not a way to handle employees with same name!!!  Also need to figure out how the hell to get client name, most likley using some form of dark magic and $this->
			
			
			//gotta check if there's a value for all these
			if(empty($this->project_ID)==1)	{
				//echo "NO PROJECT_ID!!! BAD DATA <br>";
				
				return(1);
			}
			if(empty($this->Date_Created)==1)	{
				//echo "NO Date Created!!! BAD DATA <br>";
				
				return(1);
				}
			if(empty($this->status)==1)	{
				//echo "NO Status!!! BAD DATA <br>";
				
				return(1);
				}
			if(empty($this->Created_By)==1)	{
				//echo "NO Created_By!!! BAD DATA <br>";
				
				return(1);
				}
			else	{
				$query = "INSERT INTO projects (project_ID, Status, client_id, Created_By) VALUES ('" . $this->project_ID . "','" . $this->status . "','" . $this->client_ID . "','" . $this->employee_ID . "')";
				mysqli_query($con, $query) or die(mysql_error());
				}
		}
	}	
	public function checkTimeRecordInDB($con) {		
		if($this->isError==0)	{
			$query = 
			"SELECT * FROM timereports WHERE start_time='" . $this->start_time . 
			"' AND end_time='" . $this->end_time . 
			"' AND total_time='" . $this->total_time .
			"' AND project_ID='" . $this->project_ID .
			"' AND employee_ID='" .  $this->employee_ID .
			"' AND date_created='" . $this->Date_Created . "';";
			
			$data = mysqli_query($con, $query) 
			or die(mysql_error()); 
			
			$testdata = mysqli_fetch_array($data);
			if( empty($testdata) )	{
				if(empty($this->project_ID)==1)	{
					echo "NO PROJECT_ID!!! BAD DATA <br>";
						$this->isError =1;
						return(1);
					}					
				
				elseif(empty($this->employee_ID)==1)	{
					echo "NO Employee ID!!! BAD DATA <br>";
					
					$this->isError =1;
					return(1);
					}
				elseif(empty($this->start_time)==1)	{
					echo "NO Start Time!!! BAD DATA <br>";
					
					$this->isError =1;
					return(1);
					}
				elseif(empty($this->end_time)==1)	{
					echo "NO End Time!!! BAD DATA <br>";
					
					$this->isError =1;
					return(1);
					}
				elseif(empty($this->total_time)==1)	{
					 echo "NO Total Time!!! BAD DATA <br>";
					
					$this->isError =1;
					return(1);
					}
				elseif(empty($this->Date_Created)==1)	{
					echo "NO Total Time!!! BAD DATA <br>";
					
					$this->isError =1;
					return(1);
					}
				else	{
				//	echo "INSERTING THIS RECORD <br>";
				//	echo $this->displayThisRecord() . "<br>";

					$query = "INSERT INTO timereports (project_ID, employee_ID, start_time, end_time, total_time, date_created) VALUES ('" . $this->project_ID . "','" . $this->employee_ID . "','" . $this->start_time . "','" . $this->end_time . "','" . $this->total_time ."','" . $this->Date_Created . "')";
					mysqli_query($con, $query) or die(mysql_error());
					}
			}
		}
	}
	public function displayThisRecord()	{
		echo "Employee ID: " . $this->employee_ID . " Employee Name: " . $this->employee_Name . " Start Time: " . $this->start_time . " End Time: " .  $this->end_time . " Total Time: " . $this->total_time . " Client ID: " . $this->client_ID . " Client Name: " . $this->client_name  . " project ID : " . $this->project_ID . " Date Created: " . $this->Date_Created . " Created By: " . $this->Created_By . " Status: " . $this->status . "<br>";
		
		
	}
	public function returnRecordArray()	{
		$array = array(
			"employee_ID"  => $this->employee_ID,
			"employee_Name"  => $this->employee_Name,
			"start_time"  => $this->start_time,
			"end_time"  => $this->end_time,
			"total_time"  => $this->total_time,
			"client_ID"  => $this->client_ID,
			"client_name"  => $this->client_name,
			"project_ID"  => $this->project_ID,
			"Date_Created"  => $this->Date_Created,
			"Created_By"  => $this->Created_By,
			"status"  => $this->status,
			); 
			return($array);
	}
	public function fixProjectStatus()	{
		
	}

}  // END OF CLASS
// Declare main functions

function connectToDB()	{
	// Create connection
	$con=mysqli_connect("127.0.0.1","IST420","johnhill","IST420");
	// Check connection
	if (mysqli_connect_errno())	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	} 
	else	{
		return($con);
		}
	}
function closeDBconnection($con)	{
	mysqli_close($con);
}
function displayAsTable($array, $heading, $filename)	{
	echo "<h2> ". $heading . " In " . $filename .  "</h2>";
		echo "<table border='1'>
		<thead>
		<tr> 
		<th> Employee ID </th> 
		<th>Employee Name </th>
		<th>Start Time </th>
		<th> End Time </th>
		<th> Total Time </th>
		<th> Client ID </th>
		<th> Client Name </th>
		<th> Project ID </th>
		<th> Date Created </th>
		<th> Created By </th>
		<th> Status </th>
		</tr> </thead>";
		echo "<tbody>";
			foreach ($array as $error){
			echo'<tr>'; 
			echo'<td>'. $error['employee_ID']."</td>";
			echo'<td>'. $error['employee_Name']."</td>";
			echo'<td>'. $error['start_time']."</td>";
			echo'<td>'. $error['end_time']."</td>";
			echo'<td>'. $error['total_time']."</td>";
			echo'<td>'. $error['client_ID']."</td>";
			echo'<td>'. $error['client_name']."</td>";
			echo'<td>'. $error['project_ID']."</td>";
			echo'<td>'. $error['Date_Created']."</td>";
			echo'<td>'. $error['Created_By']."</td>";
			echo'<td>'. $error['status']."</td>";
			echo'<tr>';
		}
		echo "</tbody> </table>";
}
function ImportData($filename, $isXML, $con)	{
	echo "<h1>" . $filename .  "</h1>";
	$errorArray = array();
	$xml=simplexml_load_file($filename);

	for($x=0; $x<=$xml->count()-1; $x++)	{
		$currentRecord = new TimeReport($xml->time_report[$x],$isXML, $con); // pass second arg to do the things
		$currentRecord->checkTotalTime();
		$currentRecord->checkEmployeeInDB($con);
		$currentRecord->checkClientInDB($con);
		$currentRecord->checkProjectInDB($con);
		$currentRecord->checkTimeRecordInDB($con);
			if($currentRecord->isError == 1)	{
				$errorArray[] = $currentRecord->returnRecordArray();
				}
		}
	displayAsTable($errorArray, "Errors", $filename);
		

	}



// MAIN

$con = connectToDB();
ImportData("fileA.xml", 0, $con);
ImportData("fileB.xml", 0, $con);
ImportData("fileC.xml", 1, $con);
ImportData("fileD.xml", 0, $con);
closeDBconnection($con);


	
	
?> 



</body>
</html>