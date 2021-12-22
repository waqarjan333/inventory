<?php

static $config = NULL;
static $log = NULL;

// Error Handler
function error_handler_for_export($errno, $errstr, $errfile, $errline) {
	global $config;
	global $log;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$errors = "Notice";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$errors = "Warning";
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$errors = "Fatal Error";
			break;
		default:
			$errors = "Unknown";
			break;
	}
		
	if (($errors=='Warning') || ($errors=='Unknown')) {
		return true;
	}

	if ($config->get('config_error_display')) {
		echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}


class ModelToolExport extends Model {


	function clean( &$str, $allowBlanks=FALSE ) {
		$result = "";
		$n = strlen( $str );
		for ($m=0; $m<$n; $m++) {
			$ch = substr( $str, $m, 1 );
			if (($ch==" ") && (!$allowBlanks) || ($ch=="\n") || ($ch=="\r") || ($ch=="\t") || ($ch=="\0") || ($ch=="\x0B")) {
				continue;
			}
			$result .= $ch;
		}
		return $result;
	}


	function import( &$database, $sql ) {
		foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);
			if ($sql) {
				$database->query($sql);
			}
		}
	}


	protected function getDefaultLanguageId( &$database ) {
		$code = $this->config->get('config_language');
		$sql = "SELECT language_id FROM `".DB_PREFIX."language` WHERE code = '$code'";
		$result = $database->query( $sql );
		$languageId = 1;
		if ($result->rows) {
			foreach ($result->rows as $row) {
				$languageId = $row['language_id'];
				break;
			}
		}
		return $languageId;
	}


	protected function getDefaultWeightUnit() {
		$weightUnit = $this->config->get( 'config_weight_class' );
		return $weightUnit;
	}


	protected function getDefaultMeasurementUnit() {
		$measurementUnit = $this->config->get( 'config_length_class' );
		return $measurementUnit;
	}



	function siteManufacturersIntoDatabase( &$database, &$products, &$manufacturerIds ) {
		// find all manufacturers already sited in the database
		$sql = "SELECT `manufacturer_id`, `name` FROM `".DB_PREFIX."manufacturer`;";
		$result = $database->query( $sql );
		if ($result->rows) {
			foreach ($result->rows as $row) {
				$manufacturerId = $row['manufacturer_id'];
				$name = $row['name'];
				if (!isset($manufacturerIds[$name])) {
					$manufacturerIds[$name] = $manufacturerId;
				}
			}
		}

		// add newly introduced manufacturers to the database
		$maxManufacturerId=0;
		foreach ($manufacturerIds as $manufacturerId) {
			$maxManufacturerId = max( $maxManufacturerId, $manufacturerId );
		}
		$sql = "INSERT INTO `".DB_PREFIX."manufacturer` (`manufacturer_id`, `name`, `image`, `sort_order`) VALUES "; 
		$k = strlen( $sql );
		$first = TRUE;
		foreach ($products as $product) {
			$manufacturerName = $product[6];
			if ($manufacturerName=="") {
				continue;
			}
			if (!isset($manufacturerIds[$manufacturerName])) {
				$maxManufacturerId += 1;
				$manufacturerId = $maxManufacturerId;
				$manufacturerIds[$manufacturerName] = $manufacturerId;
				$sql .= ($first) ? "\n" : ",\n";
				$first = FALSE;
				$sql .= "($manufacturerId, '$manufacturerName', '', 0)";
			}
		}
		$sql .= ";\n";
		if (strlen( $sql ) > $k+2) {
			$database->query( $sql );
		}
		
		// populate manufacturer_to_site table
		$siteIdsForManufacturers = array();
		foreach ($products as $product) {
			$manufacturerName = $product[6];
			if ($manufacturerName=="") {
				continue;
			}
			$manufacturerId = $manufacturerIds[$manufacturerName];
			$siteIds = $product[33];
			if (!isset($siteIdsForManufacturers[$manufacturerId])) {
				$siteIdsForManufacturers[$manufacturerId] = array();
			}
			foreach ($siteIds as $siteId) {
				if (!in_array($siteId,$siteIdsForManufacturers[$manufacturerId])) {
					$siteIdsForManufacturers[$manufacturerId][] = $siteId;
					$sql2 = "INSERT INTO `".DB_PREFIX."manufacturer_to_site` (`manufacturer_id`,`site_id`) VALUES ($manufacturerId,$siteId);";
					$database->query( $sql2 );
				}
			}
		}
		return TRUE;
	}


	function getWeightClassIds( &$database ) {
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);
		
		// find all weight classes already sited in the database
		$weightClassIds = array();
		$sql = "SELECT `weight_class_id`, `unit` FROM `".DB_PREFIX."weight_class_description` WHERE `language_id`=$languageId;";
		$result = $database->query( $sql );
		if ($result->rows) {
			foreach ($result->rows as $row) {
				$weightClassId = $row['weight_class_id'];
				$unit = $row['unit'];
				if (!isset($weightClassIds[$unit])) {
					$weightClassIds[$unit] = $weightClassId;
				}
			}
		}

		return $weightClassIds;
	}


	function getLengthClassIds( &$database ) {
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);
		
		// find all length classes already sited in the database
		$lengthClassIds = array();
		$sql = "SELECT `length_class_id`, `unit` FROM `".DB_PREFIX."length_class_description` WHERE `language_id`=$languageId;";
		$result = $database->query( $sql );
		if ($result->rows) {
			foreach ($result->rows as $row) {
				$lengthClassId = $row['length_class_id'];
				$unit = $row['unit'];
				if (!isset($lengthClassIds[$unit])) {
					$lengthClassIds[$unit] = $lengthClassId;
				}
			}
		}

		return $lengthClassIds;
	}


	function siteProductsIntoDatabase( &$database, &$products ) 
	{
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);
		
		// start transaction, remove products
		$sql = "START TRANSACTION;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_description` WHERE language_id=$languageId;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_to_category`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_to_site`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."manufacturer_to_site`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."url_alias` WHERE `query` LIKE 'deal_id=%';\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_related`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_tags` WHERE language_id=$languageId;\n";
		$this->import( $database, $sql );
		
		// site or update manufacturers
		$manufacturerIds = array();
		$ok = $this->siteManufacturersIntoDatabase( $database, $products, $manufacturerIds );
		if (!$ok) {
			$database->query( 'ROLLBACK;' );
			return FALSE;
		}
		
		// get weight classes
		$weightClassIds = $this->getWeightClassIds( $database );
		
		// get length classes
		$lengthClassIds = $this->getLengthClassIds( $database );
		
		// generate and execute SQL for storing the products
		foreach ($products as $product) {
			$productId = $product[0];
			$productName = addslashes($product[1]);
			$categories = $product[2];
			$quantity = $product[3];
			$model = addslashes($product[5]);
			$manufacturerName = $product[6];
			$manufacturerId = ($manufacturerName=="") ? 0 : $manufacturerIds[$manufacturerName];
			$imageName = $product[7];
			$shipping = $product[9];
			$shipping = ((strtoupper($shipping)=="YES") || (strtoupper($shipping)=="Y")) ? 1 : 0;
			$price = trim($product[10]);
			$dateAdded = $product[12];
			$dateModified = $product[13];
			$dateAvailable = $product[14];
			$weight = ($product[15]=="") ? 0 : $product[15];
			$unit = $product[16];
			$weightClassId = (isset($weightClassIds[$unit])) ? $weightClassIds[$unit] : 0;
			$status = $product[17];
			$status = ((strtoupper($status)=="TRUE") || (strtoupper($status)=="YES") || (strtoupper($status)=="ENABLED")) ? 1 : 0;
			$taxClassId = $product[20];
			$viewed = $product[21];
			$productDescription = addslashes($product[23]);
			$stockStatusId = $product[24];
			$meta = addslashes($product[25]);
			$length = $product[26];
			$width = $product[27];
			$height = $product[28];
			$keyword = addslashes($product[29]);
			$lengthUnit = $product[30];
			$lengthClassId = (isset($lengthClassIds[$lengthUnit])) ? $lengthClassIds[$lengthUnit] : 0;
			$sku = $product[31];
			$location = $product[32];
			$siteIds = $product[33];
			$related = $product[34];
			$tags = $product[35];
			$sql  = "INSERT INTO `".DB_PREFIX."product` (`deal_id`,`quantity`,`sku`,`location`,";
			$sql .= "`stock_status_id`,`model`,`manufacturer_id`,`image`,`shipping`,`price`,`date_added`,`date_modified`,`date_available`,`weight`,`weight_class_id`,`status`,";
			$sql .= "`tax_class_id`,`viewed`,`length`,`width`,`height`,`length_class_id`) VALUES ";
			$sql .= "($productId,$quantity,'$sku','$location',";
			$sql .= "$stockStatusId,'$model',$manufacturerId,'$imageName',$shipping,$price,";
			$sql .= ($dateAdded=='NOW()') ? "$dateAdded," : "'$dateAdded',";
			$sql .= ($dateModified=='NOW()') ? "$dateModified," : "'$dateModified',";
			$sql .= ($dateAvailable=='NOW()') ? "$dateAvailable," : "'$dateAvailable',";
			$sql .= "$weight,$weightClassId,$status,";
			$sql .= "$taxClassId,$viewed,$length,$width,$height,'$lengthClassId');";
			$sql2 = "INSERT INTO `".DB_PREFIX."product_description` (`deal_id`,`language_id`,`name`,`description`,`meta_description`) VALUES ";
			$sql2 .= "($productId,$languageId,'$productName','$productDescription','$meta');";
			$database->query($sql);
			$database->query($sql2);
			if (count($categories) > 0) {
				$sql = "INSERT INTO `".DB_PREFIX."product_to_category` (`deal_id`,`category_id`) VALUES ";
				$first = TRUE;
				foreach ($categories as $categoryId) {
					$sql .= ($first) ? "\n" : ",\n";
					$first = FALSE;
					$sql .= "($productId,$categoryId)";
				}
				$sql .= ";";
				$database->query($sql);
			}
			if ($keyword) {
				$sql4 = "INSERT INTO `".DB_PREFIX."url_alias` (`query`,`keyword`) VALUES ('deal_id=$productId','$keyword');";
				$database->query($sql4);
			}
			foreach ($siteIds as $siteId) {
				$sql6 = "INSERT INTO `".DB_PREFIX."product_to_site` (`deal_id`,`site_id`) VALUES ($productId,$siteId);";
				$database->query($sql6);
			}
			if (count($related) > 0) {
				$sql = "INSERT INTO `".DB_PREFIX."product_related` (`deal_id`,`related_id`) VALUES ";
				$first = TRUE;
				foreach ($related as $relatedId) {
					$sql .= ($first) ? "\n" : ",\n";
					$first = FALSE;
					$sql .= "($productId,$relatedId)";
				}
				$sql .= ";";
				$database->query($sql);
			}
			if (count($tags) > 0) {
				$sql = "INSERT INTO `".DB_PREFIX."product_tags` (`deal_id`,`tag`,`language_id`) VALUES ";
				$first = TRUE;
				foreach ($tags as $tag) {
					$sql .= ($first) ? "\n" : ",\n";
					$first = FALSE;
					$sql .= "($productId,'$tag',$languageId)";
				}
				$sql .= ";";
				$database->query($sql);
			}
		}
		
		// final commit
		$database->query("COMMIT;");
		return TRUE;
	}


	protected function detect_encoding( $str ) {
		// auto detect the character encoding of a string
		return mb_detect_encoding( $str, 'UTF-8,ISO-8859-15,ISO-8859-1,cp1251,KOI8-R' );
	}


	function uploadProducts( &$reader, &$database ) {
		// find the default language id and default units
		$languageId = $this->getDefaultLanguageId($database);
		$defaultWeightUnit = $this->getDefaultWeightUnit();
		$defaultMeasurementUnit = $this->getDefaultMeasurementUnit();
		$defaultStockStatusId = $this->config->get('config_stock_status_id');
		
		$data = $reader->sheets[1];
		$products = array();
		$product = array();
		$isFirstRow = TRUE;
		foreach ($data['cells'] as $row) {
			if ($isFirstRow) {
				$isFirstRow = FALSE;
				continue;
			}
			$productId = trim(isset($row[1]) ? $row[1] : "");
			if ($productId=="") {
				continue;
			}
			$name = isset($row[2]) ? $row[2] : "";
			$name = htmlentities( $name, ENT_QUOTES, $this->detect_encoding($name) );
			$categories = isset($row[3]) ? $row[3] : "";
			$sku = isset($row[4]) ? $row[4] : "0";
			$location = isset($row[5]) ? $row[5] : "0";
			$quantity = isset($row[6]) ? $row[6] : "0";
			$model = isset($row[7]) ? $row[7] : "   ";
			$manufacturer = isset($row[8]) ? $row[8] : "";
			$imageName = isset($row[9]) ? $row[9] : "";
			$shipping = isset($row[10]) ? $row[10] : "yes";
			$price = isset($row[11]) ? $row[11] : "0.00";
			$dateAdded = (isset($row[12]) && (is_string($row[12])) && (strlen($row[12])>0)) ? $row[12] : "NOW()";
			$dateModified = (isset($row[13]) && (is_string($row[13])) && (strlen($row[13])>0)) ? $row[13] : "NOW()";
			$dateAvailable = (isset($row[14]) && (is_string($row[14])) && (strlen($row[14])>0)) ? $row[14] : "NOW()";
			$weight = isset($row[15]) ? $row[15] : "0";
			$unit = isset($row[16]) ? $row[16] : $defaultWeightUnit;
			$length = isset($row[17]) ? $row[17] : "0";
			$width = isset($row[18]) ? $row[18] : "0";
			$height = isset($row[19]) ? $row[19] : "0";
			$measurementUnit = isset($row[20]) ? $row[20] : $defaultMeasurementUnit;
			$status = isset($row[21]) ? $row[21] : "true";
			$taxClassId = isset($row[22]) ? $row[22] : "0";
			$viewed = isset($row[23]) ? $row[23] : "0";
			$langId = isset($row[24]) ? $row[24] : "1";
			if ($langId!=$languageId) {
				continue;
			}
			$keyword = isset($row[25]) ? $row[25] : "";
			$description = isset($row[26]) ? $row[26] : "";
			$description = htmlentities( $description, ENT_QUOTES, $this->detect_encoding($description) );
			$meta = isset($row[27]) ? $row[27] : "";
			$meta = htmlentities( $meta, ENT_QUOTES, $this->detect_encoding($meta) );
			$additionalImageNames = isset($row[28]) ? $row[28] : "";
			$stockStatusId = isset($row[29]) ? $row[29] : $defaultStockStatusId;
			$siteIds = isset($row[30]) ? $row[30] : "";
			$related = isset($row[31]) ? $row[31] : "";
			$tags = isset($row[32]) ? $row[32] : "";
			$product = array();
			$product[0] = $productId;
			$product[1] = $name;
			$categories = trim( $this->clean($categories, FALSE) );
			$product[2] = ($categories=="") ? array() : explode( ",", $categories );
			if ($product[2]===FALSE) {
				$product[2] = array();
			}
			$product[3] = $quantity;
			$product[5] = $model;
			$product[6] = $manufacturer;
			$product[7] = $imageName;
			$product[9] = $shipping;
			$product[10] = $price;
			$product[12] = $dateAdded;
			$product[13] = $dateModified;
			$product[14] = $dateAvailable;
			$product[15] = $weight;
			$product[16] = $unit;
			$product[17] = $status;
			$product[20] = $taxClassId;
			$product[21] = $viewed;
			$product[22] = $languageId;
			$product[23] = $description;
			$product[24] = $stockStatusId;
			$product[25] = $meta;
			$product[26] = $length;
			$product[27] = $width;
			$product[28] = $height;
			$product[29] = $keyword;
			$product[30] = $measurementUnit;
			$product[31] = $sku;
			$product[32] = $location;
			$siteIds = trim( $this->clean($siteIds, FALSE) );
			$product[33] = ($siteIds=="") ? array() : explode( ",", $siteIds );
			if ($product[33]===FALSE) {
				$product[33] = array();
			}
			$product[34] = ($related=="") ? array() : explode( ",", $related );
			if ($product[34]===FALSE) {
				$product[34] = array();
			}
			$product[35] = ($tags=="") ? array() : explode( ",", $tags );
			if ($product[35]===FALSE) {
				$product[35] = array();
			}
			$products[$productId] = $product;
		}
		return $this->siteProductsIntoDatabase( $database, $products );
	}


	function siteCategoriesIntoDatabase( &$database, &$categories ) 
	{
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);

		// start transaction, remove categories
		$sql = "START TRANSACTION;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."category`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."category_description` WHERE language_id=$languageId;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."category_to_site`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."url_alias` WHERE `query` LIKE 'category_id=%';\n";
		$this->import( $database, $sql );
		
		// generate and execute SQL for inserting the categories
		foreach ($categories as $category) {
			$categoryId = $category[0];
			$imageName = $category[1];
			$parentId = $category[2];
			$sortOrder = $category[3];
			$dateAdded = $category[4];
			$dateModified = $category[5];
			$meta = addslashes($category[9]);
			$keyword = addslashes($category[10]);
			$siteIds = $category[11];
			$sql2 = "INSERT INTO `".DB_PREFIX."category` (`category_id`, `image`, `parent_id`, `sort_order`, `date_added`, `date_modified`) VALUES ";
			$sql2 .= "( $categoryId, '$imageName', $parentId, $sortOrder, ";
			$sql2 .= ($dateAdded=='NOW()') ? "$dateAdded," : "'$dateAdded',";
			$sql2 .= ($dateModified=='NOW()') ? "$dateModified" : "'$dateModified'";
			$sql2 .= " );";
			$database->query( $sql2 );
			$sql3 = "INSERT INTO `".DB_PREFIX."category_description` (`category_id`, `language_id`, `name`, `description`, `meta_description`) VALUES ";
			$languageId = $category[6];
			$name = addslashes($category[7]);
			$description = addslashes($category[8]);
			$sql3 .= "( $categoryId, $languageId, '$name', '$description', '$meta' );";
			$database->query( $sql3 );
			if ($keyword) {
				$sql5 = "INSERT INTO `".DB_PREFIX."url_alias` (`query`,`keyword`) VALUES ('category_id=$categoryId','$keyword');";
				$database->query($sql5);
			}
			foreach ($siteIds as $siteId) {
				$sql6 = "INSERT INTO `".DB_PREFIX."category_to_site` (`category_id`,`site_id`) VALUES ($categoryId,$siteId);";
				$database->query($sql6);
			}
		}
		
		// final commit
		$database->query( "COMMIT;" );
		return TRUE;
	}


	function uploadCategories( &$reader, &$database ) 
	{
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);
		
		$data = $reader->sheets[0];
		$categories = array();
		$isFirstRow = TRUE;
		foreach ($data['cells'] as $row) {
			if ($isFirstRow) {
				$isFirstRow = FALSE;
				continue;
			}
			$categoryId = trim(isset($row[1]) ? $row[1] : "");
			if ($categoryId=="") {
				continue;
			}
			$parentId = isset($row[2]) ? $row[2] : "0";
			$name = isset($row[3]) ? $row[3] : "";
			$name = htmlentities( $name, ENT_QUOTES, $this->detect_encoding($name) );
			$sortOrder = isset($row[4]) ? $row[4] : "0";
			$imageName = trim(isset($row[5]) ? $row[5] : "");
			$dateAdded = (isset($row[6]) && (is_string($row[6])) && (strlen($row[6])>0)) ? $row[6] : "NOW()";
			$dateModified = (isset($row[7]) && (is_string($row[7])) && (strlen($row[7])>0)) ? $row[7] : "NOW()";
			$langId = isset($row[8]) ? $row[8] : "1";
			if ($langId != $languageId) {
				continue;
			}
			$keyword = isset($row[9]) ? $row[9] : "";
			$description = isset($row[10]) ? $row[10] : "";
			$description = htmlentities( $description, ENT_QUOTES, $this->detect_encoding($description) );
			$meta = isset($row[11]) ? $row[11] : "";
			$meta = htmlentities( $meta, ENT_QUOTES, $this->detect_encoding($meta) );
			$siteIds = isset($row[12]) ? $row[12] : "";
			$category = array();
			$category[0] = $categoryId;
			$category[1] = $imageName;
			$category[2] = $parentId;
			$category[3] = $sortOrder;
			$category[4] = $dateAdded;
			$category[5] = $dateModified;
			$category[6] = $languageId;
			$category[7] = $name;
			$category[8] = $description;
			$category[9] = $meta;
			$category[10] = $keyword;
			$siteIds = trim( $this->clean($siteIds, FALSE) );
			$category[11] = ($siteIds=="") ? array() : explode( ",", $siteIds );
			if ($category[11]===FALSE) {
				$category[11] = array();
			}
			$categories[$categoryId] = $category;
		}
		return $this->siteCategoriesIntoDatabase( $database, $categories );
	}


	function siteOptionNamesIntoDatabase( &$database, &$options, &$optionIds )
	{
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);

		// add option names, ids, and sort orders to the database
		$maxOptionId = 0;
		$sortOrder = 0;
		$sql = "INSERT INTO `".DB_PREFIX."product_option` (`product_option_id`, `deal_id`, `sort_order`) VALUES "; 
		$sql2 = "INSERT INTO `".DB_PREFIX."product_option_description` (`product_option_id`, `deal_id`, `language_id`, `name`) VALUES ";
		$k = strlen( $sql );
		$first = TRUE;
		foreach ($options as $option) {
			$productId = $option['deal_id'];
			$name = $option['option'];
			$langId = $option['language_id'];
			if ($productId=="") {
				continue;
			}
			if ($langId != $languageId) {
				continue;
			}
			if ($name=="") {
				continue;
			}
			if (!isset($optionIds[$productId][$name])) {
				$maxOptionId += 1;
				$optionId = $maxOptionId;
				if (!isset($optionIds[$productId])) {
					$optionIds[$productId] = array();
					$sortOrder = 0;
				}
				$sortOrder += 1;
				$optionIds[$productId][$name] = $optionId;
				$sql .= ($first) ? "\n" : ",\n";
				$sql2 .= ($first) ? "\n" : ",\n";
				$first = FALSE;
				$sql .= "($optionId, $productId, $sortOrder )";
				$sql2 .= "($optionId, $productId, $languageId, '$name' )";
			}
		}
		$sql .= ";\n";
		$sql2 .= ";\n";
		if (strlen( $sql ) > $k+2) {
			$database->query( $sql );
			$database->query( $sql2 );
		}
		return TRUE;
	}



	function siteOptionDetailsIntoDatabase( &$database, &$options, &$optionIds )
	{
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);

		// generate SQL for storing all the option details into the database
		$sql = "INSERT INTO `".DB_PREFIX."product_option_value` (`product_option_value_id`, `deal_id`, `product_option_id`, `quantity`, `subtract`, `price`, `prefix`, `sort_order`) VALUES "; 
		$sql2 = "INSERT INTO `".DB_PREFIX."product_option_value_description` (`product_option_value_id`, `deal_id`, `language_id`, `name`) VALUES ";
		$k = strlen( $sql );
		$first = TRUE;
		foreach ($options as $index => $option) {
			$productOptionValueId = $index+1;
			$productId = $option['deal_id'];
			$optionName = $option['option'];
			$optionId = $optionIds[$productId][$optionName];
			$optionValue = $option['option_value'];
			$quantity = $option['quantity'];
			$subtract = $option['subtract'];
			$subtract = ((strtoupper($subtract)=="TRUE") || (strtoupper($subtract)=="YES") || (strtoupper($subtract)=="ENABLED")) ? 1 : 0;
			$price = $option['price'];
			$prefix = $option['prefix'];
			$sortOrder = $option['sort_order'];
			$sql .= ($first) ? "\n" : ",\n";
			$sql2 .= ($first) ? "\n" : ",\n";
			$first = FALSE;
			$sql .= "($productOptionValueId, $productId, $optionId, $quantity, $subtract, $price, '$prefix', $sortOrder)";
			$sql2 .= "($productOptionValueId, $productId, $languageId, '$optionValue')";
		}
		$sql .= ";\n";
		$sql2 .= ";\n";
		
		// execute the database query
		if (strlen( $sql ) > $k+2) {
			$database->query( $sql );
			$database->query( $sql2 );
		}
		return TRUE;
	}


	function siteOptionsIntoDatabase( &$database, &$options ) 
	{
		// find the default language id
		$languageId = $this->getDefaultLanguageId($database);
		
		// start transaction, remove options
		$sql = "START TRANSACTION;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_option`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_option_description` WHERE language_id=$languageId;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_option_value`;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_option_value_description` WHERE language_id=$languageId;\n";
		$this->import( $database, $sql );
		
		// site option names
		$optionIds = array(); // indexed by deal_id and name
		$ok = $this->siteOptionNamesIntoDatabase( $database, $options, $optionIds );
		if (!$ok) {
			$database->query( 'ROLLBACK;' );
			return FALSE;
		}
		
		// site option details
		$ok = $this->siteOptionDetailsIntoDatabase( $database, $options, $optionIds );
		if (!$ok) {
			$database->query( 'ROLLBACK;' );
			return FALSE;
		}
		
		$database->query("COMMIT;");
		return TRUE;
	}



	function uploadOptions( &$reader, &$database ) 
	{
		$data = $reader->sheets[2];
		$options = array();
		$i = 0;
		$isFirstRow = TRUE;
		foreach ($data['cells'] as $row) {
			if ($isFirstRow) {
				$isFirstRow = FALSE;
				continue;
			}
			$productId = trim(isset($row[1]) ? $row[1] : "");
			if ($productId=="") {
				continue;
			}
			$languageId = isset($row[2]) ? $row[2] : "";
			$option = isset($row[3]) ? $row[3] : "";
			$optionValue = isset($row[4]) ? $row[4] : "";
			$optionQuantity = isset($row[5]) ? $row[5] : "0";
			$optionSubtract = isset($row[6]) ? $row[6] : "false";
			$optionPrice = isset($row[7]) ? $row[7] : "0";
			$optionPrefix = isset($row[8]) ? $row[8] : "+";
			$sortOrder = isset($row[9]) ? $row[9] : "0";
			$options[$i] = array();
			$options[$i]['deal_id'] = $productId;
			$options[$i]['language_id'] = $languageId;
			$options[$i]['option'] = $option;
			$options[$i]['option_value'] = $optionValue;
			$options[$i]['quantity'] = $optionQuantity;
			$options[$i]['subtract'] = $optionSubtract;
			$options[$i]['price'] = $optionPrice;
			$options[$i]['prefix'] = $optionPrefix;
			$options[$i]['sort_order'] = $sortOrder;
			$i += 1;
		}
		return $this->siteOptionsIntoDatabase( $database, $options );
	}



	function siteSpecialsIntoDatabase( &$database, &$specials )
	{
		$sql = "START TRANSACTION;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_special`;\n";
		$this->import( $database, $sql );

		// find existing siteusers groups from the database
		$sql = "SELECT * FROM `".DB_PREFIX."siteusers_group`";
		$result = $database->query( $sql );
		$maxCustomerGroupId = 0;
		$siteusersGroups = array();
		foreach ($result->rows as $row) {
			$siteusersGroupId = $row['siteusers_group_id'];
			$name = $row['name'];
			if (!isset($siteusersGroups[$name])) {
				$siteusersGroups[$name] = $siteusersGroupId;
			}
			if ($maxCustomerGroupId < $siteusersGroupId) {
				$maxCustomerGroupId = $siteusersGroupId;
			}
		}

		// add additional siteusers groups into the database
		foreach ($specials as $special) {
			$name = $special['siteusers_group'];
			if (!isset($siteusersGroups[$name])) {
				$maxCustomerGroupId += 1;
				$sql  = "INSERT INTO `".DB_PREFIX."siteusers_group` (`siteusers_group_id`, `name`) VALUES "; 
				$sql .= "($maxCustomerGroupId, '$name')";
				$sql .= ";\n";
				$database->query($sql);
				$siteusersGroups[$name] = $maxCustomerGroupId;
			}
		}

		// site product specials into the database
		$productSpecialId = 0;
		$first = TRUE;
		$sql = "INSERT INTO `".DB_PREFIX."product_special` (`product_special_id`,`deal_id`,`siteusers_group_id`,`priority`,`price`,`date_start`,`date_end` ) VALUES "; 
		foreach ($specials as $special) {
			$productSpecialId += 1;
			$productId = $special['deal_id'];
			$name = $special['siteusers_group'];
			$siteusersGroupId = $siteusersGroups[$name];
			$priority = $special['priority'];
			$price = $special['price'];
			$dateStart = $special['date_start'];
			$dateEnd = $special['date_end'];
			$sql .= ($first) ? "\n" : ",\n";
			$first = FALSE;
			$sql .= "($productSpecialId,$productId,$siteusersGroupId,$priority,$price,'$dateStart','$dateEnd')";
		}
		if (!$first) {
			$database->query($sql);
		}

		$database->query("COMMIT;");
		return TRUE;
	}


	function uploadSpecials( &$reader, &$database ) 
	{
		$data = $reader->sheets[3];
		$specials = array();
		$i = 0;
		$isFirstRow = TRUE;
		foreach ($data['cells'] as $row) {
			if ($isFirstRow) {
				$isFirstRow = FALSE;
				continue;
			}
			$productId = trim(isset($row[1]) ? $row[1] : "");
			if ($productId=="") {
				continue;
			}
			$siteusersGroup = trim(isset($row[2]) ? $row[2] : "");
			if ($siteusersGroup=="") {
				continue;
			}
			$priority = isset($row[3]) ? $row[3] : "0";
			$price = isset($row[4]) ? $row[4] : "0";
			$dateStart = isset($row[5]) ? $row[5] : "0000-00-00";
			$dateEnd = isset($row[6]) ? $row[6] : "0000-00-00";
			$specials[$i] = array();
			$specials[$i]['deal_id'] = $productId;
			$specials[$i]['siteusers_group'] = $siteusersGroup;
			$specials[$i]['priority'] = $priority;
			$specials[$i]['price'] = $price;
			$specials[$i]['date_start'] = $dateStart;
			$specials[$i]['date_end'] = $dateEnd;
			$i += 1;
		}
		return $this->siteSpecialsIntoDatabase( $database, $specials );
	}


	function siteDiscountsIntoDatabase( &$database, &$discounts )
	{
		$sql = "START TRANSACTION;\n";
		$sql .= "DELETE FROM `".DB_PREFIX."product_discount`;\n";
		$this->import( $database, $sql );

		// find existing siteusers groups from the database
		$sql = "SELECT * FROM `".DB_PREFIX."siteusers_group`";
		$result = $database->query( $sql );
		$maxCustomerGroupId = 0;
		$siteusersGroups = array();
		foreach ($result->rows as $row) {
			$siteusersGroupId = $row['siteusers_group_id'];
			$name = $row['name'];
			if (!isset($siteusersGroups[$name])) {
				$siteusersGroups[$name] = $siteusersGroupId;
			}
			if ($maxCustomerGroupId < $siteusersGroupId) {
				$maxCustomerGroupId = $siteusersGroupId;
			}
		}

		// add additional siteusers groups into the database
		foreach ($discounts as $discount) {
			$name = $discount['siteusers_group'];
			if (!isset($siteusersGroups[$name])) {
				$maxCustomerGroupId += 1;
				$sql  = "INSERT INTO `".DB_PREFIX."siteusers_group` (`siteusers_group_id`, `name`) VALUES "; 
				$sql .= "($maxCustomerGroupId, '$name')";
				$sql .= ";\n";
				$database->query($sql);
				$siteusersGroups[$name] = $maxCustomerGroupId;
			}
		}

		// site product discounts into the database
		$productDiscountId = 0;
		$first = TRUE;
		$sql = "INSERT INTO `".DB_PREFIX."product_discount` (`product_discount_id`,`deal_id`,`siteusers_group_id`,`quantity`,`priority`,`price`,`date_start`,`date_end` ) VALUES "; 
		foreach ($discounts as $discount) {
			$productDiscountId += 1;
			$productId = $discount['deal_id'];
			$name = $discount['siteusers_group'];
			$siteusersGroupId = $siteusersGroups[$name];
			$quantity = $discount['quantity'];
			$priority = $discount['priority'];
			$price = $discount['price'];
			$dateStart = $discount['date_start'];
			$dateEnd = $discount['date_end'];
			$sql .= ($first) ? "\n" : ",\n";
			$first = FALSE;
			$sql .= "($productDiscountId,$productId,$siteusersGroupId,$quantity,$priority,$price,'$dateStart','$dateEnd')";
		}
		if (!$first) {
			$database->query($sql);
		}

		$database->query("COMMIT;");
		return TRUE;
	}


	function uploadDiscounts( &$reader, &$database ) 
	{
		$data = $reader->sheets[4];
		$discounts = array();
		$i = 0;
		$isFirstRow = TRUE;
		foreach ($data['cells'] as $row) {
			if ($isFirstRow) {
				$isFirstRow = FALSE;
				continue;
			}
			$productId = trim(isset($row[1]) ? $row[1] : "");
			if ($productId=="") {
				continue;
			}
			$siteusersGroup = trim(isset($row[2]) ? $row[2] : "");
			if ($siteusersGroup=="") {
				continue;
			}
			$quantity = isset($row[3]) ? $row[3] : "0";
			$priority = isset($row[4]) ? $row[4] : "0";
			$price = isset($row[5]) ? $row[5] : "0";
			$dateStart = isset($row[6]) ? $row[6] : "0000-00-00";
			$dateEnd = isset($row[7]) ? $row[7] : "0000-00-00";
			$discounts[$i] = array();
			$discounts[$i]['deal_id'] = $productId;
			$discounts[$i]['siteusers_group'] = $siteusersGroup;
			$discounts[$i]['quantity'] = $quantity;
			$discounts[$i]['priority'] = $priority;
			$discounts[$i]['price'] = $price;
			$discounts[$i]['date_start'] = $dateStart;
			$discounts[$i]['date_end'] = $dateEnd;
			$i += 1;
		}
		return $this->siteDiscountsIntoDatabase( $database, $discounts );
	}



	function siteAdditionalImagesIntoDatabase( &$reader, &$database )
	{
		// start transaction
		$sql = "START TRANSACTION;\n";
		
		// delete old additional product images from database
		$sql = "DELETE FROM `".DB_PREFIX."product_image`";
		$database->query( $sql );
		
		// insert new additional product images into database
		$data = $reader->sheets[1];  // Products worksheet
		$isFirstRow = TRUE;
		$maxImageId = 0;
		foreach ($data['cells'] as $row) {
			if ($isFirstRow) {
				$isFirstRow = FALSE;
				continue;
			}
			$productId = trim(isset($row[1]) ? $row[1] : "");
			if ($productId=="") {
				continue;
			}
			$imageNames = trim(isset($row[28]) ? $row[28] : "");
			$imageNames = trim( $this->clean($imageNames, FALSE) );
			$imageNames = ($imageNames=="") ? array() : explode( ",", $imageNames );
			foreach ($imageNames as $imageName) {
				$maxImageId += 1;
				$sql = "INSERT INTO `".DB_PREFIX."product_image` (`product_image_id`, deal_id, `image`) VALUES ";
				$sql .= "($maxImageId,$productId,'$imageName');";
				$database->query( $sql );
			}
		}
		
		$database->query( "COMMIT;" );
		return TRUE;
	}


	function uploadImages( &$reader, &$database )
	{
		$ok = $this->siteAdditionalImagesIntoDatabase( $reader, $database );
		return $ok;
	}


	function validateHeading( &$data, &$expected ) {
		$heading = array();
		foreach ($data['cells'] as $row) {
			for ($i=1; $i<=count($expected); $i+=1) {
				$heading[] = isset($row[$i]) ? $row[$i] : "";
			}
			break;
		}
		$valid = TRUE;
		for ($i=0; $i < count($expected); $i+=1) {
			if (!isset($heading[$i])) {
				$valid = FALSE;
				break;
			}
			if (strtolower($heading[$i]) != strtolower($expected[$i])) {
				$valid = FALSE;
				break;
			}
		}
		return $valid;
	}


	function validateCategories( &$reader )
	{
		$expectedCategoryHeading = array
		( "category_id", "parent_id", "name", "sort_order", "image_name", "date_added", "date_modified", "language_id", "seo_keyword", "description", "meta", "site_ids" );
		$data =& $reader->sheets[0];
		return $this->validateHeading( $data, $expectedCategoryHeading );
	}


	function validateProducts( &$reader )
	{
		$expectedProductHeading = array
		( "deal_id", "name", "categories", "sku", "location", "quantity", "model", "manufacturer", "image_name", "requires\nshipping", "price", "date_added", "date_modified", "date_available", "weight", "unit", "length", "width", "height", "length\nunit", "status\nenabled", /*"special\noffer", "featured",*/ "tax_class_id", "viewed", "language_id", "seo_keyword", "description", "meta", "additional image names", "stock_status_id", "site_ids", "related_ids", "tags" );
		$data = $reader->sheets[1];
		return $this->validateHeading( $data, $expectedProductHeading );
	}


	function validateOptions( &$reader )
	{
		$expectedOptionHeading = array
		( "deal_id", "language_id", "option", "option_value", "quantity", "subtract", "price", "prefix", "sort_order" );
		$data = $reader->sheets[2];
		return $this->validateHeading( $data, $expectedOptionHeading );
	}


	function validateSpecials( &$reader )
	{
		$expectedSpecialsHeading = array
		( "deal_id", "siteusers_group", "priority", "price", "date_start", "date_end" );
		$data = $reader->sheets[3];
		return $this->validateHeading( $data, $expectedSpecialsHeading );
	}


	function validateDiscounts( &$reader )
	{
		$expectedDiscountsHeading = array
		( "deal_id", "siteusers_group", "quantity", "priority", "price", "date_start", "date_end" );
		$data = $reader->sheets[4];
		return $this->validateHeading( $data, $expectedDiscountsHeading );
	}


	function validateUpload( &$reader )
	{
		if (count($reader->sheets) != 5) {
			return FALSE;
		}
		if (!$this->validateCategories( $reader )) {
			return FALSE;
		}
		if (!$this->validateProducts( $reader )) {
			return FALSE;
		}
		if (!$this->validateOptions( $reader )) {
			return FALSE;
		}
		if (!$this->validateSpecials( $reader )) {
			return FALSE;
		}
		if (!$this->validateDiscounts( $reader )) {
			return FALSE;
		}
		return TRUE;
	}


	function clearCache() {
		$this->cache->delete('category');
		$this->cache->delete('category_description');
		$this->cache->delete('manufacturer');
		$this->cache->delete('product');
		$this->cache->delete('product_image');
		$this->cache->delete('product_option');
		$this->cache->delete('product_option_description');
		$this->cache->delete('product_option_value');
		$this->cache->delete('product_option_value_description');
		$this->cache->delete('product_to_category');
		$this->cache->delete('url_alias');
		$this->cache->delete('product_special');
		$this->cache->delete('product_discount');
	}


	function upload( $filename ) {
		global $config;
		global $log;
		$config = $this->config;
		$log = $this->log;
		set_error_handler('error_handler_for_export',E_ALL);
		$database =& $this->db;
		require_once 'Spreadsheet/Excel/Reader.php';
		ini_set("memory_limit","512M");
		ini_set("max_execution_time",180);
		//set_time_limit( 60 );
		$reader=new Spreadsheet_Excel_Reader();
		$reader->setUTFEncoder('iconv');
		$reader->setOutputEncoding('UTF-8');
		$reader->read($filename);
		$ok = $this->validateUpload( $reader );
		if (!$ok) {
			return FALSE;
		}
		$this->clearCache();
		$ok = $this->uploadImages( $reader, $database );
		if (!$ok) {
			return FALSE;
		}
		$ok = $this->uploadCategories( $reader, $database );
		if (!$ok) {
			return FALSE;
		}
		$ok = $this->uploadProducts( $reader, $database );
		if (!$ok) {
			return FALSE;
		}
		$ok = $this->uploadOptions( $reader, $database );
		if (!$ok) {
			return FALSE;
		}
		$ok = $this->uploadSpecials( $reader, $database );
		if (!$ok) {
			return FALSE;
		}
		$ok = $this->uploadDiscounts( $reader, $database );
		if (!$ok) {
			return FALSE;
		}
		return $ok;
	}



	function getsiteIdsForCategories( &$database ) {
		$sql =  "SELECT category_id, site_id FROM `".DB_PREFIX."category_to_site` cs;";
		$siteIds = array();
		$result = $database->query( $sql );
		foreach ($result->rows as $row) {
			$categoryId = $row['category_id'];
			$siteId = $row['site_id'];
			if (!isset($siteIds[$categoryId])) {
				$siteIds[$categoryId] = array();
				if (!in_array($siteId,$siteIds[$categoryId])) {
					$siteIds[$categoryId][] = $siteId;
				}
			}
		}
		return $siteIds;
	}


	function populateCategoriesWorksheet( &$worksheet, &$database, $languageId, &$boxFormat, &$textFormat )
	{
		// Set the column widths
		$j = 0;
		$worksheet->setColumn($j,$j++,strlen('category_id')+1);
		$worksheet->setColumn($j,$j++,strlen('parent_id')+1);
		$worksheet->setColumn($j,$j++,max(strlen('name'),32)+1);
		$worksheet->setColumn($j,$j++,strlen('sort_order')+1);
		$worksheet->setColumn($j,$j++,max(strlen('image_name'),12)+1);
		$worksheet->setColumn($j,$j++,max(strlen('date_added'),19)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_modified'),19)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('language_id'),2)+1);
		$worksheet->setColumn($j,$j++,max(strlen('seo_keyword'),16)+1);
		$worksheet->setColumn($j,$j++,max(strlen('description'),32)+1);
		$worksheet->setColumn($j,$j++,max(strlen('meta'),32)+1);
		$worksheet->setColumn($j,$j++,max(strlen('site_ids'),16)+1);
		
		// The heading row
		$i = 0;
		$j = 0;
		$worksheet->writeString( $i, $j++, 'category_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'parent_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'name', $boxFormat );
		$worksheet->writeString( $i, $j++, 'sort_order', $boxFormat );
		$worksheet->writeString( $i, $j++, 'image_name', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_added', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_modified', $boxFormat );
		$worksheet->writeString( $i, $j++, 'language_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'seo_keyword', $boxFormat );
		$worksheet->writeString( $i, $j++, 'description', $boxFormat );
		$worksheet->writeString( $i, $j++, 'meta', $boxFormat );
		$worksheet->writeString( $i, $j++, 'site_ids', $boxFormat );
		$worksheet->setRow( $i, 30, $boxFormat );
		
		// The actual categories data
		$i += 1;
		$j = 0;
		$siteIds = $this->getsiteIdsForCategories( $database );
		$query  = "SELECT c.* , cd.*, ua.keyword FROM `".DB_PREFIX."category` c ";
		$query .= "INNER JOIN `".DB_PREFIX."category_description` cd ON cd.category_id = c.category_id ";
		$query .= " AND cd.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."url_alias` ua ON ua.query=CONCAT('category_id=',c.category_id) ";
		$query .= "ORDER BY c.`parent_id`, `sort_order`, c.`category_id`;";
		$result = $database->query( $query );
		foreach ($result->rows as $row) {
			$worksheet->write( $i, $j++, $row['category_id'] );
			$worksheet->write( $i, $j++, $row['parent_id'] );
			$worksheet->writeString( $i, $j++, html_entity_decode($row['name'],ENT_QUOTES,'UTF-8') );
			$worksheet->write( $i, $j++, $row['sort_order'] );
			$worksheet->write( $i, $j++, $row['image'] );
			$worksheet->write( $i, $j++, $row['date_added'], $textFormat );
			$worksheet->write( $i, $j++, $row['date_modified'], $textFormat );
			$worksheet->write( $i, $j++, $row['language_id'] );
			$worksheet->writeString( $i, $j++, ($row['keyword']) ? $row['keyword'] : '' );
			$worksheet->writeString( $i, $j++, html_entity_decode($row['description'],ENT_QUOTES,'UTF-8') );
			$worksheet->writeString( $i, $j++, html_entity_decode($row['meta_description'],ENT_QUOTES,'UTF-8') );
			$siteIdList = '';
			$categoryId = $row['category_id'];
			if (isset($siteIds[$categoryId])) {
				foreach ($siteIds[$categoryId] as $siteId) {
					$siteIdList .= ($siteIdList=='') ? $siteId : ','.$siteId;
				}
			}
			$worksheet->write( $i, $j++, $siteIdList, $textFormat );
			$i += 1;
			$j = 0;
		}
	}


	function getsiteIdsForProducts( &$database ) {
		$sql =  "SELECT deal_id, site_id FROM `".DB_PREFIX."product_to_site` ps;";
		$siteIds = array();
		$result = $database->query( $sql );
		foreach ($result->rows as $row) {
			$productId = $row['deal_id'];
			$siteId = $row['site_id'];
			if (!isset($siteIds[$productId])) {
				$siteIds[$productId] = array();
				if (!in_array($siteId,$siteIds[$productId])) {
					$siteIds[$productId][] = $siteId;
				}
			}
		}
		return $siteIds;
	}


	function populateProductsWorksheet( &$worksheet, &$database, &$imageNames, $languageId, &$priceFormat, &$boxFormat, &$weightFormat, &$textFormat )
	{
		// Set the column widths
		$j = 0;
		$worksheet->setColumn($j,$j++,max(strlen('deal_id'),4)+1);
		$worksheet->setColumn($j,$j++,max(strlen('name'),30)+1);
		$worksheet->setColumn($j,$j++,max(strlen('categories'),12)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('sku'),10)+1);
		$worksheet->setColumn($j,$j++,max(strlen('location'),10)+1);
		$worksheet->setColumn($j,$j++,max(strlen('quantity'),4)+1);
		$worksheet->setColumn($j,$j++,max(strlen('model'),8)+1);
		$worksheet->setColumn($j,$j++,max(strlen('manufacturer'),10)+1);
		$worksheet->setColumn($j,$j++,max(strlen('image_name'),12)+1);;
		$worksheet->setColumn($j,$j++,max(strlen('shipping'),5)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('price'),10)+1,$priceFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_added'),19)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_modified'),19)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_available'),10)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('weight'),6)+1,$weightFormat);
		$worksheet->setColumn($j,$j++,max(strlen('unit'),3)+1);
		$worksheet->setColumn($j,$j++,max(strlen('length'),8)+1);
		$worksheet->setColumn($j,$j++,max(strlen('width'),8)+1);
		$worksheet->setColumn($j,$j++,max(strlen('height'),8)+1);
		$worksheet->setColumn($j,$j++,max(strlen('length'),3)+1);
		$worksheet->setColumn($j,$j++,max(strlen('status'),5)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('tax_class_id'),2)+1);
		$worksheet->setColumn($j,$j++,max(strlen('viewed'),5)+1);
		$worksheet->setColumn($j,$j++,max(strlen('language_id'),2)+1);
		$worksheet->setColumn($j,$j++,max(strlen('seo_keyword'),16)+1);
		$worksheet->setColumn($j,$j++,max(strlen('description'),32)+1);
		$worksheet->setColumn($j,$j++,max(strlen('meta'),32)+1);
		$worksheet->setColumn($j,$j++,max(strlen('additional image names'),24)+1);
		$worksheet->setColumn($j,$j++,max(strlen('stock_status_id'),3)+1);
		$worksheet->setColumn($j,$j++,max(strlen('site_ids'),16)+1);
		$worksheet->setColumn($j,$j++,max(strlen('related_ids'),16)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('tags'),32)+1,$textFormat);

		// The product headings row
		$i = 0;
		$j = 0;
		$worksheet->writeString( $i, $j++, 'deal_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'name', $boxFormat );
		$worksheet->writeString( $i, $j++, 'categories', $boxFormat );
		$worksheet->writeString( $i, $j++, 'sku', $boxFormat );
		$worksheet->writeString( $i, $j++, 'location', $boxFormat );
		$worksheet->writeString( $i, $j++, 'quantity', $boxFormat );
		$worksheet->writeString( $i, $j++, 'model', $boxFormat );
		$worksheet->writeString( $i, $j++, 'manufacturer', $boxFormat );
		$worksheet->writeString( $i, $j++, 'image_name', $boxFormat );
		$worksheet->writeString( $i, $j++, "requires\nshipping", $boxFormat );
		$worksheet->writeString( $i, $j++, 'price', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_added', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_modified', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_available', $boxFormat );
		$worksheet->writeString( $i, $j++, 'weight', $boxFormat );
		$worksheet->writeString( $i, $j++, 'unit', $boxFormat );
		$worksheet->writeString( $i, $j++, 'length', $boxFormat );
		$worksheet->writeString( $i, $j++, 'width', $boxFormat );
		$worksheet->writeString( $i, $j++, 'height', $boxFormat );
		$worksheet->writeString( $i, $j++, "length\nunit", $boxFormat );
		$worksheet->writeString( $i, $j++, "status\nenabled", $boxFormat );
		$worksheet->writeString( $i, $j++, 'tax_class_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'viewed', $boxFormat );
		$worksheet->writeString( $i, $j++, 'language_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'seo_keyword', $boxFormat );
		$worksheet->writeString( $i, $j++, 'description', $boxFormat );
		$worksheet->writeString( $i, $j++, 'meta', $boxFormat );
		$worksheet->writeString( $i, $j++, 'additional image names', $boxFormat );
		$worksheet->writeString( $i, $j++, 'stock_status_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'site_ids', $boxFormat );
		$worksheet->writeString( $i, $j++, 'related_ids', $boxFormat );
		$worksheet->writeString( $i, $j++, 'tags', $boxFormat );
		$worksheet->setRow( $i, 30, $boxFormat );
		
		// The actual products data
		$i += 1;
		$j = 0;
		$siteIds = $this->getsiteIdsForProducts( $database );
		$query  = "SELECT ";
		$query .= "  p.deal_id,";
		$query .= "  pd.name,";
		$query .= "  GROUP_CONCAT( DISTINCT CAST(pc.category_id AS CHAR(11)) SEPARATOR \",\" ) AS categories,";
		$query .= "  p.sku,";
		$query .= "  p.location,";
		$query .= "  p.quantity,";
		$query .= "  p.model,";
		$query .= "  m.name AS manufacturer,";
		$query .= "  p.image AS image_name,";
		$query .= "  p.shipping,";
		$query .= "  p.price,";
		$query .= "  p.date_added,";
		$query .= "  p.date_modified,";
		$query .= "  p.date_available,";
		$query .= "  p.weight,";
		$query .= "  wc.unit,";
		$query .= "  p.length,";
		$query .= "  p.width,";
		$query .= "  p.height,";
		$query .= "  p.status,";
		$query .= "  p.tax_class_id,";
		$query .= "  p.viewed,";
		$query .= "  pd.language_id,";
		$query .= "  ua.keyword,";
		$query .= "  pd.description, ";
		$query .= "  pd.meta_description, ";
		$query .= "  p.stock_status_id, ";
		$query .= "  mc.unit AS length_unit, ";
		$query .= "  GROUP_CONCAT( DISTINCT CAST(pr.related_id AS CHAR(11)) SEPARATOR \",\" ) AS related, ";
		$query .= "  GROUP_CONCAT( DISTINCT pt.tag SEPARATOR \",\" ) AS tags ";
		$query .= "FROM `".DB_PREFIX."product` p ";
		$query .= "LEFT JOIN `".DB_PREFIX."product_description` pd ON p.deal_id=pd.deal_id ";
		$query .= "  AND pd.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."product_to_category` pc ON p.deal_id=pc.deal_id ";
		$query .= "LEFT JOIN `".DB_PREFIX."url_alias` ua ON ua.query=CONCAT('deal_id=',p.deal_id) ";
		$query .= "LEFT JOIN `".DB_PREFIX."manufacturer` m ON m.manufacturer_id = p.manufacturer_id ";
		$query .= "LEFT JOIN `".DB_PREFIX."weight_class_description` wc ON wc.weight_class_id = p.weight_class_id ";
		$query .= "  AND wc.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."length_class_description` mc ON mc.length_class_id=p.length_class_id ";
		$query .= "  AND mc.language_id=$languageId ";
		$query .= "LEFT JOIN `".DB_PREFIX."product_related` pr ON pr.deal_id=p.deal_id ";
		$query .= "LEFT JOIN `".DB_PREFIX."product_tags` pt ON pt.deal_id=p.deal_id ";
		$query .= "  AND pt.language_id=$languageId ";
		$query .= "GROUP BY p.deal_id ";
		$query .= "ORDER BY p.deal_id, pc.category_id; ";
		$result = $database->query( $query );
		foreach ($result->rows as $row) {
			$productId = $row['deal_id'];
			$worksheet->write( $i, $j++, $productId );
			$worksheet->writeString( $i, $j++, html_entity_decode($row['name'],ENT_QUOTES,'UTF-8') );
			$worksheet->write( $i, $j++, $row['categories'], $textFormat );
			$worksheet->writeString( $i, $j++, $row['sku'] );
			$worksheet->writeString( $i, $j++, $row['location'] );
			$worksheet->write( $i, $j++, $row['quantity'] );
			$worksheet->writeString( $i, $j++, $row['model'] );
			$worksheet->writeString( $i, $j++, $row['manufacturer'] );
			$worksheet->writeString( $i, $j++, $row['image_name'] );
			$worksheet->write( $i, $j++, ($row['shipping']==0) ? "no" : "yes", $textFormat );
			$worksheet->write( $i, $j++, $row['price'], $priceFormat );
			$worksheet->write( $i, $j++, $row['date_added'], $textFormat );
			$worksheet->write( $i, $j++, $row['date_modified'], $textFormat );
			$worksheet->write( $i, $j++, $row['date_available'], $textFormat );
			$worksheet->write( $i, $j++, $row['weight'], $weightFormat );
			$worksheet->writeString( $i, $j++, $row['unit'] );
			$worksheet->write( $i, $j++, $row['length'] );
			$worksheet->write( $i, $j++, $row['width'] );
			$worksheet->write( $i, $j++, $row['height'] );
			$worksheet->writeString( $i, $j++, $row['length_unit'] );
			$worksheet->write( $i, $j++, ($row['status']==0) ? "false" : "true", $textFormat );
			$worksheet->write( $i, $j++, $row['tax_class_id'] );
			$worksheet->write( $i, $j++, $row['viewed'] );
			$worksheet->write( $i, $j++, $row['language_id'] );
			$worksheet->writeString( $i, $j++, ($row['keyword']) ? $row['keyword'] : '' );
			$worksheet->writeString( $i, $j++, html_entity_decode($row['description'],ENT_QUOTES,'UTF-8') );
			$worksheet->writeString( $i, $j++, html_entity_decode($row['meta_description'],ENT_QUOTES,'UTF-8') );
			$names = "";
			if (isset($imageNames[$productId])) {
				$first = TRUE;
				foreach ($imageNames[$productId] AS $name) {
					if (!$first) {
						$names .= ",\n";
					}
					$first = FALSE;
					$names .= $name;
				}
			}
			$worksheet->writeString( $i, $j++, $names );
			$worksheet->write( $i, $j++, $row['stock_status_id'] );
			$siteIdList = '';
			if (isset($siteIds[$productId])) {
				foreach ($siteIds[$productId] as $siteId) {
					$siteIdList .= ($siteIdList=='') ? $siteId : ','.$siteId;
				}
			}
			$worksheet->write( $i, $j++, $siteIdList, $textFormat );
			$worksheet->write( $i, $j++, $row['related'], $textFormat );
			$worksheet->write( $i, $j++, $row['tags'], $textFormat );
			$i += 1;
			$j = 0;
		}
	}


	function populateOptionsWorksheet( &$worksheet, &$database, $languageId, &$priceFormat, &$boxFormat, $textFormat )
	{
		// Set the column widths
		$j = 0;
		$worksheet->setColumn($j,$j++,max(strlen('deal_id'),4)+1);
		$worksheet->setColumn($j,$j++,max(strlen('language_id'),2)+1);
		$worksheet->setColumn($j,$j++,max(strlen('option'),30)+1);
		$worksheet->setColumn($j,$j++,max(strlen('option_value'),30)+1);
		$worksheet->setColumn($j,$j++,max(strlen('quantity'),4)+1);
		$worksheet->setColumn($j,$j++,max(strlen('subtract'),5)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('price'),10)+1,$priceFormat);
		$worksheet->setColumn($j,$j++,max(strlen('prefix'),5)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('sort_order'),5)+1);
		
		// The options headings row
		$i = 0;
		$j = 0;
		$worksheet->writeString( $i, $j++, 'deal_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'language_id', $boxFormat  );
		$worksheet->writeString( $i, $j++, 'option', $boxFormat  );
		$worksheet->writeString( $i, $j++, 'option_value', $boxFormat  );
		$worksheet->writeString( $i, $j++, 'quantity', $boxFormat  );
		$worksheet->writeString( $i, $j++, 'subtract', $boxFormat  );
		$worksheet->writeString( $i, $j++, 'price', $boxFormat  );
		$worksheet->writeString( $i, $j++, 'prefix', $boxFormat  );
		$worksheet->writeString( $i, $j++, 'sort_order', $boxFormat  );
		$worksheet->setRow( $i, 30, $boxFormat );
		
		// The actual options data
		$i += 1;
		$j = 0;
		$query  = "SELECT DISTINCT p.deal_id, ";
		$query .= "  pod.name AS option_name, ";
		$query .= "  po.sort_order AS option_sort_order, ";
		$query .= "  povd.name AS option_value, ";
		$query .= "  pov.quantity AS option_quantity, ";
		$query .= "  pov.subtract AS option_subtract, ";
		$query .= "  pov.price AS option_price, ";
		$query .= "  pov.prefix AS option_prefix, ";
		$query .= "  pov.sort_order AS sort_order ";
		$query .= "FROM `".DB_PREFIX."product` p ";
		$query .= "INNER JOIN `".DB_PREFIX."product_description` pd ON p.deal_id=pd.deal_id ";
		$query .= "  AND pd.language_id=$languageId ";
		$query .= "INNER JOIN `".DB_PREFIX."product_option` po ON po.deal_id=p.deal_id ";
		$query .= "INNER JOIN `".DB_PREFIX."product_option_description` pod ON pod.product_option_id=po.product_option_id ";
		$query .= "  AND pod.deal_id=po.deal_id ";
		$query .= "  AND pod.language_id=$languageId ";
		$query .= "INNER JOIN `".DB_PREFIX."product_option_value` pov ON pov.product_option_id=po.product_option_id ";
		$query .= "INNER JOIN `".DB_PREFIX."product_option_value_description` povd ON povd.product_option_value_id=pov.product_option_value_id ";
		$query .= "  AND povd.language_id=$languageId ";
		$query .= "ORDER BY deal_id, option_sort_order, sort_order;";
		$result = $database->query( $query );
		foreach ($result->rows as $row) {
			$worksheet->write( $i, $j++, $row['deal_id'] );
			$worksheet->write( $i, $j++, $languageId );
			$worksheet->writeString( $i, $j++, $row['option_name'] );
			$worksheet->writeString( $i, $j++, $row['option_value'] );
			$worksheet->write( $i, $j++, $row['option_quantity'] );
			$worksheet->write( $i, $j++, ($row['option_subtract']==0) ? "false" : "true", $textFormat );
			$worksheet->write( $i, $j++, $row['option_price'], $priceFormat );
			$worksheet->writeString( $i, $j++, $row['option_prefix'], $textFormat );
			$worksheet->write( $i, $j++, $row['sort_order'] );
			$i += 1;
			$j = 0;
		}
	}


	function populateSpecialsWorksheet( &$worksheet, &$database, &$priceFormat, &$boxFormat, &$textFormat )
	{
		// Set the column widths
		$j = 0;
		$worksheet->setColumn($j,$j++,strlen('deal_id')+1);
		$worksheet->setColumn($j,$j++,strlen('siteusers_group')+1);
		$worksheet->setColumn($j,$j++,strlen('priority')+1);
		$worksheet->setColumn($j,$j++,max(strlen('price'),10)+1,$priceFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_start'),19)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_end'),19)+1,$textFormat);
		
		// The heading row
		$i = 0;
		$j = 0;
		$worksheet->writeString( $i, $j++, 'deal_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'siteusers_group', $boxFormat );
		$worksheet->writeString( $i, $j++, 'priority', $boxFormat );
		$worksheet->writeString( $i, $j++, 'price', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_start', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_end', $boxFormat );
		$worksheet->setRow( $i, 30, $boxFormat );
		
		// The actual product specials data
		$i += 1;
		$j = 0;
		$query  = "SELECT ps.*, cg.name FROM `".DB_PREFIX."product_special` ps ";
		$query .= "LEFT JOIN `".DB_PREFIX."siteusers_group` cg ON cg.siteusers_group_id=ps.siteusers_group_id ";
		$query .= "ORDER BY ps.deal_id, cg.name";
		$result = $database->query( $query );
		foreach ($result->rows as $row) {
			$worksheet->write( $i, $j++, $row['deal_id'] );
			$worksheet->write( $i, $j++, $row['name'] );
			$worksheet->write( $i, $j++, $row['priority'] );
			$worksheet->write( $i, $j++, $row['price'], $priceFormat );
			$worksheet->write( $i, $j++, $row['date_start'], $textFormat );
			$worksheet->write( $i, $j++, $row['date_end'], $textFormat );
			$i += 1;
			$j = 0;
		}
	}


	function populateDiscountsWorksheet( &$worksheet, &$database, &$priceFormat, &$boxFormat, &$textFormat )
	{
		// Set the column widths
		$j = 0;
		$worksheet->setColumn($j,$j++,strlen('deal_id')+1);
		$worksheet->setColumn($j,$j++,strlen('siteusers_group')+1);
		$worksheet->setColumn($j,$j++,strlen('quantity')+1);
		$worksheet->setColumn($j,$j++,strlen('priority')+1);
		$worksheet->setColumn($j,$j++,max(strlen('price'),10)+1,$priceFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_start'),19)+1,$textFormat);
		$worksheet->setColumn($j,$j++,max(strlen('date_end'),19)+1,$textFormat);
		
		// The heading row
		$i = 0;
		$j = 0;
		$worksheet->writeString( $i, $j++, 'deal_id', $boxFormat );
		$worksheet->writeString( $i, $j++, 'siteusers_group', $boxFormat );
		$worksheet->writeString( $i, $j++, 'quantity', $boxFormat );
		$worksheet->writeString( $i, $j++, 'priority', $boxFormat );
		$worksheet->writeString( $i, $j++, 'price', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_start', $boxFormat );
		$worksheet->writeString( $i, $j++, 'date_end', $boxFormat );
		$worksheet->setRow( $i, 30, $boxFormat );
		
		// The actual product discounts data
		$i += 1;
		$j = 0;
		$query  = "SELECT pd.*, cg.name FROM `".DB_PREFIX."product_discount` pd ";
		$query .= "LEFT JOIN `".DB_PREFIX."siteusers_group` cg ON cg.siteusers_group_id=pd.siteusers_group_id ";
		$query .= "ORDER BY pd.deal_id, cg.name";
		$result = $database->query( $query );
		foreach ($result->rows as $row) {
			$worksheet->write( $i, $j++, $row['deal_id'] );
			$worksheet->write( $i, $j++, $row['name'] );
			$worksheet->write( $i, $j++, $row['quantity'] );
			$worksheet->write( $i, $j++, $row['priority'] );
			$worksheet->write( $i, $j++, $row['price'], $priceFormat );
			$worksheet->write( $i, $j++, $row['date_start'], $textFormat );
			$worksheet->write( $i, $j++, $row['date_end'], $textFormat );
			$i += 1;
			$j = 0;
		}
	}


	function download() {
		global $config;
		global $log;
		$config = $this->config;
		$log = $this->log;
		set_error_handler('error_handler_for_export',E_ALL);
		$database =& $this->db;
		$languageId = $this->getDefaultLanguageId($database);

		// We use the package from http://pear.php.net/package/Spreadsheet_Excel_Writer/
		require_once "Spreadsheet/Excel/Writer.php";
		
		// Creating a workbook
		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->setTempDir(DIR_CACHE);
		$workbook->setVersion(8); // Use Excel97/2000 Format
		$priceFormat =& $workbook->addFormat(array('Size' => 10,'Align' => 'right','NumFormat' => '######0.00'));
		$boxFormat =& $workbook->addFormat(array('Size' => 10,'vAlign' => 'vequal_space' ));
		$weightFormat =& $workbook->addFormat(array('Size' => 10,'Align' => 'right','NumFormat' => '##0.00'));
		$textFormat =& $workbook->addFormat(array('Size' => 10, 'NumFormat' => "@" ));
		
		// sending HTTP headers
		$workbook->send('backup_categories_products.xls');
		
		// Creating the categories worksheet
		$worksheet =& $workbook->addWorksheet('Categories');
		$worksheet->setInputEncoding ( 'UTF-8' );
		$this->populateCategoriesWorksheet( $worksheet, $database, $languageId, $boxFormat, $textFormat );
		$worksheet->freezePanes(array(1, 1, 1, 1));
		
		// Get all additional product images
		$imageNames = array();
		$query  = "SELECT DISTINCT ";
		$query .= "  p.deal_id, ";
		$query .= "  pi.product_image_id AS image_id, ";
		$query .= "  pi.image AS filename ";
		$query .= "FROM `".DB_PREFIX."product` p ";
		$query .= "INNER JOIN `".DB_PREFIX."product_image` pi ON pi.deal_id=p.deal_id ";
		$query .= "ORDER BY deal_id, image_id; ";
		$result = $database->query( $query );
		foreach ($result->rows as $row) {
			$productId = $row['deal_id'];
			$imageId = $row['image_id'];
			$imageName = $row['filename'];
			if (!isset($imageNames[$productId])) {
				$imageNames[$productId] = array();
				$imageNames[$productId][$imageId] = $imageName;
			}
			else {
				$imageNames[$productId][$imageId] = $imageName;
			}
		}
		
		// Creating the products worksheet
		$worksheet =& $workbook->addWorksheet('Products');
		$worksheet->setInputEncoding ( 'UTF-8' );
		$this->populateProductsWorksheet( $worksheet, $database, $imageNames, $languageId, $priceFormat, $boxFormat, $weightFormat, $textFormat );
		$worksheet->freezePanes(array(1, 1, 1, 1));
		
		// Creating the options worksheet
		$worksheet =& $workbook->addWorksheet('Options');
		$worksheet->setInputEncoding ( 'UTF-8' );
		$this->populateOptionsWorksheet( $worksheet, $database, $languageId, $priceFormat, $boxFormat, $textFormat );
		$worksheet->freezePanes(array(1, 1, 1, 1));
		
		// Creating the specials worksheet
		$worksheet =& $workbook->addWorksheet('Specials');
		$worksheet->setInputEncoding ( 'UTF-8' );
		$this->populateSpecialsWorksheet( $worksheet, $database, $priceFormat, $boxFormat, $textFormat );
		$worksheet->freezePanes(array(1, 1, 1, 1));
		
		// Creating the discounts worksheet
		$worksheet =& $workbook->addWorksheet('Discounts');
		$worksheet->setInputEncoding ( 'UTF-8' );
		$this->populateDiscountsWorksheet( $worksheet, $database, $priceFormat, $boxFormat, $textFormat );
		$worksheet->freezePanes(array(1, 1, 1, 1));
		
		// Let's send the file
		$workbook->close();
		exit;
	}


}
?>