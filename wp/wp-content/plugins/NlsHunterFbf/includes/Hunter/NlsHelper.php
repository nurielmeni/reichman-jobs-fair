<?php

class NlsHelper
{
    /*
      chr(45): "-"
      chr(123): "{"
      chr(125): "}"
     */

    public static function emptyGuid()
    {
        return chr(123) . "00000000-0000-0000-0000-000000000000" . chr(125);
    }

    public static function isMobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            return true;
        } else {
            return false;
        }
    }

    public static function getExtendedProperty($extendedProperties, $name)
    {
        foreach ($extendedProperties as $extendedProperty) {
            if ($extendedProperty->PropertyName === $name) {
                return $extendedProperty->Value;
            }
        }
    }

    public static function newGuid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((float) microtime() * 10000); /* optional for php 4.2.0 and up. */
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = chr(123)
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);
            return $uuid;
        }
    }

    public static function languageCode()
    {
        $code = get_locale();
        switch ($code) {
            case 'en_US':
                return 1033;
                break;
            case 'he_IL':
                return 1037;
                break;
            default:
                break;
        }
        return 1033;
    }

    public static function xml2array($xml)
    {
        $arr = [];
        foreach ($xml->children() as $r) {
            if (count($r->children()) == 0) {
                $arr[$r->getName()] = strval($r);
            } else {
                $arr[$r->getName()][] = xml2array($r);
            }
        }
        return $arr;
    }

    /*
     * Creates an HTML select form input
     * @name string the name of the name attribute
     * @class string the class of the select attribute
     * @multiple boolian if multiple or not
     * @options array with 'id', 'name' for each option
     */
    public static function htmlSelect($name = "", $class = "", $multiple = false, $options = [], $placeholder = 'בחירה')
    {
        $html = '<select ';

        $html .= strlen($name) > 0 ? 'name="' . $name . '" ' : '';
        $html .= strlen($class) > 0 ? 'class="' . $class . '" ' : '';
        $html .= $multiple ? 'multiple="multiple"' : '';
        $html .= $placeholder ? 'placeholder="' . $placeholder . '" ' : '';

        $html .= '>';
        $html .= "\n";
        if (!$multiple) {
            $html .= '<option value="0">' . __('Select', 'NlsHunterFbf') . '</option>' . "\n";
        }
        foreach ($options as $id => $name) {
            $html .= '<option value="' . $id . '">' . $name . '</option>';
            $html .= "\n";
        }
        $html .= '</select>';
        $html .= "\n";

        return $html;
    }

    public static function addFlash($message, $subject = '', $type = 'info')
    {
        $flash = '<div class="nls-flash-message-wrapper flex">';
        $flash .= '<div class="nls-flash-message ' . $type . '">';
        $flash .= '<div><strong>' . $subject . '</strong> ' . $message . '</div><strong>x</strong>';
        $flash .= '</div></div>';
        return $flash;
    }

    public static function proprtyValue($object, $property, $default = '')
    {
        return gettype($object) !== 'object' || !property_exists($object, $property)
            ? $default
            : $object->$property;
    }

    public static function dateFormat($str, $default = '')
    {
        $time = strtotime($str);
        if (!$time) $default;

        return date('d/m/Y', $time);
    }

    
    /**
     * Retriev s a list value by the Id
     * @list - a list from the directory service
     * @id - the item id
     */
    public static function getValueById($list, $id)
    {
        if (!is_array($list) || !$id) return '';
        foreach ($list as $listItem) {
            if ($listItem['id'] === $id) return $listItem['name'];
        }
        return '';
    }
}
