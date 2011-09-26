<?php 
	if (1 == $product['Product']['visible']) {
	    $status = __('Published');
	} else {
	    $status = __('Hidden');    
	}        
?>	
		  
<?php echo $this->Html->link($status,
	array('action' => 'toggle', $product['Product']['id']),
	array('class' => 'product-status')); 
?>
