<?php
class block {
	
	public $data;
	public $element;
	public $sclass;
	public $flag;
	
	public function __constructor($data = NULL, $element = NULL, $sclass = NULL, $flag = NULL)
	{
	
		$this->data = $data;
		$this->element = $element;
		$this->sclass = $sclass;
		$this->flag = $flag;
		
	}
	
	public function getDBValue($name = NULL)
	{
			
		if($name)
		{

			$dbValue = new access_db();
			$VALUE = $dbValue -> get_value($name);

			return $VALUE;

		}
		
	}
	
	public function getAttribute ($s_data = NULL, $a_attr = NULL)
	{
	
		$data = $s_data ? $s_data:NULL;
		$attr = $a_attr ? $a_attr:NULL;
		if($data && $attr){
		
			$attrData = array_key_exists("attributes", $data) ? $data["attributes"] : NULL;
			//print_r($attrData);
			if(is_array($attrData)){
			
				$length = count($attrData);

				foreach($attrData as $key => $val){

					$name = array_key_exists("name", $val) ? $val["name"] : NULL;
					$value = array_key_exists("value", $val) ? $val["value"] : NULL;
					
					if($name == $attr && $value){
						
						return $value;
						
					}else if($name == $attr && !$value){
						return true;
					}

				}
			
			}
		
		}
		
	}
	
	public function compileErrors($e_data = NULL, $e_name = NULL)
	{
		
		$data = $e_data ? $e_data : NULL;
		$name = $e_name ? $e_name : NULL;
		
		if($data && is_array($data) && $name){
			
			$length = count($data);
			for($i = 0; $i < $length; $i++){
				$iData = $data[$i];
				return $iData[$name];
			}
			
		}
		
	}
	
	public function messege($mg_data = NULL)
	{

		$messege = new block();
		$messege -> data = $GLOBALS["settingsData"]["application"]["fill"]["message"];
		$messege -> element = "div";

		$messege -> open();
		if($mg_data){
			$messege -> content($mg_data);
		}
		$messege -> close();
	
	}

	public function example($ex_data = NULL)
	{
	
		$data = $ex_data;
		
		if(is_array($data) && array_key_exists ("example",$data)){
			
			if($data["example"]){
			
				$ex = $data["example"];

				$example = new block();
				$example -> data = $GLOBALS["settingsData"]["application"]["fill"]["example"];
				$example -> element = "div";

				$example -> open();
				
					$text = new block();
					$text  -> data = $GLOBALS["settingsData"]["application"]["fill"]["element"];
					$text -> element = "p";
					
					$text -> open();
					$text -> content('e.g. '.$ex);
					$text -> close();
				
				$example -> close();
				
			}
		
		}
	
	}
	
	public function tooltip($tt_data = NULL)
	{
	
		$data = $tt_data;
		
		if(is_array($data) && array_key_exists ("tooltip",$data)){
			
			if($data["tooltip"]){
			
				$tip = $data["tooltip"];
				
				$tooltip = new block();
				$tooltip -> data = $GLOBALS["settingsData"]["application"]["fill"]["tooltip"];
				$tooltip -> element = "div";
				
				$tooltip -> open();
				
					$icon = new block();
					$icon -> data = $GLOBALS["settingsData"]["application"]["fill"]["icon"];
					$icon -> element = "i";
					
					$icon -> open();
						$icon -> content ("info");
					$icon -> close();
				
					$para = new block();
					$para -> data = $GLOBALS["settingsData"]["application"]["fill"]["text"];
					$para -> element ="p";
				
					$para -> open();
						$para -> content($tip);
					$para -> close();
				
				$tooltip -> close();
				
			}
		
		}
	
	}
	
