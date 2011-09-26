<?php 
        echo $this->Form->input($modelName.'.'.$visibleFieldName,array('options' => array('1'=>'Published', '0'=>'Hidden'), 'label' => false, 'selected' => $defaultValue)); 

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
