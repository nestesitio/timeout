<?php
class SNP_NHP_Options_sendpress_lists extends SNP_NHP_Options
{
	function __construct($field = array(), $value ='', $parent)
	{

		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		//$this->render();
	}

	function render()
	{

		$class = (isset($this->field['class'])) ? $this->field['class'] : '';

		if (!$this->value)
		{
			$this->value = $this->field['std'];
		}
		$this->field['options']=snp_ml_get_sp_lists();
		$class = (isset($this->field['class'])) ? 'class="' . $this->field['class'] . '" ' : '';
		echo '<select id="' . $this->field['id'] . '" name="' . $this->args['opt_name'] . '[' . $this->field['id'] . ']" ' . $class . 'rows="6" >';
		if($this->field['meta']==1)
		{
		    echo '<option value="" ' . selected($this->value, '', false) . '>Use global settings</option>';
		}
		if(count((array)$this->field['options'])==0)
		{
			echo '<option value="" ' . selected($this->value, '', false) . '>--</option>';
		}
		else
		{
			foreach ($this->field['options'] as $k => $v)
			{
				echo '<option value="' . $k . '" ' . selected($this->value, $k, false) . '>' . $v['name'] . '</option>';
			}//foreach
		}
		echo '</select>';
		if(!$this->field['meta'])
		{
		    echo '<input type="button" rel-id="' . $this->field['id'] . '" class="button sendpress_lists_gl" name="" value="Grab Lists" />';
		}
		echo (isset($this->field['desc']) && !empty($this->field['desc'])) ? ' <span class="description">' . $this->field['desc'] . '</span>' : '';
	}

//function

	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since SNP_NHP_Options 1.0
	 */
	function enqueue()
	{

		wp_enqueue_script(
				'nhp-opts-field-sendpress_lists-js', SNP_NHP_OPTIONS_URL . 'fields/sendpress_lists/field_sendpress_lists.js', array('jquery'), time(), true
		);
	}

//function
}

//class
?>