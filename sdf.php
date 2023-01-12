<?php
define('MIXED', 'Y/m/d - H:i:s');
define('DATE', 'Y/m/d');
define('TIME', 'H:i:s');
function sDate($format, $timestamp = null){
    if(is_null($timestamp) || empty($timestamp))
        $timestamp = time();
    $mainDate = explode('_', date('H_i_j_n_O_P_s_w_Y', $timestamp));
    [$solarYear, $solarMonth, $solarDay] = greToSolar($mainDate[8], $mainDate[3], $mainDate[2]);
    $pastDays = ($solarMonth < 7) ? (($solarMonth - 1) * 31) + $solarDay - 1 : (($solarMonth - 7) * 30) + $solarDay + 185;
    $leap = (((($solarYear + 12) % 33) % 4) == 1) ? 1:0;
    if($tilde = preg_match_all('#~(.*)~#U', $format, $tildes, 256))
        $tildes = $tildes[1];
    $result = '';
    for($i = 0; $i < mb_strlen($format); $i++){
        $key = mb_substr($format, $i, 1);
        if($key == '\\'){
            $result .= mb_substr($format, ++$i, 1);
            continue;
        }
        if($key == '~' && $tilde){
            $result .= $tildes[0][0];
            $i = strlen($tildes[0][0]) + $tildes[0][1];
            unset($tildes[0]);
            $tildes = array_values($tildes);
            if(count($tildes) == 0) $tilde = false;
            continue;
        }
        switch($key){
            case 'B':
            case 'e':
            case 'g':
            case 'G':
            case 'h':
            case 'I':
            case 'T':
            case 'u':
            case 'Z':
                $result .= date($key, $timestamp);
                break;
            case 'a':
                $result .= ($mainDate[0] < 12) ? 'ق.ظ':'ب.ظ';
                break;
            case 'A':
                $result .= ($mainDate[0] < 12) ? 'قبل از ظهر':'بعد از ظهر';
                break;
            case 'b':
                $result .= (int) ($solarMonth / 3.1) + 1;
                break;
            case 'c':
                $result .= $solarYear . '/' . $solarMonth . '/' . $solarDay;
                break;
            case 'C':
                $result .= (int) (($solarYear + 99) / 100);
                break;
            case 'd':
                $result .= ($solarDay < 10) ? '0' . $solarDay:$solarDay;
                break;
            case 'D':
                $result .= implode(' ', persianFormat(['kh' => $mainDate[7]]));
                break;
            case 'E':
                $result .= (int) $mainDate[6];
                break;
            case 'f':
                $result .= implode(' ', persianFormat(['ff' => $solarMonth]));
                break;
            case 'F':
                $result .= implode(' ', persianFormat(['mm' => $solarMonth]));
                break;
            case 'H':
                $result .= $mainDate[0];
                break;
            case 'i':
                $result .= $mainDate[1];
                break;
            case 'j':
                $result .= $solarDay;
                break;
            case 'J':
                $result .= implode(' ', persianFormat(['rr' => $solarDay]));
                break;
            case 'k':
                $result .= 100 - (int) ($pastDays / ($leap + 365.24) * 1000) / 10;
                break;
            case 'K':
                $result .= (int) ($pastDays / ($leap + 365.24) * 1000) / 10;
                break;
            case 'l':
                $result .= implode(' ', persianFormat(['rh' => $mainDate[7]]));
                break;
            case 'L':
                $result .= $leap;
                break;
            case 'm':
                $result .= ($solarMonth > 9) ? $solarMonth:'0' . $solarMonth;
                break;
            case 'M':
                $result .= implode(' ', persianFormat(['km' => $solarMonth]));
                break;
            case 'n':
                $result .= $solarMonth;
                break;
            case 'N':
                $result .= $mainDate[7] + 1;
                break;
            case 'o':
                $result .= ((($mainDate[7] == 6) ? 0:$mainDate[7] + 1) > ($pastDays + 3) && $pastDays < 3) ? $solarYear - 1 : (((3 - (364 + $leap - $pastDays)) > (($mainDate[7] == 6) ? 0:$mainDate[7] + 1) && (364 + $leap - $pastDays) < 3) ? $solarYear + 1 : $solarYear);
                break;
            case 'O':
                $result .= $mainDate[4];
                break;
            case 'p':
                $result .= implode(' ', persianFormat(['mb' => $solarMonth]));
                break;
            case 'P':
                $result .= $mainDate[5];
                break;
            case 'q':
                $result .= implode(' ', persianFormat(['sh' => $solarYear]));
                break;
            case 'Q':
                $result .= $leap + 364 - $pastDays;
                break;
            case 'r':
                $array = persianFormat(['rh' => $mainDate[7], 'mm' => $solarMonth]);
                $result .= "$mainDate[0]:$mainDate[1]:$mainDate[6] $mainDate[4] {$array['rh']}, $solarDay {$array['mm']} $solarYear";
                break;
            case 'R':
                $result .= (int) $mainDate[1];
            case 's':
                $result .= $mainDate[6];
                break;
            case 'S':
                $result .= 'م';
                break;
            case 't':
                $result .= ($solarMonth != 12) ? (31 - (int) ($solarMonth / 6.5)) : ($leap + 29);
                break;
            case 'U':
                $result .= $timestamp;
                break;
            case 'v':
                $result .= implode(' ', persianFormat(['ss' => ($solarYear % 100)]));
                break;
            case 'V':
                $result .= implode(' ', persianFormat(['ss' => $solarYear]));
                break;
            case 'w':
                $result .= ($mainDate[7] == 6) ? 0:$mainDate[7] + 1;
                break;
            case 'W':
                $week = (($mainDate[7] == 6) ? 0:$mainDate[7] + 1) - ($pastDays % 7);
                if($week < 0)
                    $week += 7;
                $num = (int) (($pastDays + $week) / 7);
                if($week < 4)
                    $num++;
                elseif($num < 1)
                    $num = ($week == 4 || $week == ((((($solarYear % 33) % 4) - 2) == ((int) (($solarYear % 33) * 0.05))) ? 5:4)) ? 53:52;
                $hotkey = (($week + $leap) == 7 ? 0:($week + $leap));
                $result .= (($leap + 363 - $pastDays) < $hotkey && $hotkey < 3) ? '01':(($num < 10) ? '0' . $num:$num);
                break;
            case 'x':
            case 'X':
                $result .= '@PWRdev';
                break;
            case 'y':
                $result .= substr($solarYear, 2, 2);
                break;
            case 'Y':
                $result .= $solarYear;
                break;
            case 'z':
                $result .= $pastDays;
                break;
            default:
                $result .= $key;
        }
    }
    return $result;
}
function greToSolar($greYear, $greMonth, $greDay){
    $daysCount = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    $yearFilter = ($greMonth > 2) ? ($greYear + 1):$greYear;
    $days = 355666 + (365 * $greYear) + ((int) (($yearFilter + 3) / 4)) - ((int) (($yearFilter + 99) / 100)) + ((int) (($yearFilter + 399) / 400)) + $greDay + $daysCount[$greMonth - 1];
    $solarYear = -1595 + (33 * ((int) ($days / 12053)));
    $days %= 12053;
    $solarYear += 4 * ((int) ($days / 1461));
    $days %= 1461;
    if($days > 365){
        $solarYear += (int) (($days - 1) / 365);
        $days = ($days - 1) % 365;
    }
    if($days < 186){
        $solarMonth = 1 + (int) ($days / 31);
        $solarDay = 1 + ($days % 31);
    }else{
        $solarMonth = 7 + (int) (($days - 186) / 30);
        $solarDay = 1 + (($days - 186) % 30);
    }
    return [$solarYear, $solarMonth, $solarDay];
}
function persianFormat($array){
    foreach($array as $key => $value){
        switch($key){
            case 'ss':
                $len = strlen($value);
                $hotkey1 = substr($value, 2 - $len, 1);
                $hotkey2 = $hotkey3 = $hotkey4 = '';
                if($hotkey1 == 1){
                    $hotkey5 = '';
                    $hotkey3 = (['ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده'])[substr($value, 2 - $len, 2) - 10];
                }else{
                    $hotkey6 = substr($value, 3 - $len, 1);
                    $hotkey5 = ($hotkey1 == 0 || $hotkey6 == 0) ? '':' و ';
                    $hotkey2 = (['', '', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود'])[$hotkey1];
                    $hotkey4 = (['', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه'])[$hotkey6];
                }
                $array[$key] = (($value > 99) ? str_replace(['12', '13', '14', '19', '20'], ['هزار و دویست', 'هزار و سیصد', 'هزار و چهارصد', 'هزار و نهصد', 'دوهزار'], substr($value, 0, 2)) . ((substr($value, 2, 2) == '00') ? '':' و '):'') . $hotkey2 . $hotkey5 . $hotkey3 . $hotkey4;
                break;
            case 'mm':
                $array[$key] = (['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'])[$value - 1];
                break;
            case 'rr':
                $array[$key] = (['یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه', 'ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده', 'بیست', 'بیست و یک', 'بیست و دو', 'بیست و سه', 'بیست و چهار', 'بیست و پنج', 'بیست و شش', 'بیست و هفت', 'بیست و هشت', 'بیست و نه', 'سی', 'سی و یک'])[$value - 1];
                break;
            case 'rh':
                $array[$key] = (['یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', 'شنبه'])[$value];
                break;
            case 'sh':
                $array[$key] = (['مار', 'اسب', 'گوسفند', 'میمون', 'مرغ', 'سگ', 'خوک', 'موش', 'گاو', 'پلنگ', 'خرگوش', 'نهنگ'])[$value % 12];
                break;
            case 'mb':
                $array[$key] = (['حمل', 'ثور', 'جوزا', 'سرطان', 'اسد', 'سنبله', 'میزان', 'عقرب', 'قوس', 'جدی', 'دلو', 'حوت'])[$value - 1];
                break;
            case 'ff':
                $array[$key] = (['بهار', 'تابستان', 'پاییز', 'زمستان'])[(int) ($value / 3.1)];
                break;
            case 'km':
                $array[$key] = (['فر', 'ار', 'خر', 'تی‍', 'مر', 'شه‍', 'مه‍', 'آب‍', 'آذ', 'دی', 'به‍', 'اس‍'])[$value - 1];
                break;
            case 'kh':
                $array[$key] = (['ی', 'د', 'س', 'چ', 'پ', 'ج', 'ش'])[$value];
                break;
            default:
                $array[$key] = $value;
        }
    }
    return $array;
}
function solarToGre($solarYear, $solarMonth, $solarDay){
    $solarYear += 1595;
    $days = -355668 + (365 * $solarYear) + (((int) ($solarYear / 33)) * 8) + ((int) ((($solarYear % 33) + 3) / 4)) + $solarDay + (($solarMonth < 7) ? ($solarMonth - 1) * 31:(($solarMonth - 7) * 30) + 186);
    $greYear = 400 * ((int) ($days / 146097));
    $days %= 146097;
    if($days > 36524){
        $greYear += 100 * ((int) (--$days / 36524));
        $days %= 36524;
        if($days >= 365)
            $days++;
    }
    $greYear += 4 * ((int) ($days / 1461));
    $days %= 1461;
    if($days > 365){
        $greYear += (int) (($days - 1) / 365);
        $days = ($days - 1) % 365;
    }
    $greDay = $days + 1;
    $array = ([0, 31, (($greYear % 4 == 0 && $greYear % 100 != 0) || ($greYear % 400 == 0)) ? 29:28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]);
    for($greMonth = 0; $greMonth < 13 && $greDay > $array[$greMonth]; $greMonth++)
        $greDay -= $array[$greMonth];
    return [$greYear, $greMonth, $greDay];
}
function sStrftime($format, $timestamp = null){
    if(is_null($timestamp) || empty($timestamp))
        $timestamp = time();
    $mainDate = explode('_', date('h_H_i_j_n_s_w_Y', $timestamp));
    [$solarYear, $solarMonth, $solarDay] = greToSolar($mainDate[7], $mainDate[4], $mainDate[3]);
    $pastDays = ($solarMonth < 7) ? (($solarMonth - 1) * 31) + $solarDay - 1 : (($solarMonth - 7) * 30) + $solarDay + 185;
    $leap = (((($solarYear + 12) % 33) % 4) == 1) ? 1:0;
    $len = strlen($format);
    $result = '';
    for($i = 0; $i < $len; $i++){
        $key = substr($format, $i, 1);
        if($key == '%')
            $key = substr($format, ++$i, 1);
        else{
            $result .= $sub;
            continue;
        }
        switch($key){
            case 'a':
                $result .= implode(' ', persianFormat(['kh' => $date[6]]));
                break;
            case 'A':
                $result .= implode(' ', persianFormat(['rh' => $date[6]]));
                break;
            case 'd':
                $result .= ($solarDay < 10) ? '0' . $solarDay:$solarDay;
                break;
            case 'e':
                $result .= ($solarDay < 10) ? ' ' . $solarDay:$solarDay;
                break;
            case 'j':
                $result .= str_pad($pastDays + 1, 3, 0, STR_PAD_LEFT);
                break;
            case 'u':
                $result .= $date[6] + 1;
                break;
            case 'w':
                $result .= ($date[6] == 6) ? 0:$date[6] + 1;
                break;
            case 'U':
                $week = (($date[6] < 5) ? $date[6] + 2:$date[6] - 5) - ($pastDays % 7);
                if($week < 0)
                    $week += 7;
                $num = (int) (($pastDays + $week) / 7) + 1;
                if($week > 3 || $week == 1)
                    $num--;
                $result .= ($num < 10) ? '0' . $num:$num;
                break;
            case 'V':
                $week = (($date[6] == 6) ? 0:$date[6] + 1) - ($pastDays % 7);
                if($week < 0)
                    $week += 7;
                $num = (int) (($pastDays + $week) / 7);
                if($week < 4)
                    $num++;
                elseif($num < 1)
                    $num = ($week == 4 || $week == ((((($solarYear % 33) % 4) - 2) == ((int) (($solarYear % 33) * 0.05))) ? 5:4)) ? 53:52;
                $hotkey = (($hotkey = $week + $leap) == 7 ? 0:$hotkey);
                $result .= (($leap + 363 - $pastDays) < $hotkey && $hotkey < 3) ? '01':(($num < 10) ? '0' . $num:$num);
                break;
            case 'W':
                $week = (($date[6] == 6) ? 0:$date[6] + 1) - ($pastDays % 7);
                if($week < 0)
                    $week += 7;
                $num = (int) (($pastDays + $week) / 7) + 1;
                if($week > 3)
                    $num--;
                $result .= ($num < 10) ? '0' . $num:$num;
                break;
            case 'b':
            case 'h':
                $result .= implode(' ', persianFormat(['km' => $solarMonth]));
                break;
            case 'B':
                $result .= implode(' ', persianFormat(['mm' => $solarMonth]));
                break;
            case 'm':
                $result .= ($solarMonth > 9) ? $solarMonth:'0' . $solarMonth;
                break;
            case 'C':
                $hotkey = (int) ($solarYear / 100);
                $result .= ($hotkey > 9) ? $hotkey:'0' . $hotkey;
                break;
            case 'g':
                $hotkey = ($date[6] == 6) ? 0:$date[6] + 1;
                $hotkey2 = 364 + $leap - $pastDays;
                $result .= substr(($hotkey > ($pastDays + 3) && $pastDays < 3) ? $solarYear - 1:(((3 - $hotkey2) > $hotkey && $hotkey2 < 3) ? $solarYear + 1:$solarYear), 2, 2);
                break;
            case 'G':
                $hotkey = ($date[6] == 6) ? 0:$date[6] + 1;
                $hotkey2 = 364 + $leap - $pastDays;
                $result .= ($hotkey > ($pastDays + 3) && $pastDays < 3) ? $solarYear - 1:(((3 - $hotkey2) > $hotkey && $hotkey2 < 3) ? $solarYear + 1:$solarYear);
                break;
            case 'y':
                $result .= substr($solarYear, 2, 2);
                break;
            case 'Y':
                $result .= $solarYear;
                break;
            case 'H':
                $result .= $date[1];
                break;
            case 'I':
                $result .= $date[0];
                break;
            case 'l':
                $result .= ($date[0] > 9) ? $date[0]:' ' . (int) $date[0];
                break;
            case 'M':
                $result .= $date[2];
                break;
            case 'p':
                $result .= ($date[1] < 12) ? 'قبل از ظهر':'بعد از ظهر';
                break;
            case 'P':
                $result .= ($date[1] < 12) ? 'ق.ظ':'ب.ظ';
                break;
            case 'r':
                $result .= "$date[0]:$date[2]:$date[5] " . (($date[1] < 12) ? 'قبل از ظهر':'بعد از ظهر');
                break;
            case 'R':
                $result .= "$date[1]:$date[2]";
                break;
            case 'S':
                $result .= $date[5];
                break;
            case 'T':
                $result .= "$date[1]:$date[2]:$date[5]";
                break;
            case 'X':
                $result .= "$date[0]:$date[2]:$date[5]";
                break;
            case 'z':
                $result .= date('O', $timestamp);
                break;
            case 'Z':
                $result .= date('T', $timestamp);
                break;
            case 'c':
                $key = persianFormat(['rh' => $date[6], 'mm' => $solarMonth]);
                $result .= "$date[1]:$date[2]:$date[5] " . date('P', $timestamp) . " {$key['rh']}، $solarDay {$key['mm']} $solarYear";
                break;
            case 'D':
                $result .= substr($solarYear, 2, 2) . '/' . (($solarMonth > 9) ? $solarMonth:'0' . $solarMonth) . '/' . (($solarDay < 10) ? '0' . $solarDay:$solarDay);
                break;
            case 'F':
                $result .= "{$solarYear}-" . (($solarMonth > 9) ? $solarMonth:'0' . $solarMonth) . '-' . (($solarDay < 10) ? '0' . $solarDay:$solarDay);
                break;
            case 's':
                $result .= $timestamp;
                break;
            case 'x':
                $result .= substr($solarYear, 2, 2) . '/' . (($solarMonth > 9) ? $solarMonth:'0' . $solarMonth) . '/' . (($solarDay < 10) ? '0' . $solarDay:$solarDay);
                break;
            case 'n':
                $result .= "\n";
                break;
            case 't':
                $result .= "\t";
                break;
            case '%':
                $result .= '%';
                break;
            default:
                $result .= $sub;
        }
    }
    return $result;
}
function sMktime($hour, $minute = null, $second = null, $month = null, $day = null, $year = null){
    $sdate = explode('_', sdate('Y_j'));
    if(is_null($month) || empty($month))
        return mktime($hour, $minute, $second);
    elseif(is_null($day) || empty($day))
        return mktime($hour, $minute, $second, solarToGre($sdate[0], $month, $sdate[1])[1]);
    elseif(is_null($year) || empty($year)){
        [$greYear, $greMonth, $greDay] = solarToGre($sdate[0], $month, $day);
        return mktime($hour, $minute, $second, $greMonth, $greDay);
    }else{
        [$greYear, $greMonth, $greDay] = solarToGre($year, $month, $day);
        return mktime($hour, $minute, $second, $greMonth, $greDay, $greYear);
    }
}
function sGetdate($timestamp = null){
    if(is_null($timestamp) || empty($timestamp))
        $timestamp = time();
    $sdate = explode('_', sdate('F_G_i_j_l_n_s_w_Y_z', $timestamp));
    return [
        'seconds' => $sdate[6],
        'minutes' => $sdate[2],
        'hours' => $sdate[1],
        'mday' => $sdate[3],
        'wday' => $sdate[7],
        'mon' => $sdate[5],
        'year' => $sdate[8],
        'yday' => $sdate[9],
        'weekday' => $sdate[4],
        'month' => $sdate[0],
        0 => $timestamp
    ];
}
function sLocaltime($timestamp = null, $associative = false){
    if(is_null($timestamp) || empty($timestamp))
        $timestamp = time();
    $sdate = explode('_', sdate('G_i_j_n_s_w_Y_z', $timestamp));
    $array = [
        'tm_sec' => $sdate[4],
        'tm_min' => $sdate[1],
        'tm_hour' => $sdate[0],
        'tm_mday' => $sdate[2],
        'tm_mon' => $sdate[3],
        'tm_year' => $sdate[6],
        'tm_wday' => $sdate[5],
        'tm_yday' => $sdate[7],
        'tm_isdst' => -1
    ];
    if(!$associative)
        return array_values($array);
    return $array;
}
function sGmStrFTime($format, $timestamp = null){
    date_default_timezone_set('GMT');
    return sStrftime($format, $timestamp);
}
function sGmmktime($hour, $minute = null, $second = null, $month = null, $day = null, $year = null){
    date_default_timezone_set('GMT');
    return sMktime($hour, $minute, $second, $month, $day, $year);
}
function sGmdate($format, $timestamp = null){
    date_default_timezone_set('GMT');
    return sDate($format, $timestamp);
}
function sIdate($format, $timestamp = null){
    if(strlen($format) != 1)
        return false;
    if(is_null($timestamp) || empty($timestamp))
        $timestamp = time();
    $sdate = explode('_', sdate('j_g_G_i_L_m_s_t_N_W_y_Y_Q', $timestamp));
    switch($format){
        case 'B':
        case 'I':
        case 'U':
        case 'Z':
            return idate($format);
        case 'd':
            return $sdate[0];
        case 'h':
            return $sdate[1];
        case 'H':
            return $sdate[2];
        case 'i':
            return $sdate[3];
        case 'L':
            return $sdate[4];
        case 'm':
            return $sdate[5];
        case 's':
            return $sdate[6];
        case 't':
            return $sdate[7];
        case 'w':
            return $sdate[8] - 1;
        case 'W':
            return $sdate[9];
        case 'y':
            return $sdate[10];
        case 'Y':
            return $sdate[11];
        case 'z':
            return $sdate[12];
        default:
            return $format;
    }
}
function sCheckdate($month, $day, $year){
    return ($month > 12 || $day > (($month == 12 && ((($year + 12) % 33) % 4) != 1) ? 29:(31 - (int) ($month / 6.5))) || $month < 1 || $day < 1 || $year < 1) ? false:true;
}
?>