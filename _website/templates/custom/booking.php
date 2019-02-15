<?php defined('DIR') OR exit; 
    $prod = db_fetch("select * from catalogs where id='".$_GET["product"]."' and language='".l()."'");
    $cat1 = db_fetch("select * from menus where id='".$prod["catalogid"]."' and language='".l()."'");
    $cat2 = db_fetch("select * from pages where attached='".$cat1["title"]."' and language='".l()."'");
$message =  $cat2["title"] . " / " . '<strong>' . $prod["title"] . '</strong><br />' . 
            'Name: ' . post('name') . '<br />' . 
            'E-Mail: ' . post('email') . '<br />' .  
            'Phone: ' . post('phone') . '<br />' .  
            // 'Order Date: ' . post('tourdate') . '<br />' .  
            // 'Subject: ' . post('subject') . '<br />' .  
            'Message: ' . post('comment');
$alert = "";
$captchaErr = "";
$nameErr = $emailErr = $phoneErr = $subjectErr = "";
$name = $email = $phone = $subject = $comment = "";
if(isset($_POST['captcha'])) {

    if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",s('feedback'))) {
        
        if (!empty($_SESSION[CAPTCHA_SESSION_ID]) && strtoupper($_POST['captcha']) == strtoupper($_SESSION[CAPTCHA_SESSION_ID])) {
            $field = true;
        } 
        else {
            $captchaErr = '<div class="error">'.l('captcha.incorrect').'</div>';
            $field = false;
        }

        if (empty($_POST["name"])) {
            $nameErr = l('contact.name') .' '. l('required');
            $field = false;
        }
        else {
         $name = test_input($_POST["name"]);
         if (!preg_match("/[a-zA-Z\p{Cyrillic}\p{Georgian}\s]+$/u",$name))
           {
           $nameErr = l('invalid.name'); 
           $field = false;
           }
        }
       
        if (empty($_POST["email"])) {
            $emailErr = l('contact.email') .' '. l('required');
            $field = false;
        }
        else {
         $email = test_input($_POST["email"]);
         if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
           {
           $emailErr = l('invalid.email');
           $field = false;
           }
        }
         
        if (empty($_POST["phone"])) {
            $phoneErr = l('contact.phone') .' '. l('required');
            $field = false;
        }
        else {
         $phone = test_input($_POST["phone"]);
         if (!preg_match("/^[0-9 \-\+()]{4,18}$/",$phone))
           {
           $phoneErr = l('invalid.phone');
           $field = false;
           }
        }

        // if (empty($_POST["subject"])) {
        //     $subjectErr = l('contact.subj') .' '. l('required');
        //     $field = false;
        // }
        // else {
        //  $subject = test_input($_POST["subject"]);
        //  if (!preg_match("/[a-zA-Z0-9\p{Cyrillic}\p{Georgian}\s]+$/u",$subject))
        //    {
        //    $subjectErr = l('invalid.subject'); 
        //    $field = false;
        //    }
        // }

        if (empty($_POST["comment"])) {
            $comment = "";
        }
        else {
            $comment = test_input($_POST["comment"]);
        }
    
        if ($field!=false) {
            email(post('name'), s('feedback'), '"'.$name.'" ordered '.$prod["title"].' (www.iberica-travel.com)', $message);
            $alert = '<div class="sent">'.l('contact.sent').'</div>';
            $name = $email = $phone = $subject = $comment = "";
        }
        else {
            $alert = '<div class="error">'.l('contact.not_sent').'</div>';
        }
    }
    else {
            $alert = '<div class="error">'.l('contact.err').'</div>';
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<?php 
    if(!isset($_GET["product"]) && !isset($_POST['captcha'])) {
        redirect(href(1));
    }
?>
<main id="content" class="page">
 <section id="location">
            <div class="wrapper fix">
                <ul>
                    <?php echo location();?>
                </ul>
            </div>
            <!-- .wrapper fix -->
        </section>
    <article id="page" class="list contact wrapper">
    <div id="content" class="order-part">
        <div class="order-info">
            <header class="fix">
                <h1 class="title left"><?php echo $title;?></h1>
            </header>
            <?php echo '<a href="' . href($cat2["id"]) . '">' . $cat2["title"] . '</a> / ' . $prod["title"];?>
        </div>
        <div id="feedback">
            <form action="<?php echo href(33)."?product=".$_GET["product"];?>&ajax=1" method="post" name="contactform" id="contactform">
                <input type="hidden" name="product_id" value="<?php echo (isset($_GET["product"])) ? $_GET["product"]:0;?>" />   
            <?php if ($alert!=""): ?>
                <?php echo $alert; ?>
            <?php endif; ?>
               <div class="field msg right">
                        <textarea name="comment" placeholder="<?php echo l('contact.msg'); ?>"><?php echo $comment; ?></textarea>
                    </div>
                   <div class="field">
                        <input type="text" name="name" value="<?php echo $name;?>" placeholder="<?php echo l('contact.name'); ?>" class="input" onBlur="CheckName();" />
                 
                <?php if ($nameErr!=""): ?>
                    <span class="error"><?php echo $nameErr; ?></span>
                <?php endif; ?>
                    <div id="result-name" class="notifier"></div>
                </div>
              
                    <div class="field">
                        <input type="text" name="email" value="<?php echo $email;?>" placeholder="<?php echo l('contact.email'); ?>" class="input" onBlur="CheckEmail();" />
                 
                <?php if ($emailErr!=""): ?>
                    <span class="error"><?php echo $emailErr; ?></span>
                <?php endif; ?>
                    <div id="result-email" class="notifier"></div>
                </div>
             
                    <div class="field">
                        <input type="text" name="phone" value="<?php echo $phone;?>" placeholder="<?php echo l('contact.phone'); ?>" class="input" onBlur="CheckPhone();" />
                   
                <?php if ($phoneErr!=""): ?>
                    <span class="error"><?php echo $phoneErr; ?></span>
                <?php endif; ?>
                    <div id="result-phone" class="notifier"></div>
                </div>
               
                    
                
                 <div class="field-bg fix">
                        <div class="field">
                <?php if ($captchaErr!=""): ?>
                    <?php echo $captchaErr;?>
                <?php endif; ?>
                   
                        <input type="text" name="captcha" value="" placeholder="<?php echo l('enter.code'); ?>" class="input captcha" />
                        <img src="_modules/captcha/captchaImage.php" width="160" height="34" alt="Captcha">
                    </div>
                    </div>
               
                   <div class="button-part fix">
                    <input type="submit" name="submit" value="<?php echo l('send'); ?>" class="button" />
                </div>
            </form>
        </div>
        <!-- #request -->
    </div>
    <!-- #page .fix -->
    </article>
<script type="text/javascript">
function CheckName() {
    var name=document.contactform.name.value;
    var towrite='';
    if (name!='') {
        if (name.match(/^[a-zA-Z АаБбВвГгДдЕеЁЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяაბგდევზთიკლმნოპჟრსტუფქღყშჩცძწჭხჯჰ]*$/)) {towrite='<img src="_website/images/icon-correct.png" width="16" height="16" alt="Correct" />';}
        else {towrite='<img src="_website/images/icon-incorrect.png" width="16" height="16" alt="Incorrect" />';}
    }
    document.getElementById('result-name').innerHTML=towrite;
}
function CheckEmail() {
    var email=document.contactform.email.value;
    var towrite='';
    if (email!='') {
        if (email.match(/([\w\-]+\@[\w\-]+\.[\w\-]+)/)) {towrite='<img src="_website/images/icon-correct.png" width="16" height="16" alt="Correct" />';}
        else {towrite='<img src="_website/images/icon-incorrect.png" width="16" height="16" alt="Incorrect" />';}
    }
    document.getElementById('result-email').innerHTML=towrite;
}
function CheckPhone() {
    var phone=document.contactform.phone.value;
    var towrite='';
    if (phone!='') {
        if (phone.match(/^[0-9 \-\+()]{4,18}$/)) {towrite='<img src="_website/images/icon-correct.png" width="16" height="16" alt="Correct" />';}
        else {towrite='<img src="_website/images/icon-incorrect.png" width="16" height="16" alt="Incorrect" />';}
    }
    document.getElementById('result-phone').innerHTML=towrite;
}
// function CheckSubject() {
//     var subject=document.contactform.subject.value;
//     var towrite='';
//     if (subject!='') {
//         if (subject.match(/^[a-zA-Z0-9 АаБбВвГгДдЕеЁЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяაბგდევზთიკლმნოპჟრსტუფქღყშჩცძწჭხჯჰ]*$/)) {towrite='<img src="_website/images/icon-correct.png" width="16" height="16" alt="Correct" />';}
//         else {towrite='<img src="_website/images/icon-incorrect.png" width="16" height="16" alt="Incorrect" />';}
//     }
//     document.getElementById('result-subject').innerHTML=towrite;
// }
</script>