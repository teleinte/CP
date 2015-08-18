<?php
// Variables used in this script:
//   $summary     - text title of the event
//   $datestart   - the starting date (in seconds since unix epoch)
//   $dateend     - the ending date (in seconds since unix epoch)
//   $address     - the event's address
//   $uri         - the URL of the event (add http://)
//   $description - text description of the event
//   $filename    - the name of this file for saving (e.g. my-event-name.ics)
//
// Notes:
//  - the UID should be unique to the event, so in this case I'm just using
//    uniqid to create a uid, but you could do whatever you'd like.
//
//  - iCal requires a date format of "yyyymmddThhiissZ". The "T" and "Z"
//    characters are not placeholders, just plain ol' characters. The "T"
//    character acts as a delimeter between the date (yyyymmdd) and the time
//    (hhiiss), and the "Z" states that the date is in UTC time. Note that if
//    you don't want to use UTC time, you must prepend your date-time values
//    with a TZID property. See RFC 5545 section 3.3.5
//
//  - The Content-Disposition: attachment; header tells the browser to save/open
//    the file. The filename param sets the name of the file, so you could set
//    it as "my-event-name.ics" or something similar.
//
//  - Read up on RFC 5545, the iCalendar specification. There is a lot of helpful
//    info in there, such as formatting rules. There are also many more options
//    to set, including alarms, invitees, busy status, etc.
//
//      https://www.ietf.org/rfc/rfc5545.txt
if(isset($_GET['token']))
{
	$datos = objectToArray(json_decode(urldecode(base64_decode($_GET['token']))));
}
//var_dump($datos["end"]);
// 1. Set the correct headers for this file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=event.ics'); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

// 2. Define helper functions

// Converts a unix timestamp to an ics-friendly format
// NOTE: "Z" means that this timestamp is a UTC timestamp. If you need
// to set a locale, remove the "\Z" and modify DTEND, DTSTAMP and DTSTART
// with TZID properties (see RFC 5545 section 3.3.5 for info)
//
// Also note that we are using "H" instead of "g" because iCalendar's Time format
// requires 24-hour time (see RFC 5545 section 3.3.12 for info).
function dateToCal($timestamp) {
  return date('Ymd\THis\Z', $timestamp);
}

// Escapes a string of characters
function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}

function objectToArray( $object )
{
    if( !is_object( $object ) && !is_array( $object ) )
    {
        return $object;
    }
    if( is_object( $object ) )
    {
        $object = get_object_vars( $object );
    }
    return array_map( 'objectToArray', $object );
}
function uuidSecure() {

    $pr_bits = null;
    $fp = @fopen('/dev/urandom','rb');
    if ($fp !== false) {
        $pr_bits .= @fread($fp, 16);
        @fclose($fp);
    } else {
        $this->cakeError('randomNumber');
    }
    
    $time_low = bin2hex(substr($pr_bits,0, 4));
    $time_mid = bin2hex(substr($pr_bits,4, 2));
    $time_hi_and_version = bin2hex(substr($pr_bits,6, 2));
    $clock_seq_hi_and_reserved = bin2hex(substr($pr_bits,8, 2));
    $node = bin2hex(substr($pr_bits,10, 6));
    
    /**
     * Set the four most significant bits (bits 12 through 15) of the
     * time_hi_and_version field to the 4-bit version number from
     * Section 4.1.3.
     * @see http://tools.ietf.org/html/rfc4122#section-4.1.3
     */
    $time_hi_and_version = hexdec($time_hi_and_version);
    $time_hi_and_version = $time_hi_and_version >> 4;
    $time_hi_and_version = $time_hi_and_version | 0x4000;
    
    /**
     * Set the two most significant bits (bits 6 and 7) of the
     * clock_seq_hi_and_reserved to zero and one, respectively.
     */
    $clock_seq_hi_and_reserved = hexdec($clock_seq_hi_and_reserved);
    $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved >> 2;
    $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved | 0x8000;
    
    return sprintf('%08s-%04s-%04x-%04x-%012s',
        $time_low, $time_mid, $time_hi_and_version, $clock_seq_hi_and_reserved, $node);
}
// 3. Echo out the ics file's contents
?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Copropiedad.co//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VTIMEZONE
TZID:America/Bogota
BEGIN:DAYLIGHT
TZOFFSETFROM:-0500
DTSTART:19920503T000000
TZNAME:GMT-5
TZOFFSETTO:-0400
RDATE:19920503T000000
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:-0400
DTSTART:19930404T000000
TZNAME:GMT-5
TZOFFSETTO:-0500
RDATE:19930404T000000
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
TRANSP:OPAQUE
DTEND;<?= $datos["end"] . "\n" ?>
UID:<?= uuidSecure() . "\n" ?>
DTSTAMP:<?= dateToCal(time()) . "\n" ?>
LOCATION:<?= escapeString($datos["location"]) . "\n" ?>
DESCRIPTION:<?= escapeString($datos["description"]) . "\n" ?>
STATUS:CONFIRMED
SEQUENCE:0
X-APPLE-TRAVEL-ADVISORY-BEHAVIOR:DISABLED
SUMMARY:TEST
DTSTART;<?= $datos["start"] . "\n" ?>
CREATED:<?= dateToCal(time()) . "\n" ?>
LAST-MODIFIED:<?= dateToCal(time()) . "\n" ?>
BEGIN:VALARM
X-WR-ALARMUID:<?= uuidSecure() . "\n" ?>
UID:<?= uuidSecure() . "\n" ?>
TRIGGER:-P1D
DESCRIPTION:Recordatorio de evento <?= escapeString($datos["description"]) . "\n" ?>
ACTION:DISPLAY
END:VALARM
BEGIN:VALARM
X-WR-ALARMUID:<?= uuidSecure() . "\n" ?>
UID:<?= uuidSecure() . "\n" ?>
TRIGGER:-PT2H
DESCRIPTION:Recordatorio de evento <?= escapeString($datos["description"]) . "\n" ?>
ACTION:DISPLAY
END:VALARM
END:VEVENT
END:VCALENDAR