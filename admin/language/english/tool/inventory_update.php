<?php
// Heading
$_['heading_title']    = 'Inventory Quantity Update';

// Text
$_['text_success']    = ' inventory records have successfully been updated.<br /> Any records that could not be updated are listed below!';
$_['text_howto']     =  '<p>The file used to update inventory quantity needs to be a comma separated csv text file. The individual fields are not to be enclosed in or use any punctuation.</p><p>For each line there has to be two fields: the identifier ("model"/"sku") for the product and the quantity to update.</p><p>Quantity numbers must be whole integers from 0 to 9999 and must not use spaces or commas in the formating.</p><p>Extra spaces at the start or end of a field will automatically be removed but spaces within text or numbers will not be.</p><h3>Example of what the csv text file should look like:</h3><b>product001 , 1<br />product 3, 10<br />product010,4<br /></b>';
$_['text_id_field']				 =  'Select field to be used to identify products.';

// Entry
$_['entry_file']    = 'Select File :';
$_['entry_model']   = 'Model :';
$_['entry_sku']			= 'SKU :';

// Error
$_['error_id_field'] = 'Need to select a field used to identify the product.';
$_['error_file'] = 'The file is not a csv file or is greater than 100 Kbyte';
$_['error_filedata'] = 'The following lines of data is of incorrect type or format and could not be updated:<br />';
$_['error_permission'] = 'Warning: You do not have permission to modify!';
$_['error_reference'] = ' reference is : ';
$_['error_quantity'] = ' quantity is : ';
$_['error_recordnotfound'] = 'Record Not Found : ';
$_['error_failedvalidation'] = 'Failed Validation : ';
$_['error_fieldcount'] = 'Wrong number of fields : ';

?>