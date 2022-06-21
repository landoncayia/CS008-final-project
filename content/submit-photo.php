<?php include '../top.php';

print PHP_EOL . '<!-- Section 1b. Initialize Form Variables -->' . PHP_EOL;

$firstName = '';

$lastName = '';

$email = '';

$category = '';

$experience = '';

$family = '';
$friend = '';
$client = '';
$oursite = '';
$ad = '';
$other = '';

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["uplImage"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

print PHP_EOL . '<!-- Section 1c. Initialize Form Error Flags -->' . PHP_EOL;

$firstNameERROR = false;

$lastNameERROR = false;

$emailERROR = false;

$categoryERROR = false;

$experienceERROR = false;

$referenceERROR = false;
$totalChecked = 0;

$imageERROR = false;

print PHP_EOL . '<!-- Section 1d. Misc Variables -->' . PHP_EOL;

$errorMsg = array();

$mailed = false;

print PHP_EOL . '<!-- Section 2. Process for when form is submitted -->' . PHP_EOL;

if (isset($_POST["btnSubmit"])) {
    
    print PHP_EOL . '<!-- Section 2a. Security -->' . PHP_EOL;
    
    $thisURL = $domain . $phpSelf;
    
    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry, you cannot access this page. A security breach has'
                . 'been detected and reported.';
        die($msg);
    }
    
    print PHP_EOL . '<!-- Section 2b. Sanitize Data -->' . PHP_EOL;
    
    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    
    $category = htmlentities($_POST["radCategory"], ENT_QUOTES, "UTF-8");
    
    $experience = htmlentities($_POST["lstExperience"], ENT_QUOTES, "UTF-8");
    
    if(isset($_POST["chkFamily"])) {
        $family = true;
        $totalChecked++;
    } else {
        $family = false;
    }
    
    if(isset($_POST["chkFriend"])) {
        $friend = true;
        $totalChecked++;
    } else {
        $friend = false;
    }
    
    if(isset($_POST["chkClient"])) {
        $client = true;
        $totalChecked++;
    } else {
        $client = false;
    }
    
    if(isset($_POST["chkOurSite"])) {
        $oursite = true;
        $totalChecked++;
    } else {
        $oursite = false;
    }
    
    if(isset($_POST["chkAd"])) {
        $ad = true;
        $totalChecked++;
    } else {
        $ad = false;
    }
    
    if(isset($_POST["chkOther"])) {
        $other = true;
        $totalChecked++;
    } else {
        $other = false;
    }
    
    $image = htmlentities(basename($_FILES['uplImage']['name']), ENT_QUOTES, "UTF-8");
    $imgext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    
    print PHP_EOL . '<!-- Section 2c. Validation -->' . PHP_EOL;
    
    if ($firstName == '') {
        $errorMsg[] = 'Please enter your first name';
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = 'Your first name appears to have extra characters.';
        $firstNameERROR = true;
    }
    
    if ($lastName == '') {
        $errorMsg[] = 'Please enter your last name';
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = 'Your last name appears to have extra characters.';
        $lastNameERROR = true;
    }
    
    if ($email == "") {
        $errorMsg[] = 'Please enter your email address';
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {       
        $errorMsg[] = 'Your email address appears to be incorrect.';
        $emailERROR = true;    
    }
    
    if ($category == "") {
        $errorMsg[] = "Please select a category.";
        $categoryERROR = true;
    }
    
    if ($experience == "") {
        $errorMsg[] = 'Please enter your email address';
        $experienceERROR = true;
    }
    
    if ($totalChecked < 1) {
        $errorMsg[] = "Please choose at least one activity";
        $referenceERROR = true;
    }
    
    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["uplImage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["uplImage"]["size"] > 10000000) {
        echo "Sorry, file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != 
            "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG and GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // If everything else is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["uplImage"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["uplImage"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }       
    }
    
    print PHP_EOL . '<!-- Section 2d. Process Form - Passed Validation -->' . PHP_EOL;
    
    if (!$errorMsg) {
        
        print PHP_EOL . '<!-- SECTION: 2e Save Data -->' . PHP_EOL;
        
        $dataRecord = array();
        
        $dataRecord[] = $firstName;
        $dataRecord[] = $lastName;
        $dataRecord[] = $email;
        $dataRecord[] = $category;
        $dataRecord[] = $experience;
        $dataRecord[] = $family;
        $dataRecord[] = $friend;
        $dataRecord[] = $client;
        $dataRecord[] = $oursite;
        $dataRecord[] = $ad;
        $dataRecord[] = $other;
        $dataRecord[] = $image . $imgext;
        
        $myFolder = '../data/';
        $myFileName = 'form-results';
        $fileExt = '.csv';
        $filename = $myFolder . $myFileName . $fileExt;
        
        $file = fopen($filename, 'a');
        
        fputcsv($file, $dataRecord);
        fclose($file);
        
        print PHP_EOL . '<!-- Section 2f. Create message -->' . PHP_EOL;
        
        $message .= '<h2>Here is the information you entered:</h2>';
        $message .= '<table rules="all" style="border: 1px solid black;" cellpadding="10">';
        
        foreach ($_POST as $htmlName => $value) {
            if ($htmlName != 'btnSubmit' && $htmlName != 'MAX_FILE_SIZE') {
                $message .= '<tr><td><strong>';
                $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));

                foreach ($camelCase as $oneWord) {
                    $message .= $oneWord . ' ';
                }
                $message .= '</strong></td>';
                $message .= '<td>' .  htmlentities($value, ENT_QUOTES, "UTF-8") . '</td></tr>';
            }
        }
        
        $message .= '<tr><td><strong>Image</strong></td>';
        $message .= '<td><a href="' . substr(dirname($phpSelf), 0, -7) . 
                'uploads/' . $_FILES["uplImage"]["name"] . '">' . 
                $_FILES["uplImage"]["name"] . '</a></td></tr>';
        
        $message .= '</table>';
        
         print PHP_EOL . '<!-- Section 2g. Mail to user -->' . PHP_EOL;
         
         $to = $email;
         $cc = '';
         $bcc = '';
         $from = 'lcayia@uvm.edu';
         $subject = 'Thanks for submitting a photo!';
         $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    }
}

