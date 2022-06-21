<?php include '../top.php' ?>

<?php 
$debug = false;
if (isset($_GET["debug"])){
    $debug = true;
}

$myFolder = '../data/';
$myFileName = 'Winners';
$fileExt = '.csv';
$filename = $myFolder . $myFileName . $fileExt;

if ($debug)
    print '<p>filename is ' . $filename;
$file = fopen($filename, "r");

if ($debug){
    if ($file) {
        print '<p>File Opened Succesful</p>';
    } else {
        print '<p>File Open Failed</p>';
    }
}

if ($file) {
    if ($debug)
        print '<p>Begin reading data into an array</p>';
    $headers[] = fgetcsv($file);
    
    if ($debug) {
        print '<p>Finished reading headers</p>';
        print '<p>My header array</p><pre>';
        print_r($headers);
        print '</pre>';
 }
    while (!feof($file)) {
        $winnerdetails[] = fgetcsv($file);
 }
    if ($debug) {
        print '<p>Finished reading data. File closed</p>';
        print '<p>My data array<p><pre>';
        print_r($winnerdetails);
        print '</pre></p>';
        
    }
}

fclose($file);
    

?>

<main>
    <article>
        <p> <strong>Since</strong> the very beginning, our founder, Tina Belcher, has always loved collaboration and creativity. She always has enjoyed interacting with locals from the Burlington area, 
        as she thought the key to creativity was collaboration with others. One way she began connecting to the local photography community in Burlington was through a yearly contest.
        Any local professional or beginner photographer has the opportunity to submit a photo to our yearly contest to see which one we believe is best. These image can range from
        nature photos, to city shots. In addition, the photos submitted do not have to be locally taken. We have received photos from multiple different countries, including Iceland
        and Canada. </p>
        
        <p> To submit a photo, click on our "<a href="submit-photo.php">Submit a Photo</a>" tab in the header above, and leave your image! Even if you do not win, we still at Picture Studios appreciate seeing the
            local creativity, and often hang your images around our headquarters as inspiration. Listed below are the past winners of our contest, dating back to our founding year in
            1990. These photographers have ranged from local customers to members we have not seen before. We also have listed a brief description of the images we have selected as
            winners, as a way to display what theme we are looking for when we pick a winner. So read and be inspired, and were looking forward to hopefully seeing your image soon! </p>
        
        <h3>Some of the past winners of our contest include...</h3>
        <table>
            
            <?php
            foreach ($headers as $header) {
                print '<tr>';
                print '<th>' . $header{0} . '</th>';
                print '<th>' . $header{1} . '</th>';
                print '<th>' . $header{2} . '</th>';
                print '</tr>';
            }
            
            foreach ($winnerdetails as $winnerdetail) {
                print '<tr>';
                print '<td>' . $winnerdetail{0} . '</td>';
                print '<td>' . $winnerdetail{1} . '</td>';
                print '<td>' . $winnerdetail{2} . '</td>';
                print '</tr>';
            }
            
            print '<tr><td colspan="3">Total Number of Winners: ' . count($winnerdetails) . '</td></tr>';
            ?>
            
        </table>            
    </article>
</main>

<?php include '../footer.php' ?>

</body>
</html>