<?php 

 function get_final_url( $url, $timeout = 5 )
 {
    $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

  $cookie = @tempnam("/tmp", "CURLCOOKIE");
$ch = curl_init();
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_ENCODING, "" );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
$content = curl_exec( $ch );
$response = curl_getinfo( $ch );
curl_close ( $ch );

if ($response['http_code'] == 301 || $response['http_code'] == 302)
{
    ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
    $headers = get_headers($response['url']);

    $location = "";
    foreach( $headers as $value )
    {
        if ( substr( strtolower($value), 0, 9 ) == "location:" )
            return get_final_url( trim( substr( $value, 9, strlen($value) ) ) );
    }
}

if (    preg_match("/window\.location\.replace\('(.*)'\)/i", $content, $value) ||
        preg_match("/window\.location\=\"(.*)\"/i", $content, $value)
)
{
    return get_final_url ( $value[1] );
}
else
{
    return $response['url'];
   }
}


function get_redirect_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = curl_exec($ch);
    curl_close($ch);
    // Check if there's a Location: header (redirect)
    if (preg_match('/^Location: (.+)$/im', $headers, $matches))
        return trim($matches[1]);
    // If not, there was no redirect so return the original URL
    // (Alternatively change this to return false)
    return $url;
}
// FOLLOW ALL REDIRECTS:
// This makes multiple requests, following each redirect until it reaches the
// final destination.
function get_redirect_final_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
    curl_exec($ch);
    $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    if ($target)
        return $target;
    return false;
}


function get_http_response_code($theURL) {
    $headers = get_headers($theURL);
    return substr($headers[0], 9, 3);
}

function curlResponseCode($url) {
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_TIMEOUT,10);
$output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

return $httpcode;
}


function stripURL($userInput) {

$input = $userInput;

// in case scheme relative URI is passed, e.g., //www.google.com/
$input = trim($input, '/');

// If scheme not included, prepend it
if (!preg_match('#^http(s)?://#', $input)) {
    $input = 'http://' . $input;
}

$urlParts = parse_url($input);

// remove www
$domain = preg_replace('/^www\./', '', $urlParts['host']);

return $domain;
}

function pure_url($url) {
   if ( substr($url, 0, 7) == 'http://' ) {
      $url = substr($url, 7);
   }
   if ( substr($url, 0, 8) == 'https://' ) {
      $url = substr($url, 8);
   }
   if ( substr($url, 0, 6) == 'ftp://') {
      $url = substr($url, 6);
   }
   if ( substr($url, 0, 4) == 'www.') {
      $url = substr($url, 4);
   }
   return $url;
}


function is_url($uri){
    if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$uri)){
      return TRUE;
    }
    else{
        return false;
    }
}



function url_parser($url) {

// multiple /// messes up parse_url, replace 2+ with 2
$url = preg_replace('/(\/{2,})/','//',$url);

$parse_url = parse_url($url);

if(empty($parse_url["scheme"])) {
    $parse_url["scheme"] = "http";
}
if(empty($parse_url["host"]) && !empty($parse_url["path"])) {
    // Strip slash from the beginning of path
    $parse_url["host"] = ltrim($parse_url["path"], '\/');
    $parse_url["path"] = "";
}   

$return_url = "";

// Check if scheme is correct
if(!in_array($parse_url["scheme"], array("http", "https", "gopher"))) {
    $return_url .= 'http'.'://';
} else {
    $return_url .= $parse_url["scheme"].'://';
}

// Check if the right amount of "www" is set.
$explode_host = explode(".", $parse_url["host"]);

// Remove empty entries
$explode_host = array_filter($explode_host);
// And reassign indexes
$explode_host = array_values($explode_host);

// Contains subdomain
if(count($explode_host) > 2) {
    // Check if subdomain only contains the letter w(then not any other subdomain).
    if(substr_count($explode_host[0], 'w') == strlen($explode_host[0])) {
        // Replace with "www" to avoid "ww" or "wwww", etc.
        $explode_host[0] = "www";

    }
}
$return_url .= implode(".",$explode_host);

if(!empty($parse_url["port"])) {
    $return_url .= ":".$parse_url["port"];
}
if(!empty($parse_url["path"])) {
    $return_url .= $parse_url["path"];  
}
if(!empty($parse_url["query"])) {
    $return_url .= '?'.$parse_url["query"];
}
if(!empty($parse_url["fragment"])) {
    $return_url .= '#'.$parse_url["fragment"];
}


return $return_url;
}

