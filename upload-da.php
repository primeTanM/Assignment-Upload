
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload details</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <div class="upload">
    <?php


    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if(isset($_FILES["document"]) && $_FILES["document"]["error"] == 0)
        {
            $content = file('./students.txt');
            $counter = 0;
            foreach($content as $i){
                if($_POST['reg'] === (substr($i, 0, -2))){
                    
                    $counter=1;
                    break;
                }
            }
            if ($counter === 0){
                echo "ERROR: This registration number doesnt belong to this Class";
            }else{
                
                echo('Class No:   ');
                if($_POST['class'] == "option1"){
                    echo("VL2021220104192\n");
                }else{
                    echo("VL2021220104045\n");
                }
                echo "<br>";
                echo('Name:     ');
                echo(strtoupper($_POST['name']));
                echo "<br>";
                echo('Reg No:     ');
                echo($_POST['reg']);
                echo "<br>";
                $mailid = $_POST['email'];
                echo("E-MAIL :    ");
                echo($mailid);
                echo("  Match: ");
                $user = strstr($mailid, '@', true);
                $firstname = strstr($_POST['name'], ' ', true);
                if(strtoupper($user) == strtoupper($firstname)){
                    echo("True");
                }else{
                    echo("False");
                }
                echo "<br>";
                printf("Date of Submission: %s ",$_POST['date']);
                // echo($_POST['date']);

                $date1 = new DateTime("2021-10-22");
                $date2 = new DateTime($_POST['date']);

                $interval = $date1->diff($date2);
                echo "Difference: " . $interval->days . " days ";

                $duedate = "2021-10-22";
                $date = $_POST['date'];
                $diff = (strtotime($duedate) - strtotime($date));
                if($diff < 0){
                    echo(" (Late Submission)");
                }else{
                    printf(" (Before Due Date)[%s] ",$duedate);
                }

                echo "<br>";
                echo "<br>";
                $file = 'list.txt';
                $allowed_ext = array("pdf" => "application/pdf",
                                    "doc"  => "application/msword",
                                    "txt"  => "text/plain");
                $file_name = $_FILES["document"]["name"];
                $file_type = $_FILES["document"]["type"];
                $file_size = $_FILES["document"]["size"];
                
                // Verify file extension
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                if (!array_key_exists($ext, $allowed_ext))		
                    die("Error: Please select a valid file format.");
                
                // Verify file size - 1MB max
                $maxsize = 1 * 1024 * 1024;

                if ($file_size > $maxsize)		
                    die("Error: Your file exceeds the limit(1MB).");		
            
                // Verify MYME type of the file
                if (in_array($file_type, $allowed_ext))
                {
                    // Check whether file exists before uploading it
                    if (file_exists("upload/".$_FILES["document"]["name"]))			
                        echo $_FILES["document"]["name"]." is already exists.";
                    
                    else
                    {
                        move_uploaded_file($_FILES["document"]["tmp_name"],
                                "uploads/".$_FILES["document"]["name"]);
                        echo "\nYour file was uploaded successfully.";
                    }
                }

                

                else
                {
                    echo "Error: Please try again.";
                }
            }

        }
        else
        {
            echo "Error: ". $_FILES["document"]["error"];
        }

        
    }
    ?>
    </div>
</body>
</html>
