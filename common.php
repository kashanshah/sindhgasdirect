<?php
session_start();
error_reporting(0);
set_time_limit(0);
date_default_timezone_set("Asia/Karachi");
$self = $_SERVER['PHP_SELF'];
$Theme = 0;
include("PHPVersionCompatability.php");
include("DBConnection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include "phpmailer/PHPMailer.php";
include "phpmailer/Exception.php";
include "phpmailer/SMTP.php";

global $dbh;
$path = explode("/", $_SERVER["PHP_SELF"]);

if (!function_exists('mysql_connect')) {
    $GLOBALS['dbglobal'] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
    if (mysqli_connect_errno()) {
        printf("Could not connect to the database because: %s\n", mysqli_connect_error());
        exit();
    } else {
        mysqli_select_db($GLOBALS['dbglobal'], DB_NAME);
    }
} else {
    $dbh = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die ('Could not connect to the database because: ' . mysql_error());
    mysql_select_db(DB_NAME);
}


$settingResultSet = mysql_query("SELECT FullName,Logo,CompanyName, SiteTitle, DropboxEmail, Domain, Address, GasRate, RetailGasRate, Email, AlertReceiver, SMTPHost, SMTPUser, SMTPPassword, BarCodeLength, Number, FaxNumber, SMSUsername, SMSPassword, CaptchaVerification FROM configurations ") or die(mysql_error());
$settingRecordSet = mysql_fetch_assoc($settingResultSet);
$ENQUIRIES_CATEGORIES = array("General enquiries", "Advertisement enquiries", "Website feedback", "Other comments");

define("ROLE_ID_ADMIN", 1);
define("ROLE_ID_DRIVER", 2);
define("ROLE_ID_SHOP", 3);
define("ROLE_ID_CUSTOMER", 4);
define("ROLE_ID_SALES", 5);
define("ROLE_ID_PLANT", 6);
define("ROLE_ID_USER", 7);
define("FULL_NAME", dboutput($settingRecordSet["FullName"]));
define("DATE_TIME_NOW", dboutput($settingRecordSet["DropboxEmail"]).' '.date('h:i:s'));
define("COMPANY_NAME", dboutput($settingRecordSet["CompanyName"]));
define("SITE_TITLE", dboutput($settingRecordSet["SiteTitle"]));
define("ADDRESS", dboutput($settingRecordSet["Address"]));
define("GAS_RATE", dboutput($settingRecordSet["GasRate"]));
define("RETAIL_GAS_RATE", dboutput($settingRecordSet["RetailGasRate"]));
define("PHONE_NUMBER", dboutput($settingRecordSet["Number"]));
define("FAX_NUMBER", dboutput($settingRecordSet["FaxNumber"]));
define("SITE_DOMAIN", dboutput($settingRecordSet["Domain"]));
define("EMAIL_ADDRESS", dboutput($settingRecordSet["Email"]));
define("ALERT_RECEIVER", dboutput($settingRecordSet["AlertReceiver"]));
define("SMTP_HOST", dboutput($settingRecordSet["SMTPHost"]));
define("SMTP_USER", dboutput($settingRecordSet["SMTPUser"]));
define("SMTP_PASSWORD", dboutput($settingRecordSet["SMTPPassword"]));
define("SITE_LOGO", dboutput($settingRecordSet["Logo"]));
define("SMS_USERNAME", dboutput($settingRecordSet["SMSUsername"]));
define("SMS_PASSWORD", dboutput($settingRecordSet["SMSPassword"]));
define("CAPTCHA_VERIFICATION", dboutput($settingRecordSet["CaptchaVerification"]));
define("BARCODE_LENGTH", dboutput($settingRecordSet["BarCodeLength"]));


define("NOREPLY_EMAIL_ADDRESS", "no-reply@saudiwages.com");

define("SITE_URL", "http://" . SITE_DOMAIN);
define("SITE_URL_SSL", "https://" . SITE_DOMAIN);

define("TITLE", SITE_TITLE . " Administration");
define("HEADER_TEXT", ".:: " . COMPANY_NAME . " -- Administrator Panel ::.");
define("COPYRIGHT", "Copyright &copy; " . date("Y") . " <a href=\"" . SITE_URL . "\" target=\"_blank\">" . COMPANY_NAME . "</a>, All rights reserved.");

$current_url = urlencode($url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

define("DIR_MODULES", "modules/");

define("MANDATORY", "<span class=\"mandatory noPrint\">*</span>");
define("THUMB_WIDTH", 72); //In Pixel
define("THUMB_HEIGHT", 72); //In Pixel
define("INDENT", "&nbsp;&nbsp;&nbsp;");
define("MAX_IMAGE_SIZE", 5120); //In KB

define("DIR_PAYMENT_IMAGES", "assets/payments/");
define("DIR_USER_IMAGES", "assets/users/");
define("DIR_LOGO_IMAGE", "assets/logo/");
define("DIR_PRODUCT_IMAGES", "assets/product/");
define("DIR_PURCHASE_INVOICE", "assets/purchaseinvoices/");
define("DIR_SALE_INVOICE", "assets/saleinvoices/");

$__RETURNSTATUS = array("Not Returned", "Returned");


$_AD = array("<i class=\"fa fa-fw fa-times-circle\"></i>", "<i class=\"fa fa-fw fa-check-circle\"></i>");

/*$SQL = "SELECT m.ContentKey, m.ContentType, md.Contents FROM misc_contents m LEFT JOIN misc_contents_details md on md.ContentID = m.ID AND md.LanguageID=".(int)LANGUAGE_ID." WHERE m.FileName='AllFiles'";
$rk = mysql_query($SQL) or die(mysql_error());
while($RsK = mysql_fetch_assoc($rk))
{
    if($RsK["ContentType"] == 1)
        $v = nl2br(dboutput($RsK["Contents"]));
    else
        $v = dboutput($RsK["Contents"]);

    define(dboutput($RsK["ContentKey"]), $v);
}
*/
$current_url = urlencode($url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

$_SALES_AGENT_STATUS = array("Cancelled", "Callback", "Saved", "Completed");
$_SALES_ADMIN_STATUS = array("Pending", "Approved", "Decline", "Charge Back", "Refund", "Cancel");
$_SALES_ADMIN_STATUS_COLOR = array("cyan", "green", "red", "yellow", "#3c8dbc", "black");
$_SALES_ADMIN_STATUS_COLOR_TEXT = array("black", "white", "white", "black", "white", "white");
$_IMAGE_ALLOWED_TYPES = array("jpg", "jpeg", "gif", "png", "PNG");
$_FILE_ALLOWED_TYPES = array("pdf", "PDF");
$_PACKAGE_TYPES = array("-- Not Selected --", "Corporate", "Individual");
$_USERS_TYPES = array("-- Not Selected --", "Corporate", "Individual");
$_CATEGORY_TYPES = array("-- Not Selected --", "Company Profile", "Salary Report", "Feedback");
$_FORM_TYPES = array("-- Not Selected --", "Corporate", "Individual");
$_AD = array("Deactive", "Active");
$_OPEN_IN = array("_self", "_blank");
$_INPUT_TYPE = array("", "Radio", "Selection", "Textbox");
$_QUESTION_MODULES = array("", "Countries", "Industries", "Educations", "Experiances", "Occupation", "Skills", "KSA Cities", "Spciality (Majors)", "Traning Courses");
$_EXP_MONTH = array("", "1", "2", "3", "6", "9", "12", "24", "48");
$_MARK_AS = array("", "Gender", "Grade", "Company Size");
$_MARK_AS_COMPANY = array("", "Company Size", "Industry", "KSA City");
$_GENDER = array("", "Male", "Female");
$_ADS_POSITION = array("", "Header", "Sidebar");
$_AD_FILE_NAMES = array("", array("Main Page", "Index.php"), array("Dashboard", "Dashboard.php"), array("Pages", "Page.php"), array("Login", "Login.php"),
    array("Registration", "Registration.php"), array("404", "404.php"),);
$_INSTITUTE_TYPE = array("", "College/University", "Vocational/Technical", "Other");
$_MAJOR_TYPES = array("", "Scientific", "Non Scientific");
$_MAJOR_TYPES_UNIVERSITY = array("", "Normal", "Vocational");
$_QUESTION_MODULES_CORPORATE = array("", "Industries", "KSA Cities", "How old is your company", "How many Branchs", "How long to fill position (Time to Fill)", "How long to join position (Time to Join)", "How do you rate your Salary in your industry");
$_MISC_TYPE = array("Heading", "Message", "HTML", "Image");
$_EXCLUDEED_FILES = array("--Index.php", "Blank.php", "BuyPackage.php", "BuyUsers.php", "CompanyProfile(WithoutModules).php", "CompanyProfile1.php", "CorporateForm.php", "CorporateUsers.php", "Countries.php", "Dashboard2.php", "Faqs.php", "Header1.php", "IndividualForm.php", "IndividualSalaryReport(02-05-14).php", "IndividualSalaryReport-backup(20-04-14).php", "IndividualUsers.php", "Industries.php", "Institutes.php", "Logout.php", "Majors.php", "NationalCategories.php", "News.php", "QuestionCategories.php", "Questions.php", "Sidebar.php", "buy_package.php", "buy_report_corporate.php", "chart.php", "check.php", "check_user_login.php", "circles.php", "display_image.php", "form.php", "index--.php", "index2.php", "inner.php", "inquiries.php", "ipnac.php", "ipnc.php", "ipnlistener.php", "ipnp.php", "ipnpa.php", "ipnu.php", "print_session.php", "profile_check.php", "profile_indicator.php", "question_rivision---.php", "question_rivision--.php", "report1.php", "report2.php", "report___.php", "rivision(WithoutAnswer).php", "rivision(WithoutSubAnswer).php", "s.php", "salary_report1.php", "show_cities.php", "skill_details.php", "test.php", "thumbnail_generator.php", "up.php", "user_credits.php", "user_info.php", "user_reports_display.php", "user_side_bar.php", "view_list.php", "view_salary_report-old.php", "view_salary_report-test.php", "view_salary_report_test.php");
/*
$_YN=array(HEADING_OPTION_NO, HEADING_OPTION_YES);
$_LANGUAGE=array("", HEADING_OPTION_ENGLISH, HEADING_OPTION_ARABIC);
$_AD=array(HEADING_OPTION_DEACTIVATE, HEADING_OPTION_ACTIVATE);
$_CONTENTS_TYPE=array("Heading", "Message", "HTML Contents");

$searchKeywords = HEADING_SEARCH_KEYWORDS;
if(isset($_GET["searchKeywords"]))
    $searchKeywords = trim($_GET["searchKeywords"]);


*/

$Gender_Array = array("Select Gender", "Male", "Female");
$Days_Array = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
$Periods_Array = array("1" => "1st", "2" => "2nd", "3" => "3rd", "4" => "4th", "5" => "5th", "6" => "6th", "7" => "7th", "8" => "8th");
$_MONTHS = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$Gender_Array = array("Select Gender", "Male", "Female");
$Payment_Type = array("Select Payment Type", "Cash", "Cheque");
$Academic_Type = array("Select Academic Type", "First Term", "Half Yearly", "Second Term", "Final Term");
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

function backup_tables($filename = "")
{
    $tables = '*';
    $return = '';
    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    //cycle through
    foreach ($tables as $table) {
        $result = mysql_query('SELECT * FROM ' . $table);
        $num_fields = mysql_num_fields($result);

        $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysql_fetch_row($result)) {
                $return .= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = dbinput($row[$j]);
                    $row[$j] = preg_replace("/\n/", "/\/\n/", $row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }
        $return .= "\n\n\n";
    }

    //save file
    if ($filename != "") {
        $filename = ($filename == "" ? "dbbackup_" . date('DMY') . (date('G') + 3) . date('ia') : $filename);
        $handle = fopen($filename.'.sql', 'w+');
        fwrite($handle, $return);
        fclose($handle);
        return $filename.'.sql';
    } else {
//	header('Pragma: anytextexeptno-cache', true);
//	header("Pragma: public");
//	header("Expires: 0");
//	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//	header("Cache-Control: private", false);
        header("Content-Type: text/plain");
        header("Content-Disposition: attachment; filename=\"" . $filename . ".sql\"");
        echo $return;
        exit();
    }
}

function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}

function ClassStrength($ClassID)
{
    return mysql_num_rows(mysql_query("SELECT ID FROM students WHERE ClassID=" . $ClassID));
}

function MonthTotalIncomes($month)
{
    $res = mysql_query("SELECT COALESCE(SUM(Amount),0) AS Sum FROM incomes WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'");
    $r = mysql_fetch_array($res);
    return $r["Sum"] + MonthFeeCollection($month);
}

function MonthIncomes($month)
{
    $res = mysql_query("SELECT COALESCE(SUM(Amount),0) AS Sum FROM incomes WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'");
    $r = mysql_fetch_array($res);
    return $r["Sum"];
}

function MonthFeeCollection($month)
{
    $res = mysql_query("SELECT COALESCE(SUM(Paid),0) AS Sum FROM feecollection WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'");
    $r = mysql_fetch_array($res);
    return $r["Sum"];
}

function MonthSalaryPayment($month)
{
    $res = mysql_query("SELECT COALESCE(SUM(Paid),0) AS Sum FROM salaryrecord WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'");
    $r = mysql_fetch_array($res);
    return $r["Sum"];
}

function MonthTotalExpenses($month)
{
    $res = mysql_query("SELECT COALESCE(SUM(Paid),0) AS Sum FROM expenses WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'");
    $r = mysql_fetch_array($res);
    return $r["Sum"] + MonthSalaryPayment($month);
}

function MonthExpenses($month)
{
    $res = mysql_query("SELECT COALESCE(SUM(Paid),0) AS Sum FROM expenses WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'");
    $r = mysql_fetch_array($res);
    return $r["Sum"];
}

function MonthExpensesPaid($month)
{
    $res = mysql_query("SELECT COALESCE(SUM(Paid),0) AS Sum FROM payexpenses WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'");
    $r = mysql_fetch_array($res);
    return $r["Sum"];
}

function AdmissionInMonth($month)
{
    return mysql_num_rows(mysql_query("SELECT ID FROM students WHERE date_format(DateAdded, '%m-%Y') = '" . $month . "'"));
}

function checkavailability($table, $column, $name)
{
    return mysql_num_rows(mysql_query("SELECT * FROM " . $table . " WHERE " . $column . "='" . $name . "'"));
}

function GetGrade($percentage)
{
    if ((int)$percentage >= 80)
        return "A+";
    else if ((int)$percentage >= 70 && (int)$percentage < 80)
        return "A";
    else if ((int)$percentage >= 60 && (int)$percentage < 70)
        return "A";
    else if ((int)$percentage >= 50 && (int)$percentage < 60)
        return "A";
    else if ((int)$percentage >= 45 && (int)$percentage < 50)
        return "A";
    else if ((int)$percentage > 45)
        return "Fail";
}

function division($a, $b)
{
    if ($b === 0) {
        return null;
    } else return ((int)$a / (int)$b);
}

function validEmailAddress($email_address)
{
    if (strpos($email_address, " ") > 0)
        return false;

    //return preg_match("^(([\w-]+\.)+[\w-]+|([a-zA-Z]{1}|[\w-]{2,}))@((([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])\.([0-1]?[0-9]{1,2}|25[0-5]|2[0-4][0-9])){1}|([a-zA-Z]+[\w-]+\.)+[a-zA-Z]{2,4})$^", $email_address);

    return filter_var($email_address, FILTER_VALIDATE_EMAIL);
}

function validDate($dt)
{
    if (trim($dt) == "")
        return false;

    $d = explode("/", $dt);
    if (sizeof($d) != 3)
        return false;

    if (!ctype_digit($d[0]) || !ctype_digit($d[1]) || !ctype_digit($d[2]))
        return false;

    return checkdate($d[1], $d[0], $d[2]);
}

function dbinput($string, $allow_html = false)
{
    global $dbh;

    if ($allow_html == false)
        $string = strip_tags($string);

    if (function_exists('mysql_real_escape_string'))
        return mysql_real_escape_string($string, $dbh);
    elseif (function_exists('mysqli_real_escape_string'))
        return mysqli_real_escape_string($GLOBALS['dbglobal'], $string);
    elseif (function_exists('mysql_escape_string'))
        return mysql_escape_string($string);
    elseif (function_exists('mysqli_escape_string'))
        return mysqli_escape_string($GLOBALS['dbglobal'], $string);

    return dbinput($string);
}

function dboutput($string)
{
    return stripslashes($string);
}

function not_null($value)
{
    if (is_array($value)) {
        if (sizeof($value) > 0)
            return true;
        else
            return false;
    } else {
        if ((is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0))
            return true;
        else
            return false;
    }
}

function replace_quote($string)
{
    return str_replace('"', '&quot;', $string);
}

function get_right($ID)
{
    $RoleID = 0;
    $count = 0;
    if (isset($_SESSION["RoleID"]) && ctype_digit($_SESSION["RoleID"]))
        $RoleID = $_SESSION["RoleID"];
    if (!in_array($RoleID, $ID)) {
        $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>You donot have right to perform this action.</b>
			</div>';
        redirect("index.php");
    }
}

function getValue($Table, $Col, $Key, $Val)
{
    $r = mysql_query("SELECT " . dbinput($Col) . " FROM " . dbinput($Table) . " WHERE " . dbinput($Key) . "='" . dbinput($Val) . "'");
    if (mysql_num_rows($r) > 0) {
        $res = mysql_fetch_array($r);
        $ans = $res[dbinput($Col)];
    } else
        $ans = "";
    return $ans;
}

$PageCounter = 0;
function get_menu($parent_id = 0)
{
    global $PageCounter, $_OPEN_IN;
    $rc = mysql_query("SELECT c.ID, c.ParentID, cd.Title, c.ExternalLink, c.LinkTargert
		FROM cms c
		LEFT JOIN cms_details cd ON cd.CMSID = c.ID AND cd.LanguageID='" . (int)LANGUAGE_ID . "'
		WHERE c.ShowInMenu = 1 AND c.Status = 1 AND c.ParentID = '" . (int)$parent_id . "' ORDER BY c.SortOrder, c.ID") or die(mysql_error());
    if (mysql_num_rows($rc) > 0) {
        $PageCounter++;
        echo '<ul' . ($parent_id == 0 ? ' id="menu-main-menu" class="menu"' : ' class="sub-menu"') . '>';


        while ($RsC = mysql_fetch_assoc($rc)) {
            $html = '';
            if (strtolower(dboutput($RsC["ExternalLink"])) == "login.php") {
                if (isset($_SESSION['User']) && $_SESSION['User'] == true) {
                    $Title = "My Account";
                    $href = "Dashboard.php";
                    $html = '<ul id="menu-main-menu" class="menu">
								<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="Dashboard.php"><span id="headertext">Dashboard</span></a></li>
								<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="salary_report.php?agree=true&action=submit_survey"><span id="headertext">Salary Survey</span></a></li>';
                    if (($_SESSION["UserType"] == 1) || ($_SESSION["UserType"] == 2 && $_SESSION["ShowReport"] == 1 && $_SESSION["ParentUserType"] == 1) || ($_SESSION["UserType"] == 2 && $_SESSION["ParentUserType"] == 2 && $_SESSION["ShowReport"] == 1) || ($_SESSION["UserType"] == 2 && $_SESSION["ParentID"] == 0)) {
                        $html .= '<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="ReportManagement.php"><span id="headertext">Reports Management</span></a></li>';
                    }
                    if ((isset($_SESSION["User"]) && $_SESSION["User"] == true) && (($_SESSION["UserType"] == 1 || $_SESSION["IsSubAdmin"] == 1) || ($_SESSION["UserType"] == 2 && $_SESSION["ParentID"] == 0))) {

                        if ((isset($_SESSION["User"]) && $_SESSION["User"] == true) && (($_SESSION["UserType"] == 1 || $_SESSION["Credit_Management"] == 1) || ($_SESSION["UserType"] == 2 && $_SESSION["ParentID"] == 0))) {
                            $html .= '<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="CreditManagement.php"><span id="headertext">Credits Management</span></a></li>';
                        }
                        if ((isset($_SESSION["User"]) && $_SESSION["User"] == true) && (($_SESSION["UserType"] == 1 || $_SESSION["User_Management"] == 1) || ($_SESSION["UserType"] == 2 && $_SESSION["ParentID"] == 0))) {
                            $html .= '<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="UserManagement.php"><span id="headertext">User Management</span></a></li>';
                        }
                        if ((isset($_SESSION["User"]) && $_SESSION["User"] == true) && ($_SESSION["UserType"] == 1 || $_SESSION["Company_Profile"] == 1)) {
                            $html .= '<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="CompanyProfile.php"><span id="headertext">Company Profile</span></a></li>';
                        }
                    }
                    $html .= '<li  id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="' . (isset($_SESSION["User"]) && $_SESSION["User"] == true && $_SESSION["UserType"] == 1 ? "UpdateProfileCorporate.php" : "UpdateProfileIndividual.php") . '"><span id="headertext">Personal Details</span></a></li>';
                    $html .= '<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="Logout.php"><span id="headertext">Logout</span></a></li>';

                    $html .= '</ul>';
                } else {
                    $Title = dboutput($RsC["Title"]);
                    $href = dboutput($RsC["ExternalLink"]);
                }
            } else {
                $Title = dboutput($RsC["Title"]);
                $href = (dboutput($RsC["ExternalLink"]) != "" ? dboutput($RsC["ExternalLink"]) : "Page.php?id=" . $RsC["ID"]);
            }

            if ($parent_id == 0)
                echo '<li id="menu-item-' . $RsC["ID"] . '" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="' . $href . '" target="' . $_OPEN_IN[$RsC["LinkTargert"]] . '"><span id="headertext">' . $Title . '</span></a>' . $html;
            else
                echo '<li id="menu-item-' . $RsC["ID"] . '" class="menu-item menu-item-type-post_type menu-item-object-portfolio"><a href="' . $href . '" target="' . $_OPEN_IN[$RsC["LinkTargert"]] . '"><span id="headertext">' . $Title . '</span></a>';

            get_menu($RsC["ID"]);

            echo '</li>';
        }

        echo '</ul>';
    }

}

function get_pages_ids($parent_id = 0)
{
    global $pages_ids;
    $r = mysql_query("SELECT ID FROM cms  WHERE ParentID = " . (int)$parent_id) or die("Product categories tree select: " . mysql_error());
    if (mysql_num_rows($r) > 0) {
        while ($RsC = mysql_fetch_assoc($r)) {
            $pages_ids .= "," . $RsC["ID"];

            get_pages_ids($RsC["ID"]);
        }

    }
}

function generate_password()
{
    $pass = "";
    $salt = "ABCDEFGHIJKLMNOPQRSTUVWXWZ0123456789abchefghjkmnpqrstuvwxyz";
    srand((double)microtime() * 1000000);
    $i = 0;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($salt, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }

    return $pass;
}

function generate_refno($ID)
{
    $refno = "";
    $salt = "ABCDEFGHIJKLMNOPQRSTUVWXWZ0123456789abchefghjkmnpqrstuvwxyz";
    srand((double)microtime() * 1000000);
    $i = 0;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($salt, $num, 1);
        $refno = $refno . $tmp;
        $i++;
        if ($i == 4)
            $refno = $refno . $ID;
    }

    return $refno;
}

function send_mail($From, $To, $Subject, $Body, $IsHTML = true, $Attachments = array())
{
    $headers = "from: " . SMTP_USER . "\r\n";
    $headers .= "Content-type: text/html\r\n";
    return mail($To, $Subject, $Body, $headers);

}

function get_salary($UserID)
{
    $salary = 0;
    $res = mysql_query("SELECT Salary FROM users WHERE ID = " . (int)$UserID . "");
    $Rs = mysql_fetch_assoc($res);
    $salary = $Rs['Salary'];

    if ($salary != '')
        return $salary;
    else
        return 0;

}

function get_spiffrate($UserID)
{
    $SpiffRate = 0;
    $res = mysql_query("SELECT SpiffRate FROM users WHERE ID = " . (int)$UserID . "");
    $Rs = mysql_fetch_assoc($res);
    $SpiffRate = $Rs['SpiffRate'];

    if ($SpiffRate != '')
        return $SpiffRate;
    else
        return 0;

}

function get_spiff($UserID)
{

    $res = mysql_query("SELECT Total FROM spiff_history WHERE UserID = " . (int)$UserID . " AND Date = CURDATE()");
    $Rnum = mysql_num_rows($res);
    $Rs = mysql_fetch_assoc($res);

    $Total = ($Rnum > 0 ? $Rs['Total'] : 0);

    if ($Total != '')
        return $Total;
    else
        return 0;

}

function get_bonus($UserID)
{

    $res = mysql_query("SELECT Commission FROM commission WHERE UserID = " . (int)$UserID . "");
    $Rs = mysql_fetch_assoc($res);
    $commission = $Rs['Commission'];

    if ($commission != '')
        return $commission;
    else
        return 0;

}

function get_sales($UserID)
{

    $res = mysql_query("SELECT ID FROM sales WHERE UserID = " . (int)$UserID . "");
    $num = mysql_num_rows($res);

    if ($num != '')
        return $num;
    else
        return 0;

}

function get_c_sales($UserID)
{

    $res = mysql_query("SELECT ID FROM sales WHERE UserID = " . (int)$UserID . " AND StatusOfSale=1 ");
    $num = mysql_num_rows($res);

    if ($num != '')
        return $num;
    else
        return 0;

}

function get_sales_chargeback($UserID)
{

    $res = mysql_query("SELECT ID FROM sales WHERE UserID = " . (int)$UserID . " AND StatusOfSale=3 ");
    $num = mysql_num_rows($res);

    if ($num != '')
        return $num;
    else
        return 0;

}

function get_ref_sales($UserID)
{

    $res = mysql_query("SELECT ID FROM sales WHERE UserID = " . (int)$UserID . " AND StatusOfSale=4 ");
    $num = mysql_num_rows($res);

    if ($num != '')
        return $num;
    else
        return 0;

}

function get_sales_cancel($UserID)
{

    $res = mysql_query("SELECT ID FROM sales WHERE UserID = " . (int)$UserID . " AND StatusOfSale=2 ");
    $num = mysql_num_rows($res);

    if ($num != '')
        return $num;
    else
        return 0;

}

function get_new_sales()
{

    $res = mysql_query("SELECT ID FROM sales WHERE Checks = 0 AND Status= 3 ");
    $num = mysql_num_rows($res);

    if ($num != '')
        return $num;
    else
        return 0;

}

function get_my_attendance($UID, $Type)
{
    $NoOfDays = 0;
    $OnTime = 0;
    $Late = 0;

    $res = mysql_query("SELECT NoOfDays,OnTime,Late FROM attendance WHERE UserID = " . (int)$UID . " AND Year = '" . date("Y") . "' AND Month = '" . date("F") . "'") or die(mysql_error());
    $rowss = mysql_num_rows($res);
    $Rs = mysql_fetch_assoc($res);
    $NoOfDays = $Rs['NoOfDays'];
    $OnTime = $Rs['OnTime'];
    $Late = $Rs['Late'];

    if ($rowss == 0)
        return 0;
    else {
        if ($Type == 1)
            return $NoOfDays;
        if ($Type == 2)
            return $OnTime;
        if ($Type == 3)
            return $Late;
    }
}

function get_full_name($UID)
{

    $res = mysql_query("SELECT FirstName,LastName FROM user_profile WHERE UserID = " . (int)$UID . "") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Fname = $Rs['FirstName'] . ' ' . $Rs['LastName'];
    return $Fname;
}

function get_section($UID)
{

    $res = mysql_query("SELECT sec.Section FROM user_profile up LEFT JOIN sections sec ON sec.ID = up.SectionID WHERE up.UserID = " . (int)$UID . "") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Section = $Rs['Section'];
    return $Section;
}

function get_classes($UID)
{

    $res = mysql_query("SELECT cl.Class FROM user_profile up LEFT JOIN classes cl ON cl.ID = up.ClassID WHERE up.UserID = " . (int)$UID . "") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Class = $Rs['Class'];
    return $Class;
}

function count_salaries()
{

    $res = mysql_query("SELECT SUM(Salary) AS TSalary FROM payroll WHERE ID <> 0  AND EmployeeID <> 0") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $TSalary = $Rs['TSalary'];
    return $TSalary;
}

function count_fees()
{

    $res = mysql_query("SELECT SUM(Fee) AS TFee FROM fees WHERE ID <> 0  AND StudentID <> 0") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $TFee = $Rs['TFee'];
    return $TFee;
}

function count_fees_d()
{

    $res = mysql_query("SELECT * FROM user_profile WHERE Salary = 0") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Students = mysql_num_rows($res);
    return $Students * FEES_SCHOOL;
}


function total_students()
{

    $res = mysql_query("SELECT * FROM user_profile WHERE Salary = 0") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Students = mysql_num_rows($res);
    return $Students;
}


function getclass($CID)
{

    $res = mysql_query("SELECT Class FROM classes WHERE ID = " . (int)$CID . "") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Class = $Rs['Class'];
    return $Class;
}

function getsection($CID)
{

    $res = mysql_query("SELECT Section FROM sections WHERE ID = " . (int)$CID . "") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Section = $Rs['Section'];
    return $Section;
}

function get_subject($SID)
{

    $res = mysql_query("SELECT Subject FROM subjects WHERE ID = " . (int)$SID . "") or die(mysql_error());
    $Rs = mysql_fetch_assoc($res);
    $Subject = $Rs['Subject'];
    return $Subject;
}

function getCurrentStatus($ID)
{
    $res = mysql_query("SELECT cs.CylinderID, u.RoleID FROM cylinderstatus cs LEFT JOIN users u ON cs.HandedTo=u.ID WHERE cs.CylinderID = " . (int)$ID . " ORDER BY cs.ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = -1;
    } else {
        $r = mysql_query("SELECT Status FROM cylinders WHERE Status = 1 AND ID = '".$ID."'") or die(mysql_error());
        if(mysql_num_rows($r) == 0){
            $ret = -1;
        }
        else{
            $Rs = mysql_fetch_assoc($res);
            $ret = $Rs['RoleID'];
        }
    }
    return $ret;
}

function getCylinderGasRate($ID)
{
    $res = mysql_query("SELECT cs.*, sd.GasRate FROM cylinderstatus cs LEFT JOIN sale_details sd ON cs.InvoiceID=sd.SaleID WHERE cs.CylinderID = " . (int)$ID . " ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 0;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['GasRate'];
    }
    return $ret;
}

function getCurrentHandedBy($ID)
{
    // RETURNS LAST SHOP ID
    $res = mysql_query("SELECT cs.*, u.ID AS UID FROM cylinderstatus cs LEFT JOIN users u ON cs.PerformedBy=u.ID WHERE cs.CylinderID = " . (int)$ID . " ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['UID'];
    }
    return $ret;
}

function getCurrentHandedTo($ID)
{
    $res = mysql_query("SELECT cs.*, u.ID AS UID FROM cylinderstatus cs LEFT JOIN users u ON cs.HandedTo=u.ID WHERE cs.CylinderID = " . (int)$ID . " ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['UID'];
    }
    return $ret;
}

function getCurrentHandedInvoiceID($ID)
{
    $res = mysql_query("SELECT cs.*, cs.InvoiceID AS UID FROM cylinderstatus cs LEFT JOIN users u ON cs.HandedTo=u.ID WHERE cs.CylinderID = " . (int)$ID . " ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['UID'];
    }
    return $ret;
}

function getCurrentPurchaseShopID($ID)
{
    $res = mysql_query("SELECT p.ShopID AS UID FROM purchases p LEFT JOIN purchase_details pd ON p.ID=pd.PurchaseID WHERE pd.CylinderID = " . (int)$ID . " ORDER BY pd.ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['UID'];
    }
    return $ret;
}

function getCurrentPurchaseInvoiceID($ID)
{
    $res = mysql_query("SELECT PurchaseID AS UID FROM purchase_details WHERE CylinderID = " . (int)$ID . " ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['UID'];
    }
    return $ret;
}

function getCylinderPurchaseRate($ID)
{
    $res = mysql_query("SELECT GasRate AS UID FROM purchase_details WHERE CylinderID = " . (int)$ID . " ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['UID'];
    }
    return $ret;
}

function getUserBalance($ID, $AddBalance=true){
    $TotalUnpaid = 0;
    if(getValue('users', 'RoleID', 'ID', $ID) == ROLE_ID_SHOP){
        $q = "SELECT SUM(p.Total - (p.Balance * p.GasRate) - p.Paid) AS Unpaid, u.Balance FROM purchases p LEFT JOIN users u ON u.ID=p.ShopID WHERE p.ShopID =".(int)$ID;
        $r = mysql_query($q) or die(mysql_error());
        $d = mysql_fetch_array($r);
        $Unpaid = $d["Unpaid"] == "" ? 0 : $d["Unpaid"];
        $TotalUnpaid = -$Unpaid;
        if($AddBalance){
            $TotalUnpaid = $TotalUnpaid + ($d["Balance"] * GAS_RATE);
        }
    }
    else if(getValue('users', 'RoleID', 'ID', $ID) == ROLE_ID_CUSTOMER){
        $q = "SELECT SUM(p.Total - (p.Balance * p.GasRate) - p.Paid) AS Unpaid, u.Balance FROM sales p LEFT JOIN users u ON u.ID=p.CustomerID WHERE p.CustomerID =".(int)$ID;
        $r = mysql_query($q) or die(mysql_error());
        $d = mysql_fetch_array($r);
        $Unpaid = $d["Unpaid"] == "" ? 0 : $d["Unpaid"];
        $TotalUnpaid = -$Unpaid;
        if($AddBalance){
            $TotalUnpaid = $TotalUnpaid + ($d["Balance"] * GAS_RATE);
        }
    }
    return $TotalUnpaid;
}

function getCurrentHandedToRole($ID)
{
    $res = mysql_query("SELECT cs.*, u.RoleID AS UID FROM cylinderstatus cs LEFT JOIN users u ON cs.HandedTo=u.ID WHERE cs.CylinderID = " . (int)$ID . " ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['UID'];
    }
    return $ret;
}

function getCurrentWeight($ID)
{
    $res = mysql_query("SELECT CylinderID, Weight FROM cylinderstatus WHERE CylinderID = " . (int)$ID . "  ORDER BY ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $res = mysql_fetch_array($res);
        $ret = getValue('cylinders', 'TierWeight', 'ID', $ID);
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['Weight'];
    }
    return (float)$ret;
}

function getCurrentPurchaseWeight($ID)
{
    $res = mysql_query("SELECT pd.* FROM purchase_details pd LEFT JOIN cylinders c ON c.ID=pd.CylinderID WHERE c.ID = " . (int)$ID . " ORDER BY pd.ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['TotalWeight'];
    }
    return $ret;
}

function getRetailPrice($ID)
{
    $res = mysql_query("SELECT pd.* FROM purchase_details pd LEFT JOIN cylinders c ON c.ID=pd.CylinderID WHERE c.ID = " . (int)$ID . " ORDER BY pd.ID DESC LIMIT 1") or die(mysql_error());
    $ret = 0;
    if (mysql_num_rows($res) == 0) {
        $ret = 1;
    } else {
        $Rs = mysql_fetch_assoc($res);
        $ret = $Rs['RetailPrice'];
    }
    return $ret;
}

function financials($Number = 0){
    return number_format((float)$Number, "2", ".");
}

function dumpArray($RoleID = array())
{
    echo '<pre>';
    print_r($RoleID);
    echo '<pre>';
}

function getCylinderStatus($RoleID = 0)
{
    if ($RoleID == -1) {
        $ret = "Empty Cylinder";
    } else if ($RoleID == ROLE_ID_PLANT) {
        $ret = "Filled at Plant";
    } else if ($RoleID == 0) {
        $ret = "Empty at plant";
    } else if ($RoleID == ROLE_ID_DRIVER) {
        $ret = "Dispatched to driver";
    } else if ($RoleID == ROLE_ID_SHOP) {
        $ret = "At shop";
    } else if ($RoleID == ROLE_ID_CUSTOMER) {
        $ret = "Dispatched to customer";
    } else {
        $ret = "Status not found";
    }
    return $ret;
}

function convertNumber($number)
{
    //list($integer, $fraction) = explode(".", (string) $number);
    $integer = $number;
    $fraction = '0';

    $output = "";

    if ($integer{0} == "-") {
        $output = "negative ";
        $integer = ltrim($integer, "-");
    } else if ($integer{0} == "+") {
        $output = "positive ";
        $integer = ltrim($integer, "+");
    }

    if ($integer{0} == "0") {
        $output .= "zero";
    } else {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group = rtrim(chunk_split($integer, 3, " "), " ");
        $groups = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g) {
            $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
        }

        for ($z = 0; $z < count($groups2); $z++) {
            if ($groups2[$z] != "") {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                    $z < 11
                    && !array_search('', array_slice($groups2, $z + 1, -1))
                    && $groups2[11] != ''
                    && $groups[11]{0} == '0'
                        ? " and "
                        : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0) {
        $output .= " point";
        for ($i = 0; $i < strlen($fraction); $i++) {
            $output .= " " . convertDigit($fraction{$i});
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index) {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
        return "";
    }

    if ($digit1 != "0") {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0") {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0") {
        $buffer .= convertTwoDigit($digit2, $digit3);
    } else if ($digit3 != "0") {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0") {
        switch ($digit1) {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1") {
        switch ($digit2) {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else {
        $temp = convertDigit($digit2);
        switch ($digit1) {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit) {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}

function getCustomerDues($ID){
    $q = "SELECT SUM(Total-Paid) AS Unpaid from sales WHERE CustomerID = ". (int)$ID;
    $r = mysql_query($q) or die(mysql_error());
    return number_format((int)mysql_result($r, 0, 0), 2);
}

function getShopDues($ID){
    $q = "SELECT SUM(Total-Paid) AS Unpaid from sales WHERE CustomerID = ". (int)$ID;
    $r = mysql_query($q) or die(mysql_error());
    return number_format((int)mysql_result($r, 0, 0), 2);
}

function sendSMS($to = '', $message, $check = false){
    $username = SMS_USERNAME;
    $password = SMS_PASSWORD;
    $to = $to;
    $from = 'SindhGasDIR';
    $url = "http://api.m4sms.com/api/Sendsms?id=".$username."&pass=" .$password.
        "&mobile=" .$to. "&brandname=" .urlencode($from)."&msg=" .urlencode($message)."";
    //Curl Start

    $ch = curl_init();
    $timeout = 30;
    curl_setopt ($ch,CURLOPT_URL, $url) ;
    curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
    $response = curl_exec($ch) ;
    curl_close($ch) ;
}

function sendUserSMS($to = 0, $message = '', $check = true){
    $response = '';
    $username = SMS_USERNAME;
    $password = SMS_PASSWORD;
    $to = mysql_query("SELECT ID, Number, SendSMS FROM users WHERE ID = " . $to) or die(mysql_error());
    if(mysql_num_rows($to) == 1){
        $r = mysql_fetch_array($to);
        $send = true;
        if($check){
            $send = $r["SendSMS"];
        }
        if($send){
            $from = 'SindhGasDIR';
            $url = "http://api.m4sms.com/api/Sendsms?id=".$username."&pass=" .$password.
                "&mobile=" .$r["Number"]. "&brandname=" .urlencode($from)."&msg=" .urlencode($message)."";
            $ch = curl_init();
            $timeout = 30;
            curl_setopt ($ch,CURLOPT_URL, $url) ;
            curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
            $response = curl_exec($ch) ;
            curl_close($ch) ;
        }
    }
    //return $response;
}

function emaildbbackup($to)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
//        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = SMTP_USER;                 // SMTP username
        $mail->Password = SMTP_PASSWORD;                           // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 26;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom(SMTP_USER, SITE_TITLE);
        $mail->addAddress($to);     // Add a recipient
        $mail->addReplyTo(EMAIL_ADDRESS);
//			$mail->addCC('cc@example.com');
//			$mail->addBCC('bcc@example.com');

        //Attachments
        $filename = 'emailbackups/EMAILBACKUP'.time();
        $attPath = backup_tables($filename);

        $mail->addAttachment($attPath);         // Add attachments
//			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = SITE_TITLE. ' | DB Backup';
        $mail->Body = 'Attached is the db backup of ' . SITE_TITLE . ' taken on '. date('d-m-Y H:i:s');
        $mail->AltBody = 'Attached is the db backup of ' . SITE_TITLE . ' taken on '. date('d-m-Y H:i:s');

        $mail->send();
        echo json_encode(array(
            "message"=>"Message has been sent",
            "code"=>0
        ));
    } catch (Exception $e) {
        echo json_encode(array(
            "message"=>$mail->ErrorInfo,
            "code"=>-1
        ));
    }
}
	