function mydate($startdate, $occ){
  $mydatearray = array();
  $date = date_create($startdate);
  $day = $date->format("w");

  $nrdays = $day + 1;
  $nrdays = ($nrdays == 7) ? 0 : $nrdays ;

  $week_start = date_sub($date, date_interval_create_from_date_string($nrdays.' days'));
  $date = $week_start->format('Y-m-d');
  $mydatearray['start'] = $date;
  $startdate = $date;

  $start = DateTime::createFromFormat("Y-m-d",$startdate,new DateTimeZone("Africa/Mogadishu"));
  $interval = new DateInterval("P1D"); // 1 month
  $occurrences = $occ;
  $period = new DatePeriod($start,$interval,$occurrences);

  foreach($period as $dt){
    $mydatearray['day'][] = $dt->format("Y-m-d");
  }

  foreach($period as $dt){
    $mydatearray['week'][] = $dt->format("W");
  }


  foreach($period as $dt){
    $mydatearray['dayname'][] = $dt->format("l");
  }

  foreach($period as $dt){
    $mydatearray['shortdayname'][] = $dt->format("D");
  }
  return $mydatearray;
}

function getDay($weekdaynumber){
    $dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    //$dow_numeric = date('w');
    return $dowMap[$weekdaynumber];
}

function getDayInRange($dateFromString, $dateToString, $daynumber)
{
    $dateFrom = new DateTime($dateFromString);
    $dateTo = new DateTime($dateToString);
    $dates = [];
    $totaldays = 0;
    $wday = date("w", strtotime($dateFromString));
    if ($daynumber < date("w", strtotime($dateFromString))) {
      $plusdays = 7-date("w", strtotime($dateFromString))+$daynumber ;
    } else {
      $plusdays = $daynumber - date("w", strtotime($dateFromString)) ;
    }
    

    if ($dateFrom > $dateTo) {
        return $dates;
    }

    if ($daynumber != $dateFrom->format('N')) {
        //$dateFrom->modify("-{$wday} day");
        $dateFrom->modify("+{$plusdays} day");
    }

    while ($dateFrom <= $dateTo) {
        $dates[] = $dateFrom->format('Y-m-d');
        $dateFrom->modify('+1 week');
    }

    return $dates;
}

function getTotalDaysInRange($dateFromString, $dateToString, $daynumber = 1)
{
    $dateFrom = new DateTime($dateFromString);
    $dateTo = new DateTime($dateToString);
    $dates = [];
    $totaldays = 0;

    if ($dateFrom > $dateTo) {
        return $dates;
    }

    if ($daynumber != $dateFrom->format('N')) {
        $dateFrom->modify('next monday');
    }

    while ($dateFrom <= $dateTo) {
        $dates[] = $dateFrom->format('Y-m-d');
        $dateFrom->modify('+1 week');
    }

    $totaldays = count($dates);

    return $$totaldays;
}

function showstatus($statusid){
  if($statusid) return "active";
  else return "disabled";
}

function activesite($site){
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace('/', '', $url);
  //$url = str_replace('.php', '', $url);

  if (preg_match('/'.$site.'/',$url))
    echo 'active';
}

function activesite_return($site){
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace('/', '', $url);
  //$url = str_replace('.php', '', $url);

  if (preg_match('/'.$site.'/',$url))
    return 'active';
}

function isactivesite($site){
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace('/', '', $url);
  $url = str_replace('.php', '', $url);
  if($site == $url){
    return true;
  } return false;
}

function activesitename3(){
  $url = $_SERVER['REQUEST_URI'];
  $url = str_replace('/', '', $url);
  $url = str_replace('.php', '', $url);
  return $url; 
}

function getchar($string, $offset) {
  $offset = $offset - 1;
    //$string = strrev($string); //reverse the string
    return $string[$offset];
}

