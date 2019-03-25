<?php

function connect()
{
$con = mysql_connect("127.0.0.1","ptstar","ptstar69fc");
if(!$con)                          
  {
  die('Could not connect: ' . mysql_error());
  return false;
  }
else 
  {
	mysql_select_db("ptstar",$con);
	return $con;
  }
}


function get_select($sql)
{
	$con = connect();
	if($con)
	{	
	$result = mysql_query($sql);
	$i = 0;
	try{

	    while($row = mysql_fetch_array($result))
	    {
		$jieguo[$i] = $row;	
		$i++;
	    }
	    return $jieguo;
	   }catch(MyException $e)
	{
		echo $e;
	}
	}
}


function insert_into($sql)
{
	$con = connect();
	if (!mysql_query($sql,$con))
  	{
 	 	die('Error: ' . mysql_error());
  	}
	else 
	{
		mysql_close($con);
		return true;
	}
}


function update($sql)
{
	$con = connect();
	mysql_query("$sql");
	mysql_close($con);
}
?>