print PHP_EOL . '<!-- SECTION 3 Display Form -->' . PHP_EOL;

?>

<main>
    <article>
<?php
    
print PHP_EOL . '<!-- SECTION 3a  -->' . PHP_EOL;

if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {
    print '<h2>Thank you for providing your information.</h2>';
    print '<p>For your records a copy of this data has ';
    if (!mailed) {
        print 'not ';
    }
    print 'been sent:</p>';
    print '<p>To: ' . $email . '</p>';
    
    print $message;
} else {
    print '<h2>Submit a Photograph</h2>';
    print '<p class="form-heading">Submit one of your favorite photos for a '
    . 'chance to win our contest!</p>';
    
    print PHP_EOL . '<!-- SECTION 3b Error Messages -->' . PHP_EOL;
    if ($errorMsg) {
        print '<div id="errors">' . PHP_EOL;
        print '<h2>Oops, it appears that your form contains error(s):'
        . '</h2>' . PHP_EOL;
        print '<ol>' . PHP_EOL;
        
        foreach ($errorMsg as $err) {
            print '<li>' . $err . '</li>' . PHP_EOL;
        }
        print '</ol>' . PHP_EOL;
        print '</div>' . PHP_EOL;
    }
    
    print PHP_EOL . '<!-- SECTION 3c html Form -->' . PHP_EOL;
?>
       
<form action = "<?php print $phpSelf; ?>"
      id = "frmRegister"
      method = "post"
      enctype="multipart/form-data">

        <fieldset class="text">
            <legend>Contact Information</legend>
            <p>
                <label class="required" for="txtFirstName">First Name</label>
                <input autofocus
                       <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                       id="txtFirstName"
                       maxlength="45"
                       name="txtFirstName"
                       onfocus="this.select()"
                       placeholder="Enter your first name."
                       tabindex="100"
                       type="text"
                       value="<?php print $firstName; ?>"
                >
            </p>
            
            <p>
                <label class="required" for="txtLastName">Last Name</label>
                <input
                       <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                       id="txtLastName"
                       maxlength="45"
                       name="txtLastName"
                       onfocus="this.select()"
                       placeholder="Enter your last name."
                       tabindex="101"
                       type="text"
                       value="<?php print $lastName; ?>"
                >
            </p>
            
            <p>
                <label class="required" for="txtEmail">Email</label>
                <input
                    <?php if ($emailERROR) print 'class="mistake"'; ?>
                    id="txtEmail"
                    maxlength="45"
                    name="txtEmail"
                    onfocus="this.select()"
                    placeholder="Enter your email address."
                    tabindex="102"
                    type="text"
                    value="<?php print $email; ?>"
                >
            </p>
        </fieldset>
    
        <fieldset class="radio<?php if ($categoryERROR) print ' mistake'; ?>">
            <legend>What kind of photo are you submitting?</legend>
            <p>
                <label class="radio-field">
                    <input type="radio" id="radCategoryEvent" name="radCategory"
                           value="Event" tabindex="103"<?php if ($category == 'Event') echo ' checked="checked" '; ?>>
                    Event</label>
            </p>
            <p>
                <label class="radio-field">
                    <input type="radio" id="radCategoryNature" name="radCategory"
                           value="Nature" tabindex="104"<?php if ($category == 'Nature') echo ' checked="checked" '; ?>>
                    Nature</label>
            </p>
            <p>
                <label>
                    <input type="radio" id="radCategoryPortrait" name="radCategory"
                           value="Portrait" tabindex="105"<?php if ($category == 'Portrait') echo ' checked="checked" '; ?>>
                    Portrait</label>
            </p>
        </fieldset>
        
        <fieldset class="listbox<?php if ($experienceERROR) print ' mistake'; ?>">
            <legend>Photography Experience</legend>
            <p>
                <select
                        id="lstExperience"
                        name="lstExperience"
                        tabindex="106">
                            <option value="" disabled selected hidden>Please choose...</option>
                            <option
                                value="Rookie">Rookie - I took this on my phone just for fun or don't know much about photography.</option>
                            <option
                                value="Amateur">Amateur - I enjoy taking photos, but am not experienced.</option>
                            <option
                                value="Experienced">Experienced - I take lots of photos and try to get the best shots when I see the chance.</option>
                            <option
                                value="Expert">Expert - I own a dedicated camera and consider photography a hobby of mine.</option>
                            <option
                                value="Professional">Professional - I own a dedicated camera and have done professional photography.</option>
                </select>
        </fieldset>
        
        <fieldset class="checkbox<?php if ($referenceERROR) print ' mistake'; ?>">
            <legend>Where did you hear about us? (check all that apply):</legend>
            
            <p>
                <label class="check-field">
                    <input <?php if ($family) print " checked "; ?>
                        id="chkFamily"
                        name="chkFamily"
                        tabindex="107"
                        type="checkbox"
                        value="Family">Family
                </label>
            </p>
            
            <p>
                <label class="check-field">
                    <input <?php if ($friend) print " checked "; ?>
                        id="chkFriend"
                        name="chkFriend"
                        tabindex="108"
                        type="checkbox"
                        value="Friend">Friend
                </label>
            </p>
            
            <p>
                <label class="check-field">
                    <input <?php if ($client) print " checked "; ?>
                        id="chkClient"
                        name="chkClient"
                        tabindex="109"
                        type="checkbox"
                        value="Client">Client
                </label>
            </p>
            
            <p>
                <label class="check-field">
                    <input <?php if ($oursite) print " checked "; ?>
                        id="chkOurSite"
                        name="chkOurSite"
                        tabindex="110"
                        type="checkbox"
                        value="Our Site">Our Site
                </label>
            </p>
            
            <p>
                <label class="check-field">
                    <input <?php if ($ad) print " checked "; ?>
                        id="chkAd"
                        name="chkAd"
                        tabindex="111"
                        type="checkbox"
                        value="Ad">Advertisement
                </label>
            </p>
            
            <p>
                <label class="check-field">
                    <input <?php if ($other) print " checked "; ?>
                        id="chkOther"
                        name="chkOther"
                        tabindex="112"
                        type="checkbox"
                        value="Other">Other
                </label>
            </p>
            
        </fieldset>
    
        <fieldset class="upload">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
            Choose a file to upload:
            <input name="uplImage" id="uplImage" type="file" tabindex="113">
        </fieldset>
    
        <fieldset class="buttons">
            <legend></legend>
            <input class="button" id="btnSubmit" name="btnSubmit" tabindex="114"
                   type="submit" value="Submit">
        </fieldset>
</form>

<?php
    }
?>
    </article>
</main>
<?php include '../footer.php' ?>
</body>
</html>