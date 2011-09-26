<?php
/**
 * Visible Behavior
 *
 * This behavior is meant for any attribute that is binary in value
 * basically 0 and 1
 * and we want it to be easily changed via toggling
 * 
 * 
 * 
 * @author Sim Kim Sia (aka keisimone in github.com, Zeu5 in #cakephp irc channel, kimcity@gmail.com)
 * @package app
 * @subpackage app.models.behaviors
 * @filesource http://github.com/...
 * @version 0.1
 * @lastmodified 2011-04-16
 */

class VisibleBehavior extends ModelBehavior {
/**
 * The default options for the behavior
 */
	var $defaultOptions = array(
                'default' => 1,
                'constantNameFor1' => 'VISIBLE_RECORD',
                'constantNameFor0' => 'HIDDEN_RECORD',
	);

	

/**
 * The array that saves the $options for the behavior
 */
	var $__fields = array();

/**
 * Setup the behavior. It stores a reference to the model, merges the default options with the options for each field, and setup the validation rules.
 *
 * @param $model Object
 * @param $settings Array[optional]
 * @return null
 * @author Sim Kim Sia
 */
	function setup($model, $settings = array()) {
		$this->__fields[$model->alias] = array();
		foreach ($settings as $field => $options) {
			// Check if they even PASSED IN parameters
			if (!is_array($options)) {
				// You jerks!
				$field = $options;
				$options = array();
			}

			// Merge given options with defaults
			$options = $this->_arrayMerge($this->defaultOptions, $options);

			// Check if given field exists
			if (!$model->hasField($field)) {
				trigger_error(sprintf(__d('visible', 'VisibleBehavior Error: The field "%s" doesn\'t exists in the model "%s".'), $field, $model->alias), E_USER_WARNING);
			}

			
			$this->__fields[$model->alias][$field] = $options;
		}
	}


/**
 * Performs a toggle on the field
 *
 * @param $model Object
 * @param $id The primary key of the record
 * @param $fieldName The fieldname that we are going to toggle
 * @return boolean Whether the update is successful. Even if no fields are changed, true is returned
 * @author Sim Kim Sia
 **/

        function toggle($model, $id = false, $fieldName = 'visible') {
		if (!$id) {
			if (!$model->id) {
				return false;
			}
			$id = $model->id;
		}
                
                // this should give something like Product.visible 
                $fieldToChange  = $model->alias . '.' . $fieldName;
                // this should give something like !Product.visible
                $newValue       = '!'.$fieldToChange;
                // this should give something like Product.id
                $identifier       = $model->alias . '.id';
                
		return $model->updateAll(
			// fields to change
                        // this should give array('Product.visible' => '!Product.visible')
			 array($fieldToChange => $newValue),
			 // conditions
                         // this should like array('Product.id' => $id)
			 array($identifier => $id)
		);
	}
        
        
        
/**
 * Performs a toggle on the field
 *
 * @param $model Object
 * @param $id The primary key of the record
 * @param $fieldName The fieldname that we are going to toggle
 * @return boolean Whether the update is successful. Even if no fields are changed, true is returned
 * @author Sim Kim Sia
 **/

        function toggleByConditions($model, $conditions = array(), $fieldName = 'visible') {
		if (empty($conditions)) {
			$conditions = array($model->alias . '.id' => $this->id);
		}
                
                // this should give something like Product.visible 
                $fieldToChange  = $model->alias . '.' . $fieldName;
                // this should give something like !Product.visible
                $newValue       = '!'.$fieldToChange;
                
                
		return $model->updateAll(
			// fields to change
                        // this should give array('Product.visible' => '!Product.visible')
			 array($fieldToChange => $newValue),
			 // conditions
                         // this should like array('Product.id' => $id)
			 $conditions
		);
	}

        
        
/**
 * Merges two arrays recursively
 * primeminister / 2009-11-13 : Added fix for numeric arrays like allowedMime and allowedExt.
 * These values will remain intact even if the passed options were shorter.
 * Solved that with array_splice to keep intact the previous indexes (already merged)
 *
 * @param $arr Array
 * @param $ins Array
 * @return array
 * @author Vinicius Mendes
 */
	function _arrayMerge($arr, $ins) {
		if (is_array($arr)) {
			if (is_array($ins)) {
				foreach ($ins as $k => $v) {
					if (isset($arr[$k]) && is_array($v) && is_array($arr[$k])) {
						$arr[$k] = $this->_arrayMerge($arr[$k], $v);
					} elseif (is_numeric($k)) {
						array_splice($arr, $k, count($arr));
						$arr[$k] = $v;
					} else {
						$arr[$k] = $v;
					}
				}
			}
		} elseif (!is_array($arr) && (strlen($arr) == 0 || $arr == 0)) {
			$arr = $ins;
		}
		return $arr;
	}
}
?>