<?php echo $header?>

<div>
<?php foreach ($faqs  as $faq) {?>
<p>
	<strong><?php echo $faq['faq_question']?></strong><br/>
	<?php echo html_entity_decode($faq['faq_description'])?>
</p>
<br/>
<?php }?>
</div>

<?php echo $right?>
<?php echo $footer?>