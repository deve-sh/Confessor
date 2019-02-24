<?php
     session_start();  // So every user has a seperate database connection.

     /* Lets write a complete Database Driver from Scratch */

     final class dbdriver{         // No Inheritance.
     	static $connection;      // Static so it does not get initialized again and again.


  		/* Database Connector Function. */

     	function connect($host,$username,$password,$dbname){
     		if($host=="" || $username=="" || $password=="" || $dbname=="")
     		{
     			echo "<br/><br/>Information insufficient for connection.";
     			return NULL;
     		}
     		else
     		{
     			$this -> connection = mysqli_connect($host,$username,$password,$dbname) or die("<br/><br/>Could not connect to database.");
     			return ($this -> connection);
     		}
     	}

     	/* Database Query Function. */

     	function query($querystring){
     		if($querystring!="" && $this -> connection)
     		{
     			$queryobject=mysqli_query($this -> connection,$querystring);

     			if($queryobject){
     				return $queryobject;
     			}
     			else
     			{
     				return NULL;
     			}
     		}
     		else
     		{
     			echo "<br/><br/>Information insufficient for Query.";
     		}
     	}

     	/* Database Fetch Function. */

     	function fetch($queryob)
     	{
     		if($queryob){
     			$resobject=mysqli_fetch_assoc($queryob);
     			return $resobject;
     		}
     		else
     		{
     			return NULL;
     		}
     	}

     	/* Escaping Malicious Strings Function */

     	function escape($string){
     		if($string){
     			$string=mysqli_real_escape_string($this -> connection,$string);
     			return $string;
     		}
     		else
     		{
     			return NULL;
     		}
     	}

          function numrows($query){
               if($query){
                    return mysqli_num_rows($query);
               }
               else{
                    return 0;
               }
          }
     }
?>