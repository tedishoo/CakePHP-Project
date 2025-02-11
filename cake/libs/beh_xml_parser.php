<?php

class BehXmlParser {
    
    function setStartingValues() {
        global $obj;
        
        $obj->tree = '$obj->xml';
        $obj->xml = '';
    }
    
    function getXmlObject() {
        global $obj;
        
        return $obj->xml;
    }
    
    function startElement($parser, $name, $attrs) {
        global $obj;

        // If var already defined, make array
        eval('$test=isset(' . $obj->tree . '->' . $name . ');');
        if ($test) {
            eval('$tmp=' . $obj->tree . '->' . $name . ';');
            eval('$arr=is_array(' . $obj->tree . '->' . $name . ');');
            if (!$arr) {
                eval('unset(' . $obj->tree . '->' . $name . ');');
                eval($obj->tree . '->' . $name . '[0]=$tmp;');
                $cnt = 1;
            } else {
                eval('$cnt=count(' . $obj->tree . '->' . $name . ');');
            }

            $obj->tree .= '->' . $name . "[$cnt]";
        } else {
            $obj->tree .= '->' . $name;
        }
        if (count($attrs)) {
            eval($obj->tree . '->attr=$attrs;');
        }
    }
    
    function endElement($parser, $name) {
        global $obj;
        // Strip off last ->
        for ($a = strlen($obj->tree); $a > 0; $a--) {
            if (substr($obj->tree, $a, 2) == '->') {
                $obj->tree = substr($obj->tree, 0, $a);
                break;
            }
        }
    }
    
    function characterData($parser, $data) {
        global $obj;

        eval($obj->tree . '->data=\'' . $data . '\';');
    }
}

?>
