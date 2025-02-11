<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ExtFormHelper extends AppHelper {

    public $validates = array();
    public $modelClass;
    var $definedFunctions = '';

    function create($model) {
        $object = null;
        if (is_string($model) && strpos($model, '.') !== false) {
            $path = explode('.', $model);
            $model = end($path);
        }

        if (ClassRegistry::isKeySet($model)) {
            $object = & ClassRegistry::getObject($model);
        }

        if (!empty($object)) {
            if (!empty($object->validate)) {
                $this->validates = $object->validate;
            }
        }
        $this->modelClass = $model;
        return $object;
    }

    function defineFieldFunctions($returnString = false) {
        $out = '';
        foreach ($this->validates as $distinctFieldKey => $distinctFieldValue) {
            $out .= $this->defineFieldFunction($distinctFieldKey, $distinctFieldValue);
        }
        if ($returnString)
            return $out;
        else
            echo $out;
    }

    function defineFieldFunction($field, $distinctFieldValue) {
        $out = "";
        $functionDefinition = "\n\t\t\tfunction " . $this->modelClass . Inflector::camelize($field) . "Validator(val){\n\t\t\t\tmsg=\"\";\n";
        foreach ($distinctFieldValue as $customRuleKey => $customRuleValue) {
            foreach ($customRuleValue as $ruleKey => $ruleValue) {
                if ($ruleKey == 'rule') {
                    if (in_array('alphanumeric', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.alphanum(val))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your can\'t input anything other than Alphanumeric values.<br />';\n";
                    }
                    else if (in_array('email', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.email(val))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your input has to be a valid e-mail address.<br />';\n";
                    }
                    else if (in_array('url', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.url(val))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your input has to be a valid url.<br />';\n";
                    }
                    else if (in_array('ip', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.IPAddress(val))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your input has to be a valid IP Address.<br />';\n";
                    }
                    else if (in_array('blank', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.blank(val))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your input has to be empty.<br />';\n";
                    }
                    else if (in_array('equalTo', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.equalTo(val,'{$ruleValue[1]}'))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your input has to be equal to the value {$ruleValue[1]}.<br />';\n";
                    }
                    else if (in_array('phone', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.phone(val))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your input has to be a valid phone number.<br />';\n";
                    }
                    else if (in_array('numeric', $ruleValue)) {
                        if ($out == '')
                            $out .= $functionDefinition;
                        if (!strstr($this->definedFunctions, $functionDefinition))
                            $this->definedFunctions .= $functionDefinition;
                        $out .= "\t\t\t\tif(!Ext.form.VTypes.numeric(val))\n";
                        if (isset($customRuleValue['message']))
                            $out .= "\t\t\t\t\tmsg += '{$customRuleValue['message']}.<br />';\n";
                        else
                            $out .= "\t\t\t\t\tmsg += 'Your input has to be a number.<br />';\n";
                    }
                    /* else if(in_array('extension',$param['value'])){
                      $extensions = '';
                      $value2 = $param['value'][0];

                      while($extension = each()){
                      if($extension != $param['value'][0]['value'][0])
                      $extensions .= ',';
                      echo $extension[0];
                      $extensions .= $extension;
                      }
                      echo "\t\tif(!Ext.form.VTypes.extension(val,{$extensions}))\n";
                      if(isset($value['message']))
                      echo "\t\t\tmsg += '{$value['message']}';\n";
                      else
                      echo "\t\t\tmsg += 'You input does not have the appropriate extension';\n";
                      } */
                }
            }
        }

        if (strstr($this->definedFunctions, $functionDefinition))
            $out .= "\t\t\t\tif(msg == '') \n\t\t\t\t\treturn true; \n\t\t\t\telse \n\t\t\t\t\treturn msg; \n\t\t\t}\n";
        return $out;
    }

    function input($field, $options = array(), $returnString = false) {
        $out = '{';
        $defaultConfigOptions = array();
        if (isset($options['hidden'])) {
            $configOptions = array("xtype" => 'hidden',
                "name" => "data[" . $this->modelClass . "][" . $field . "]",
                "value" => $options['hidden']
            );
            unset($options['hidden']);
        } elseif ((strpos($field, 'id') !== false && ((strpos($field, 'id') == 0) || (strpos($field, '_id') == strlen($field) - 3))) || (isset($options['xtype']) && $options['xtype'] == 'combo')) {
            if (isset($options['hidden'])) {
                $configOptions = array("xtype" => 'hidden',
                    "name" => "data[" . $this->modelClass . "][" . $field . "]",
                    "value" => $options['hidden'],
                    "anchor" => '100%'
                );
                unset($options['hidden']);
            } else {
                $configOptions = array("xtype" => 'combo',
                    "name" => $field,
                    "hiddenName" => "data[" . $this->modelClass . "][" . $field . "]",
                    "fieldLabel" => Inflector::humanize(substr($field, 0, -3)),
                    "typeAhead" => "true",
                    "emptyText" => __('Select One', true),
                    "editable" => 'false',
                    "triggerAction" => 'all',
                    "lazyRender" => "true",
                    "mode" => 'local',
                    "valueField" => 'id',
                    "displayField" => 'name',
                    "allowBlank" => 'false',
                    "anchor" => '100%'
                );
                if (isset($options['xtype']))
                    unset($options['xtype']);
                $out .= "store: new Ext.data.ArrayStore({\nid: 0,\nfields: [\n'id',\n'name'\n],\ndata: [";
                $st = false;
                $items = $options['items'];
                unset($options['items']);

                foreach ($items as $k => $v) {
                    if ($st)
                        $out .= ',';
                    $out .= '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                }
                $out .= "\n]}),\n";
            }
        } else {
            $configOptions = array(
                "xtype" => 'textfield',
                "fieldLabel" => Inflector::humanize($field),
                "name" => 'data[' . $this->modelClass . '][' . $field . ']',
                "anchor" => '100%'
            );
        }
        $validatorConfig = $this->getValidatorsConfigurations($field);
        $configOptions = array_merge($configOptions, $validatorConfig, $options);

        if (isset($configOptions['allowBlank']) && $configOptions['allowBlank'] == 'false' && $configOptions['xtype'] != 'hidden')
            $configOptions['fieldLabel'] = '<span style="color:red;">*</span> ' . $configOptions['fieldLabel'];

        if ($configOptions['xtype'] == 'checkbox' && isset($options['value'])) {
            $configOptions['checked'] = ($options['value']) ? 'true' : 'false';
        }
        $i = 1;
        foreach ($configOptions as $property => $value) {
            $out .= "\t\t\t\t\t" . $property . ": " . ((in_array($value, array('true', 'false', '{iconCls: \'upload-icon\'}')) || (strpos($value, '0') <> 0 && is_numeric($value)) || (is_numeric($value)) || ($property == 'listeners') || ($property == 'buttonCfg') || ($property == 'plugins') || ($property == 'minValue') || ($property == 'maxValue') || ($property == 'validator')) ? $value : "'" . $value . "'");
            if ($i < count($configOptions))
                $out.= ',';
            $out .= "\n";
            $i++;
        }
        if (strstr($this->definedFunctions, $this->modelClass . Inflector::camelize($field))) {
            $out .= ",validator: " . $this->modelClass . Inflector::camelize($field) . "Validator\n}";
        }
        else
            $out .= "\t\t\t\t}";
        if ($returnString)
            return $out;
        else
            echo $out;
    }

    function getValidatorsConfigurations($field) {
        $validatorConfig = array();
        foreach ($this->validates as $distinctFieldKey => $distinctFieldValue) {
            if ($distinctFieldKey != $field)
                continue;
            foreach ($distinctFieldValue as $customRuleKey => $customRuleValue) {
                foreach ($customRuleValue as $ruleKey => $ruleValue) {
                    if ($ruleKey == 'rule') {
                        if (strtolower($ruleValue[0]) == 'between') {
                            $validatorConfig = array_merge($validatorConfig, array("minLength" => "{$ruleValue[1]}", "maxLength" => "{$ruleValue[2]}"));
                        } else if (strtolower($ruleValue[0]) == 'boolean') {
                            $validatorConfig = array_merge($validatorConfig, array("xtype" => "checkbox"));
                        } else if (strtolower($ruleValue[0]) == 'comparison') {
                            $validatorConfig = array_merge($validatorConfig, array("xtype" => "spinnerfield"));
                            if ($ruleValue[1] == '>' || $ruleValue[1] == 'is greater')
                                $validatorConfig = array_merge($validatorConfig, array("minValue" => ($ruleValue[2] + 1)));
                            else if ($ruleValue[1] == '>=' || $ruleValue[1] == 'greater or equal')
                                $validatorConfig = array_merge($validatorConfig, array("minValue" => $ruleValue[2]));
                            else if ($ruleValue[1] == '<' || $ruleValue[1] == 'is less')
                                $validatorConfig = array_merge($validatorConfig, array("maxValue: " => ($ruleValue[2] - 1)));
                            else if ($ruleValue[1] == '<=' || $ruleValue[1] == 'less or equal')
                                $validatorConfig = array_merge($validatorConfig, array("maxValue" => $ruleValue[2]));
                            $validatorConfig = array_merge($validatorConfig, array("accelerate" => "true"));
                        }
                        else if (strtolower($ruleValue[0]) == 'date') {
                            $validatorConfig = array_merge($validatorConfig, array("xtype" => "datefield", "format" => "Y-m-d"));
                        } else if (strtolower($ruleValue[0]) == 'minlength') {
                            $validatorConfig = array_merge($validatorConfig, array("minLength" => $ruleValue[1]));
                        } else if (strtolower($ruleValue[0]) == 'maxlength') {
                            $validatorConfig = array_merge($validatorConfig, array("maxLength" => $ruleValue[1]));
                        } else if (strtolower($ruleValue[0]) == 'notempty') {
                            $validatorConfig = array_merge($validatorConfig, array("allowBlank" => "false", "blankText" => isset($customRuleValue['message']) ? $customRuleValue['message'] : 'Your input is invalid.'));
                        } else if (strtolower($ruleValue[0]) == 'currency') {
                            $validatorConfig = array_merge($validatorConfig, array("vtype" => "Currency", "blankText" => isset($customRuleValue['message']) ? $customRuleValue['message'] : 'Your input is invalid.'));
                        } else if (strtolower($ruleValue[0]) == 'decimal') {
                            $validatorConfig = array_merge($validatorConfig, array("vtype" => "Decimal", "blankText" => isset($customRuleValue['message']) ? $customRuleValue['message'] : 'Your input is invalid.'));
                        }
                        if (strtolower($ruleValue[0]) == 'range') {
                            $validatorConfig = array_merge($validatorConfig, array("xtype" => "spinnerfield", "minValue" => ($ruleValue[1] + 1),
                                "maxValue" => ($ruleValue[2] - 1), "value" => ($ruleValue[1] + 1), "accelerate" => "true",
                                "allowDecimals" => "true", "incrementValue" => "1"));
                        }
                    }
                    if ($ruleKey == 'allowEmpty' && $ruleValue == false) {
                        $validatorConfig = array_merge($validatorConfig, array("allowBlank" => "false", "blankText" => 'Value cannot be left blank'));
                    }
                }
            }
        }
        return $validatorConfig;
    }

}

?>