function getcharrev($string, $offset) {
  $offset = $offset - 1;
  $string = strrev($string); //reverse the string
  return $string[$offset];
}

function activesitename()
{
    $filename = baseName($_SERVER['REQUEST_URI']);
    $ipos = strpos($filename, "?");
    if ( !($ipos === false) )   $filename = substr($filename, 0, $ipos);
    $filename = str_replace('.php', '', $filename);
    return $filename;
}

function hasaccess($roleid){
    $filename = baseName($_SERVER['REQUEST_URI']);
    $ipos = strpos($filename, "?");
    if ( !($ipos === false) )   $filename = substr($filename, 0, $ipos);
    $filename = str_replace('.php', '', $filename);
    $pagename =  $filename;

    if (isset($roleid) && isset($pagename)) {

      $page = new Page();
      $page->findname($pagename);
      $page = $page->data();
      $pageid = $page->id;
      
      $sqlquery = "SELECT * FROM pagepermissions WHERE deleted = 0 and pageid = $pageid and roleid = $roleid order by id DESC";
      $gbvcasecount = 0;

      $gbvcasestatuss = DB::getInstance()->query($sqlquery);

      if($gbvcasestatuss->count())
      {
         return true; 
      } else return false;


    }

  return false; 
}

function yesno($id){
  if ($id == 1) {
    return "Yes";
  } else if ($id == 2) {
    return "No";
  }
}

function noyes($id){
  if ($id == 1) {
    return "No";
  } else if ($id == 2) {
    return "Yes";
  }
}

function noyes1($id){
  if ($id) {
    return "YES";
  } else {
    return "NO";
  }
}

function haspageaccess($ROLEID,$pagename){
    
    if (isset($roleid) && isset($pagename)) {
      $sqlquery = "SELECT * FROM pagepermissions pp, pages p WHERE pp.deleted = 0 and pp.pageid = p.id and p.href = '$pagename' and pp.roleid = $ROLEID order by pp.id DESC";
      $pageroles = DB::getInstance()->query($sqlquery);
      if($pageroles->count())
      {
         return "TRUE"; 
      } else return "FALSE";


    } else {
      return "FALSE";
    }
}

function SaveThumbnail($imagePath, $saveAs, $max_x, $max_y) 
{
    ini_set("memory_limit","32M");
    $im  = imagecreatefromjpeg ($imagePath);
    $x = imagesx($im);
    $y = imagesy($im);

    if (($max_x/$max_y) < ($x/$y)) 
    {
        $save = imagecreatetruecolor($x/($x/$max_x), $y/($x/$max_x));
    }
    else 
    {
        $save = imagecreatetruecolor($x/($y/$max_y), $y/($y/$max_y));
    }
    imagecopyresized($save, $im, 0, 0, 0, 0, imagesx($save), imagesy($save), $x, $y);

    imagejpeg($save, $saveAs);
    imagedestroy($im);
    imagedestroy($save);
}

// returns true if $needle is a substring of $haystack
function contains($word, $string)
{
    return strpos($string, $word) !== false;
}


function thispage()
{
$url = $_SERVER['REQUEST_URI'];
$urlpage = basename($url);
return $urlpage;
}

function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}

function mxchar($str,$val)
{
  return strlen($str)<=$val?$str:substr($str,0,$val).'...';
}

function is_connected()
{
    $connected = @fsockopen("www.google.com", 80);
                                        //website, port  (try 80 or 443)
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;

}


function now_rate()
{
  $file = 'http://www.nationalbanken.dk/_vti_bin/DN/DataService.svc/CurrencyRatesXML?lang=da';
  if(is_connected())
  {
    if(url_exists($file))
    {
    $xml = simplexml_load_file($file);
    $element = $xml->xpath('dailyrates/currency[@code="USD"]/@rate');
    $now_rate = $element[0];
    }
    else $now_rate = 0.00;
  }else $now_rate = 0.00;
return $now_rate;
}

function now_rate_this($this_curr)
{
  $file = 'http://www.nationalbanken.dk/_vti_bin/DN/DataService.svc/CurrencyRatesXML?lang=da';
  if(is_connected())
  {
    if(url_exists($file))
    {
    $xml = simplexml_load_file($file);
    $element = $xml->xpath('dailyrates/currency[@code="'.$this_curr.'"]/@rate');
    $now_rate = $element[0];
    }
    else $now_rate = 0.00;
  }else $now_rate = 0.00;
return $now_rate;
}

