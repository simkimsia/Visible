<?php 

	$options = array(1=> 'Published', 0=>'Hidden');
	
    echo $this->Form->input($modelName.'.'.$visibleFieldName,
		array(
			'options' => $options, 
			'label' => false, 
			'selected' => intval($defaultValue), 
			'autocomplete' => 'off'
		)
	); 

    $modelUC = ucwords($modelName);
    $fieldUC = ucwords($visibleFieldName);


    echo $this->Ajax->observeField( $modelUC.$fieldUC, 
	array(
	    'url' => array( 'action' => 'toggle',
			   'controller' => $controller,
			   'admin' => true,
			   $modelID),
	    //'complete' => 'alert(request.responseText)'
	) 
    ); 
?>