	public function open($r = NULL)
	{

		$data = $this->data;
		
		$element = $this->element ? $this -> element : $data["element"];
		$settingsData = $GLOBALS["settingsData"] ? $GLOBALS["settingsData"] : NULL;
		$flagData = $settingsData["application"]["flags"] ? $settingsData["application"]["flags"] : NULL;
		$flags = $flagData["html"] ? $flagData["html"] : NULL;
		
		$attributes = NULL;
		if(is_array($data)){
			if($this->flag){
				$attributes = $this->sclass ? array(array('name'=>'class','value'=>array($this->sclass))):array(array('name'=>'class','value'=>array()));
			}else if(array_key_exists("attributes",$data)){
				$attributes = $data["attributes"];
			}else{
				$attributes=array(array('name'=>'class','value'=>array()));
			}
		}
		$attr = new attributes();
		$attr->data = $attributes;
		$attr->element = $element;
		$attrData = $attr -> get();
		
		echo '<'.$element;
		echo $attrData;
		
		if($element!="input"){
			echo '>';
		}else{
			echo '/>';
		}
			
	}
	
	public function close()
	{
		$element = $this -> element;
		if($element!="input"){
			echo '</'.$element.'>';
		}

	}
	
	public function title($td = NULL)
	{
		// echo "Title";
		$data= $td ? $td : $this -> data;
		
		if(is_array($data)){
		
			$tData = $data["title"];

			if(is_array($tData)){

				$title = new block();
				$title -> data = $tData;
				$title -> element = "div";
				$title -> sclass = "title";
				$title -> flag = true;

				$title -> open("title");
					
					$length = count($tData);
					foreach($tData as $key => $value){
						
						$iElement = array_key_exists ("element",$value) ? $value["element"] : NULL;
						$iContent = array_key_exists ("text",$value) ? $value["text"] : NULL;
						
						if($iElement && $iContent){
							$iItem = new block();
							$iItem -> data = $GLOBALS["elementDefData"];
							$iItem -> element = $iElement;
							$iItem-> flag = true;
							
							$iItem -> open();
							$iItem -> content($iContent);
							$iItem -> close();
						}
					}
					
				$title -> close();

			}
		}
		
	}
	
	public function content($cd = NULL)
	{
		// echo "Content";
		$data = $cd ? $cd : $this -> data;

		if(is_array($data)){
			
			$cData = array_key_exists ("content",$data) ? $data["content"] : NULL;
			
			if(is_array($cData)){

				$content = new block();
				$content -> data = $cData;
				$content -> element = "div";
				$content -> sclass = "content";
				$content -> flag = true;

				$content -> open("content");
				$this -> delegate($cData);
				$content -> close();

			}
			
		}
		if(is_string($data)){
		
			echo $data;
		
		}
		
	}
	
	public function delegate($dd = NULL)
	{
		// echo "Delegate";
		$data = $dd ? $dd : $this->data["content"];
		if(is_array($data)){
		
			$length = count($data);
			 
			for($i = 0; $i < $length; $i++){
				
				$d = $data[$i];
				
				if(array_key_exists("component",$d) || array_key_exists("article",$d) || array_key_exists("insert",$d) || array_key_exists("block",$d) || array_key_exists("title",$d)){

					foreach ($data[$i] as $key => $val){

						if($key == "component"){
							$this -> component($val);
						}else if($key == "article"){
							$this -> article($val);
						}else if($key == "insert"){
							$this -> insert($val);
						}else if($key == "block"){
							$this -> blocks($val);
						}
						
					}
					
				}else{
					
					$this -> item($d);
					
				}

			}
		}else{
			//$this -> content($GLOBALS['pageError']);
		}
	}
	