function now_rate_date()
{
  $file = 'http://www.nationalbanken.dk/_vti_bin/DN/DataService.svc/CurrencyRatesXML?lang=da';
  if(is_connected())
  {
    if(url_exists($file))
    {
    $xml = simplexml_load_file($file);
    $element = $xml->xpath('dailyrates/currency[@code="USD"]/@rate');
    $now_rate = $element[0];
    $element = $xml->xpath('dailyrates/@id');
    $now_rate_date = $element[0];

    }
    else $now_rate_date = 0;
  }else $now_rate_date = 0;
return $now_rate_date;
}

function right($value, $count){
return substr($value, ($count*-1));
}

function left($string, $count){
return substr($string, 0, $count);
}

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
  $str = @trim($str);
  if(get_magic_quotes_gpc()) {
    $str = stripslashes($str);
  }
  return $str;
}

// konverter tallet med for at vise dansk standard
function d2k($tal){
  $org_tal = number_format($tal,2,".",",");
  if ($tal <> 0) {
    $org_tal = number_format($tal,2,",",".");
  }
  else
  {
    $org_tal = '0,00';
  }
  return $org_tal ;
}

function km_format_resident_date($raw)
{
  $raw = trim((string) ($raw ?? ''));
  if ($raw === '' || $raw === '0000-00-00' || $raw === '1970-01-01') {
    return '';
  }

  $dt = DateTime::createFromFormat('Y-m-d', substr($raw, 0, 10));
  if ($dt instanceof DateTime) {
    return $dt->format('d-m-Y');
  }

  $ts = strtotime(str_replace('/', '-', $raw));
  if ($ts === false || $ts <= 0) {
    return '';
  }

  return date('d-m-Y', $ts);
}

function km_normalize_resident_identity($name, $phone)
{
  $name = strtoupper(trim((string) $name));
  $name = preg_replace('/^\(X\)\s*/', '', $name);
  $phone = preg_replace('/\D+/', '', trim((string) $phone));

  return array(
    'name' => trim($name),
    'phone' => $phone,
  );
}

function km_resident_date_valid($raw)
{
  $raw = trim((string) ($raw ?? ''));
  return $raw !== '' && $raw !== '0000-00-00' && $raw !== '1970-01-01';
}

function km_resident_financial_snapshot($customer)
{
  return array(
    'balance' => $customer->balance,
    'totalpaid' => $customer->totalpaid ?? 0,
    'totaldiscount' => $customer->totaldiscount ?? 0,
    'lastmk' => $customer->lastmk,
    'oldbalance' => $customer->oldbalance,
    'usedrate' => $customer->usedrate,
    'orgmk' => $customer->orgmk,
    'deleted' => 0,
  );
}

function km_resident_archive_snapshot($residentRow, $customer, $movedoutDate = null)
{
  $movedoutDate = $movedoutDate ?: date('Y-m-d');

  return array_merge(km_resident_financial_snapshot($customer), array(
    'name' => $residentRow->name,
    'phonenumber' => $residentRow->phonenumber,
    'responsiblename' => $residentRow->responsiblename,
    'responsiblephone' => $residentRow->responsiblephone,
    'booknumber' => $residentRow->booknumber ?? $customer->booknumber,
    'defaultrateid' => $residentRow->defaultrateid ?? $customer->defaultrateid,
    'paidstatusid' => $residentRow->paidstatusid ?? $customer->paidstatusid,
    'remark' => $residentRow->remark ?? $customer->remark,
    'zoneid' => $residentRow->zoneid ?? $customer->zoneid,
    'movedout' => $movedoutDate,
    'updateduserid' => null,
    'updatedtime' => date('Y-m-d H:i'),
    'deleted' => 0,
  ));
}

