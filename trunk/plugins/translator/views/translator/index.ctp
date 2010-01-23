<?php // debug($this->data); ?>
<?php

$emailTo = "putkonen.matti@gmail.com"; // the address where the errors reports and translations should be sent to

$poFileName = str_replace("/", "", stripslashes($location));
if(!preg_match("/(.*?).po/", $poFileName)){
        mail($emailTo, "phPo hackalert", $location);
        die();
}

$poFileArray = @file($poFileName) or die("No such file!");


if(isset($_POST['Submit'])){

foreach($poFileArray as $key=>$value){
        if(isset($_POST[$key]))
                $translatedPo[$key]="msgstr \"".stripslashes(htmlspecialchars(urldecode($_POST[$key])))."\"";
        else
                $translatedPo[$key]=$poFileArray[$key];

}

        $prepareEmail = "Name: ".$_POST['name']."\r\n";
        $prepareEmail .= "Email: ".$_POST['email']."\r\n";
        $prepareEmail .= "URL: ".$_POST['url']."\r\n";
        $prepareEmail .= "Language: ".$_POST['lang']."\r\n";


foreach($translatedPo as $key=>$value){
        //echo $value."<br />";
        $prepareEmail .= $value;
}

mail($emailTo, "Translated: $poFileName", $prepareEmail);

echo "<p>Thanks for translating!</p>";

}
else{

        echo '<form action="" method="post" enctype="application/x-www-form-urlencoded">';

        echo "<p>What is your name (for credit):<br />";
        echo '<input name="name" type="text" /></p>';

        echo "<p>What is your email address:<br />";
        echo '<input name="email" type="text" /></p>';

        echo "<p>Do you have a url that I should link to when I credit you:<br />";
        echo '<input name="url" type="text" /></p>';

        echo "<p>What language are you translating to:<br />";
        echo '<input name="lang" type="text" /></p>';

        echo "<p>Translating <strong>$poFileName</strong>:</p>";

        foreach($poFileArray as $key=>$value){
                if(preg_match("/msgid/", $value)){
                        if(preg_match("/msgid \"\"/", $value)){}
                        else{
                                echo "<p>";
                                echo htmlentities(preg_replace("/^msgid \"(.*?)\"$/", "\\1", $value));
                                echo "<br />";
                                echo "<textarea name='".($key+1)."' cols='80' rows='3'></textarea>";
                                echo "</p>";
                                $msgidArray[$key+1] = $value;
                        }
                }
        }
        echo '<input name="Submit" type="submit" value="Submit" />';
        echo "</form>";

}

?>