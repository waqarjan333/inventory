<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="../themes/admin/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="../themes/admin/javascript/jquery/ui/themes/ui-lightness/ui.all.css" />
<?php foreach ($styles as $style) { ?>
<link rel="stylesheet" type="text/css" href="../themes/admin/stylesheet/<?php echo $style; ?>" />
<?php } ?>
<script type="text/javascript" src="../themes/admin/javascript/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.core.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/tab.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="../themes/admin/javascript/<?php echo $script; ?>"></script>
<?php } ?>
</head>
<body class="nobackground">