function km_customer_resident_fields($customer)
{
  return array(
    'name' => $customer->name,
    'customerid' => (int) $customer->id,
    'housenumber' => $customer->housenumber,
    'phonenumber' => $customer->phonenumber,
    'booknumber' => $customer->booknumber,
    'defaultrateid' => $customer->defaultrateid,
    'usedrate' => $customer->usedrate,
    'orgmk' => $customer->orgmk,
    'lastmk' => $customer->lastmk,
    'oldbalance' => $customer->oldbalance,
    'paidstatusid' => $customer->paidstatusid,
    'balance' => $customer->balance,
    'totalpaid' => $customer->totalpaid ?? 0,
    'totaldiscount' => $customer->totaldiscount ?? 0,
    'remark' => $customer->remark,
    'zoneid' => $customer->zoneid,
    'responsiblename' => $customer->responsiblename,
    'responsiblephone' => $customer->responsiblephone,
    'deleted' => 0,
  );
}

function km_sync_customer_resident_record($customerid, $userId = null)
{
  $customerid = (int) $customerid;
  if ($customerid <= 0) {
    return 0;
  }

  $customerTable = new DBTable('customers');
  $customerTable->find($customerid);
  if (!$customerTable->exists()) {
    return 0;
  }

  $customer = $customerTable->data();
  $residentTable = new DBTable('residents');
  $currentResidentId = (int) ($customer->residentid ?? 0);
  $customerIdentity = km_normalize_resident_identity($customer->name, $customer->phonenumber);
  $financialData = km_resident_financial_snapshot($customer);

  $linkedResident = null;
  if ($currentResidentId > 0 && $residentTable->find($currentResidentId)) {
    $linkedResident = $residentTable->data();
    if ((int) ($linkedResident->deleted ?? 0) !== 0
      || km_resident_date_valid($linkedResident->movedout ?? '')) {
      $linkedResident = null;
      $currentResidentId = 0;
    }
  }

  if ($linkedResident) {
    $residentIdentity = km_normalize_resident_identity($linkedResident->name, $linkedResident->phonenumber);
    if ($customerIdentity['name'] === $residentIdentity['name'] && $customerIdentity['phone'] === $residentIdentity['phone']) {
      $residentTable->update(array_merge(
        km_customer_resident_fields($customer),
        $financialData
      ), $currentResidentId);
      return $currentResidentId;
    }
  }

  $today = date('Y-m-d');
  $actorId = (int) ($userId ?? Session::get('USERID') ?? 0);

  if ($linkedResident) {
    $archiveData = km_resident_archive_snapshot($linkedResident, $customer, $today);
    $archiveData['updateduserid'] = $actorId ?: null;
    if (!km_resident_date_valid($linkedResident->movedin ?? '')) {
      $archiveData['movedin'] = $today;
    }
    $residentTable->update($archiveData, $currentResidentId);
  }

  $residents = DB::getInstance()->query(
    'SELECT * FROM residents WHERE deleted = 0 AND customerid = ' . $customerid . ' ORDER BY id DESC'
  );
  if ($residents && $residents->count()) {
    foreach ($residents->results() as $candidate) {
      if ((int) $candidate->id === $currentResidentId) {
        continue;
      }
      $candidateIdentity = km_normalize_resident_identity($candidate->name, $candidate->phonenumber);
      if ($customerIdentity['name'] === $candidateIdentity['name']
        && $customerIdentity['phone'] === $candidateIdentity['phone']
        && !km_resident_date_valid($candidate->movedout ?? '')) {
        $residentTable->update(array_merge(km_customer_resident_fields($customer), $financialData, array(
          'movedin' => km_resident_date_valid($candidate->movedin ?? '') ? $candidate->movedin : $today,
          'movedout' => '1970-01-01',
          'updateduserid' => $actorId ?: null,
          'updatedtime' => date('Y-m-d H:i'),
        )), (int) $candidate->id);
        $customerTable->update(array('residentid' => (int) $candidate->id), $customerid);
        return (int) $candidate->id;
      }
    }
  }

  $newResidentData = array_merge(km_customer_resident_fields($customer), $financialData, array(
    'movedin' => $today,
    'movedout' => '1970-01-01',
    'createduserid' => $actorId ?: null,
    'createdtime' => date('Y-m-d H:i'),
    'updateduserid' => $actorId ?: null,
    'updatedtime' => date('Y-m-d H:i'),
  ));
  $residentTable->create($newResidentData);
  $newResidentId = (int) $residentTable->lastinsertid();
  $customerTable->update(array('residentid' => $newResidentId), $customerid);

  return $newResidentId;
}