	public function component($file = NULL)
	{
		//echo "Component";
		
		if($file && is_string($file)){
			
			$dfile = file_get_contents("assets/data/components/".$file."_cur.json");
			$Data = json_decode($dfile, true);
			/*
			$dfile = new datafile();
			$dfile -> dFile = "assets/data/components/".$file;
			$Data = $dfile -> get();
			*/
			
			//print_r($Data);
			if($Data){

				$GLOBALS["compInc"]=0;

				$element = array_key_exists ("element",$Data) ? $Data["element"] : NULL;

				$comp = new block();
				$comp -> data = array('attributes'=>array(array('name'=>'id','value'=>''),array('name'=>'class','value'=>array($element=="form"?"component-form":NULL))));
				$comp -> element = "section";
				$comp -> sclass = "component";

				$comp -> open();

					$comp -> title($Data); 

					if($element=="form"){

						$frm = new block();		
						$frm -> data = $Data;
						$frm -> element = $element;

						$frm -> open();
						$comp -> content($Data);
						$frm -> close();

					}else{
						$comp -> content($Data);
					}


				$comp -> close();

				$GLOBALS["compInc"]++;

			}

		}

	}
	
	public function article($file = NULL)
	{
		//echo "Article";
		if($file && is_string($file)){
			
			$dfile = file_get_contents("assets/data/articles/".$file."_cur.json");
			$Data = json_decode($dfile, true);
			/*
			$dfile = new datafile();
			$dfile -> dFile = "articles/".$file;
			$Data = $dfile -> get();
			*/
			
			if($Data){
			
				$element = array_key_exists ("element",$Data) ? $Data["element"] : NULL;
				
				$art = new block();
				$art -> data = $GLOBALS["settingsData"]["application"]["fill"]["empty"];
				$art -> element = "article";
				$art -> sclass = "article";
				
				$art -> open();
					
					//echo "Wrapper";
					$wrapper = new block();
					$wrapper -> data = $Data;
					$wrapper -> element = $element;
					
					$wrapper -> open();
					$element == "fieldset" ? $wrapper -> element($Data,"legend") : NULL;
					$wrapper -> delegate($Data["content"]);
					$wrapper -> close();
					
				$art -> close();
				
				$GLOBALS["artInc"]++;
				
			}
			
		}
	
	}
	
	public function blocks($file = NULL)
	{
		//echo "Block";
		if($file && is_string($file)){
		
			$dfile = file_get_contents("assets/data/articles/".$file."_cur.json");
			$Data = json_decode($dfile, true);
			
			/*
			$bfile = new datafile();
			$bfile -> dFile = "articles/".$file;
			$Data = $bfile -> get();
			*/
			
			if($Data){
			
				
				$element = array_key_exists ("element",$Data) ? $Data["element"] : NULL; 
				$blk = new block();
				$blk -> data = $Data;
				$blk -> element = $element;
				
				$blk -> open();
				$blk -> title();
				$blk -> content();
				$blk -> close();
				
			}
			
		}
		
	}
	
	public function insert($file = NULL)
	{
		echo "Insert";
		if($file && is_string($file)){
		
			$ifile = file_get_contents("assets/data/articles/".$file."_cur.json");
			$Data = json_decode($ifile, true);
			
			/*
			$ifile = new datafile();
			$ifile -> dFile = "articles/".$file;
			$Data = $ifile -> get();
			*/

			if($Data){
				$in = new block();
				$in -> data = array_key_exists ("content",$Data) ? $Data["content"] : NULL;;
				$in -> element = array_key_exists ("element",$Data) ? $Data["element"] : NULL;

				$in -> open();
				$in -> title();
				$this -> delegate($Data["content"]);
				$in -> close();
			}

			
		}
		
	}
	
