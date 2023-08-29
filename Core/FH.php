<?php

class FH{
    
    public static function stringifyAttrs($attrs){
        $string = '';
        foreach($attrs as $key => $val){
            $string .= ' '.$key.'="'.$val.'"';
        }
        return $string;
    }

    public static function InputBlock($type, $label, $name, $value = '', $inputAttrs = [], $divAttrs = []){
        $divString = self::stringifyAttrs($divAttrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div '.$divString.'>';
        $html .= '<label for="'.$name.'">'.$label.'</label>';
        $html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$value.'" '.$inputString.'>';
        $html .= '</div>';
        return $html;
    }

    public static function SelectBlock($label, $name, $options = [], $selected = '', $inputAttrs = [], $divAttrs = []){
        $divString = self::stringifyAttrs($divAttrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div '.$divString.'>';
        $html .= '<label for="'.$name.'">'.$label.'</label>';
        $html .= '<select id="'.$name.'" name="'.$name.'" '.$inputString.'>';
        foreach($options as $key => $val){
            $selectedAttr = ($key == $selected) ? 'selected' : '';
            $html .= '<option value="'.$val.'" '.$selectedAttr.'>'.$val.'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }

    public static function TextareaBlock($label, $name, $value = '', $inputAttrs = [], $divAttrs = []){
        $divString = self::stringifyAttrs($divAttrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div '.$divString.'>';
        $html .= '<label for="'.$name.'">'.$label.'</label>';
        $html .= '<textarea id="'.$name.'" name="'.$name.'" '.$inputString.'>'.$value.'</textarea>';
        $html .= '</div>';
        return $html;
    }

}