// konverter tallet med for at vise dansk standard
function d2kk($tal){
  $org_tal = number_format($tal,2,",",",");
  if ($tal <> 0) {
    $org_tal = number_format($tal,2,",",",");
  }
  else
  {
    $org_tal = '0,00';
  }
  return $tal;
}

// konverter tallet med for at vise dansk standard
function d4k($tal){
  $org_tal = number_format($tal,4,".",",");
  if ($tal <> 0) {
    $org_tal = number_format($tal,4,",",".");
  }
  else
  {
    $org_tal = '0,0000';
  }
  return $org_tal ;
}

// konverter tilbage med . for at gemme
function d2p($tal){

  $org_tal = number_format($tal,2,".",",");

  $tal = str_replace(".", "", $tal);
  $tal = str_replace(",", ".", $tal);

  $tal = str_replace(",", ".", $tal);
  if($tal == 0) $org_tal = '0.00';
  return $org_tal ;
}

function d2pp($tal){
  $org_tal = number_format($tal,2,".",",");
  $tal = str_replace(".", "", $tal);
  $tal = str_replace(",", ".", $tal);

  if($tal == 0) $org_tal = '0.00';
  return $org_tal ;
}

function d2($tal){
  $org_tal = number_format($tal,2,".","");
  if($tal == 0) $org_tal = '0.00';
  return $org_tal ;
}

function decimal2($tal){
  $tal = str_replace(",", "", $tal);
  $org_tal = number_format($tal,2,".","");
  if($tal == 0) $org_tal = '0.00';
  return $org_tal ;
}


function koma2punktum($tal){
  $tal = str_replace(",", "", $tal);
  $org_tal = number_format($tal,2,".","");
  if($tal == 0) $org_tal = '0.00';
  return $org_tal ;
}

function uspformat($tal){
  $org_tal = number_format($tal,2,"."," ");
  if($tal == 0) $org_tal = '0.00';
  return $org_tal ;
}


function idag(){
  $zone=3600*1;
  $date_time=gmdate("Y-m-d H:i:s", time() + $zone);
  return $date_time;
}

function unumber($nrformat,$number){
  if($nrformat == 0)
  {
    $formatednumber = str_replace(",", "", $number);
    $formatednumber = number_format($formatednumber,2,".","");
    if($number == 0) $formatednumber = '0.00';
  }
  if($nrformat == 1)
  {
    $formatednumber = str_replace(".", "", $number );
    $formatednumber = str_replace(",", ".", $formatednumber );
    $formatednumber = number_format($formatednumber,2,".","");
    if($number == 0) $formatednumber = '0,00';
  }
  return $formatednumber ;
}

function unumber4($nrformat,$number){
  if($nrformat == 0)
  {
    $formatednumber = str_replace(",", "", $number);
    $formatednumber = number_format($formatednumber,4,".","");
    if($number == 0) $formatednumber = '0.0000';
  }
  if($nrformat == 1)
  {
    $formatednumber = str_replace(".", "", $number );
    $formatednumber = str_replace(",", ".", $formatednumber );
    $formatednumber = number_format($formatednumber,4,".","");
    if($number == 0) $formatednumber = '0,0000';
  }
  return $formatednumber ;
}


function shownumber($nrformat,$number){
  if($nrformat == 0)
  {
    $formatednumber = number_format($number,2,".",",");
    if($number == 0) $formatednumber = '0.00';
  }
  if($nrformat == 1)
  {
    $formatednumber = number_format($number,2,",",".");
    if($number == 0) $formatednumber = '0,00';
  }
  return $formatednumber ;
}

function shownumber4($nrformat,$number){
  if($nrformat == 0)
  {
    $formatednumber = number_format($number,4,".",",");
    if($number == 0) $formatednumber = '0.0000';
  }
  if($nrformat == 1)
  {
    $formatednumber = number_format($number,4,",",".");
    if($number == 0) $formatednumber = '0,0000';
  }
  return $formatednumber ;
}

