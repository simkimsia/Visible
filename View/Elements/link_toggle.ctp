<?php 
	$modelUC = ucwords($modelName);
	
	if (1 == $modelName[$modelUC][$visibleFieldName]) {
	    $status = __('Published');
	} else {
	    $status = __('Hidden');    
	}        
?>	
		  
<?php echo $this->Html->link($status,
	array('action' => 'toggle', $modelID),
	//array('class' => 'product-status')
	); 
?>