	public function item($iD = NULL)
	{
		//echo "Item";
		$data = $iD;

		if(is_array($data)){
			
			$item = new block();
			$item -> data = $GLOBALS["settingsData"]["application"]["fill"]["item"];
			$item -> element = "div";
			
			$item -> open();
				
				
				$type = $this -> getAttribute($data,"type");
				$tag = array_key_exists ("element",$data) ? $data["element"] : NULL;
				$name = $this -> getAttribute($data,"name");
				//echo "Element: ".$tag." | Type: ".$type." | Name: ".$name;
				
				$element = new block();
				$element -> data = $data;
				$element -> element = $tag;
				
				$wrap = new block();
				$wrap -> data = $GLOBALS["settingsData"]["application"]["fill"]["wrapper"];
				$wrap -> element = "div";
				
				$wrap -> open();
			
					if(($tag =="input" && ($type=="text" || $type=="date" || $type=="password" || $type=="zip" || $type=="phone")) || $tag == "select" || $tag == "textarea"){
						$item -> element($data,"label","before");
					}
				
					$element ->open();
				
						if($tag=="select")
						{
						
							$element -> options();
						
						}
						if($tag=="button" && array_key_exists ("text",$data))
						{
							
							$element -> content($data["text"]);
						
						}
						if($tag=="textarea")
						{
							
							
							
						}
				
					$element ->close();
				
					if($tag=="input" and $type == "radio" || $type == "checkbox" ){
						$item -> element($data,"label","after");
					}
				
				$wrap -> close();
				
				
				
				if($type != "radio" && $type != "checkbox"){
				
					
					if($GLOBALS["pageError"] && $tag === "button" && $name === "signin"){
						
						$item -> messege($GLOBALS["pageError"]);
						
					}else{
						
						$item -> messege();
						
					}
					
					$item -> example($data);
					$item -> tooltip($data);
				}
			
			$item -> close();
			
		}

	}
	
	public function element($ed = NULL, $el = NULL, $st = NULL)
	{
		// echo "Element";
		$data = $ed ? $ed : $this->data;
		$target = $el;
		
		if($data && $target){

			foreach ($data as $key => $value) {

				if($key == $el){

					$required = $this -> getAttribute($data,"required");

					$nvalue = NULL;

					if($required and $el == "label"){

						$nvalue = '<span class="required">*</span> '.$value;

					}else{
						$nvalue = $value;
					}
					$cntnt = $st == "before" && $el == "label" ? $nvalue.": " : $nvalue;  

					$el = new block();
					$el -> data = $GLOBALS["settingsData"]["application"]["fill"]["element"];
					$el -> element = $key;
					$el -> open();
					$el -> content($cntnt);
					$el -> close(); 

					if($st == "before" && $key == "label"){
						echo "<br/>";
					}

				}

			}
		
		}
	
	}
	
	public function options()
	{
		// echo "Options";
		$data = $this -> data;
		$element = $this -> element;
		
		$data_options = $data["options"];
		if(is_array($data_options)){

			$length = count($data_options);

			for ($i = 0; $i < $length; $i++){

				$ffile = file_get_contents("assets/data/articles/".$data_options[$i]."_cur.json");
				$fData = json_decode($ffile, true);

				/*
				$f = new datafile();
				$f -> dFile = "articles/".$data_options[$i];
				$fData = $f -> get();
				*/
				
				if(is_array($fData)){

					for ($j = 0; $j < count($fData); $j++){

						if($j == 0){

							$op = new block();
							if($data["label"]){
								$op -> data = array('attributes'=>array(array('name'=>'value','value'=>' -- '.$GLOBALS["settingsData"]["application"]["text"]["select"]["base"].' '.$data['label'].' -- ')));
							}else{
								$op -> data = array('attributes'=>array(array('name'=>'value','value'=>' -- '.$GLOBALS["settingsData"]["application"]["text"]["select"]["alt"].' -- ')));
							}
							$op -> element = "option";

							$op -> open();
							if($data["label"]){
								echo ' -- '.$GLOBALS["settingsData"]["application"]["text"]["select"]["base"].' '.$data['label'].' -- ';
							}else{
								echo ' -- '.$GLOBALS["settingsData"]["application"]["text"]["select"]["alt"].' -- ';
							}
							$op -> close();

						}

						$o = $fData[$j];
						$ot = $o["name"];
						$ov = $o["value"];

						$op = new block();
						$op -> data = array('attributes'=>array(array('name'=>'value','value'=>$ov)));
						$op -> element = "option";

						$op -> open();
						echo $ot;
						$op -> close();


					}

				}

			}

		}
	
	}

}
?>