function convertdate_da($strdate)
{
    $old_date_timestamp = strtotime($strdate);
    $new_date = date('H:i d-m-Y', $old_date_timestamp);
    return($new_date);
}

function convertdate_back($strdate)
{
    $old_date_timestamp = strtotime($strdate);
    $new_date = date('Y-m-d H:i:s ', $old_date_timestamp);
    return($new_date);
}


function usd2dkk($usd,$rate)
{
    // $dkk = ($usd * $rate) / 100;
    $dkk = ($usd * $rate);
    return $dkk;
}


function dkk2usd($dkk,$rate)
{
    //$usd = ($dkk / $rate) * 100;
    $usd = ($dkk / $rate);
    return $usd;
}

  function map_colnames($input)
  {
    global $colnames;
    return isset($colnames[$input]) ? $colnames[$input] : $input;
  }

  function cleanData(&$str)
  {
    // escape tab characters
    $str = preg_replace("/\t/", "\\t", $str);

    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);

    // convert 't' and 'f' to boolean values
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';

    // force certain number/date formats to be imported as strings
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }

    // escape fields that include double quotes
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  function midrate($new_rate,$old_rate,$old_balance,$new_amount)
  {
    $rate_share = ((100/$new_amount)*$old_balance)+100;
    $rate_dif = (($new_rate - $old_rate) / $rate_share) * 100;
    $midrate = $old_rate + $rate_dif;
    return number_format($midrate,2,".","");
  }

 function sendsmsnow($mobile,$message,$senderid)
 {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_URL, 'https://smsapi.hormuud.com/token');
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('Username' => 'FATXI', 'Password' => 'v1WeCLR39ENP9VlyfKfN4Q==', 'grant_type' => 'password')));

      $response = curl_exec($curl);

      $character = json_decode($response);

      $headers = array("Content-Type: application/json; charset=utf-8","Authorization: Bearer ".$character->access_token);

      $data = array(
      "mobile" => $mobile,
      "message" => $message,
      "senderid" => $senderid
      );

      $url = 'https://smsapi.hormuud.com/api/SendSMS';

      $postdata = json_encode($data);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $result = curl_exec($ch);
      curl_close($ch);

      //var_dump($result);
      //echo "<br><br>";

      
      //echo $json->ResponseCode;

      //echo "<br><br>";


      $json = json_decode($result);
      return $json->ResponseCode;
      
 }

  function rate_profit($new_balance,$new_rate_balance,$rate)
  {

    if($new_balance == 0 ) $rate_profit_this = $new_rate_balance;
    if($new_balance < 0 )
    {
      $minus_balance = (-1) * $new_balance;
      $minus_balance = ($minus_balance / $rate);
      $rate_profit_this = $new_rate_balance + $minus_balance;
    }

    if($new_balance > 0 )
    {
      $plus_balance = ($new_balance / $rate);
      $rate_profit_this = $new_rate_balance - $plus_balance;
    }
    return number_format($rate_profit_this,2,".","");
  }

function truncate_text($text, $maxLen)
{
  $text = trim((string)$text);
  if ($maxLen <= 0 || mb_strlen($text) <= $maxLen) {
    return $text;
  }

  return rtrim(mb_substr($text, 0, $maxLen - 1)) . '…';
}

function dt_cell_link($href, $text, $width, $maxChars = 0)
{
  $raw = trim((string)$text);
  $display = ($maxChars > 0) ? truncate_text($raw, $maxChars) : $raw;
  $safeDisplay = htmlspecialchars($display, ENT_QUOTES, 'UTF-8');
  $safeHref = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
  $titleAttr = '';
  $widthStyle = ((int) $width > 0) ? ' style="max-width:' . (int) $width . 'px;"' : '';

  if ($maxChars > 0 && mb_strlen($raw) > $maxChars) {
    $titleAttr = ' title="' . htmlspecialchars($raw, ENT_QUOTES, 'UTF-8') . '"';
  }

  return '<a href="' . $safeHref . '"><div class="divBox divBox-clip"' . $titleAttr . $widthStyle . '>' . $safeDisplay . '</div></a>';
}

 ?>