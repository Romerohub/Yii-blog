<?php

class MyFunctions{
	
	function __construct(){
		
		
		
	}
	
	public function prepareDir($dir){
		if(!is_dir($dir)){
			mkdir($dir, 0777, true);
		}
	}

	public function getUnickFileName($dir, $file_name,$i = 1){
		
		if(file_exists($dir.$file_name)){
			$file_name = $i.$file_name;
			$i++;
			$file_name = $this->getUnickFileName($dir, $file_name, $i);
		}
			
		return $file_name;
		
		
	}
	
	/**Счетчик посещений сайта**/
	public function counter(){
		
		
		//**Счетчик посетителей**//
		//print_r($_SERVER);
		//[HTTP_USER_AGENT]
		
		$connection=Yii::app()->db;

		$hitArr['date'] = date("Y-m-d");
		$hitArr['hosts_sql'] = '';
		$hitArr['ip'] = empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR'];
		$hitArr['ip'] = sprintf("%u", ip2long($hitArr['ip']));
		
	//если нет куки то проверка уникальности ip
	if(empty($_SESSION['netkurator_'.date("Y-m-d")])){

		$sql='SELECT ip FROM  tbl_stata_uniq_ip WHERE  date = :date AND  ip= :ip';
		$command=$connection->createCommand($sql);
		$command->bindParam(":date", $hitArr['date'],PDO::PARAM_STR);
		$command->bindParam(":ip",  $hitArr['ip'],PDO::PARAM_STR);
		$hitArr['uniq_ip'] = $command->queryAll();

		//если не уникально, то делаем вставку
		if(empty($hitArr['uniq_ip'])){
		
			$sql='INSERT INTO  tbl_stata_uniq_ip SET date = :date, ip= :ip';
				
			$command=$connection->createCommand($sql);
			$command->bindParam(":date", $hitArr['date'],PDO::PARAM_STR);
			$command->bindParam(":ip",  $hitArr['ip']);
			$command->execute();
			
			$hitArr['hosts_sql'] = ', hosts=hosts+1';
	
		}
	}
		
		//Если ип уникален и нет кукки,то сохраняем этого юзера
		if(empty($_SESSION['netkurator_'.date("Y-m-d")]) && empty($hitArr['uniq_ip'])){	
			
			$_SESSION['netkurator_'.date("Y-m-d")] = "hit";
			$hitArr['hosts_sql'] = ', hosts=hosts+1';
			
			//Сохраняем рефа так или иначе
//			if(!empty($_SERVER['HTTP_REFERER'])){
//
//				$hitArr['ref'] =$_SERVER['HTTP_REFERER'];
//				$hitArr['ref_md5'] = md5($hitArr['ref']);
//				$sql='INSERT INTO  tbl_stata_refs SET date=:date, ref= :ref, ref_md5=:ref_md5, visits=1 ' .
//						'ON DUPLICATE KEY UPDATE visits=visits+1';
//
//				$command=$connection->createCommand($sql);
//				$command->bindParam(":date", $hitArr['date'],PDO::PARAM_STR);
//				$command->bindParam(":ref",  $hitArr['ref'], PDO::PARAM_STR);
//				$command->bindParam(":ref_md5",  $hitArr['ref_md5'], PDO::PARAM_STR);
//				 $command->execute();
//				print_r( Yii::app()->db->getLastInsertID());
//			}
			$hitArr['ref_id'] = 0;
			if(!empty($_SERVER['HTTP_REFERER'])){
				
				$hitArr['ref'] =$_SERVER['HTTP_REFERER'];
				$hitArr['ref_md5'] = md5($hitArr['ref']);
				
				$sql='SELECT id FROM tbl_stata_refs WHERE date=:date AND ref_md5 = :ref_md5 LIMIT 1';
				$command=$connection->createCommand($sql);
				$command->bindParam(":date", $hitArr['date'],PDO::PARAM_STR);
				$command->bindParam(":ref_md5",  $hitArr['ref_md5'], PDO::PARAM_STR);
				$hitArr['ref_id'] = $command->queryColumn();
				
				//print_r($hitArr['ref_id']);
				if(empty($hitArr['ref_id'][0])){
					
					$sql='INSERT INTO  tbl_stata_refs SET date=:date, ref= :ref, ref_md5=:ref_md5, visits=1 ';
					$command=$connection->createCommand($sql);
					$command->bindParam(":date", $hitArr['date'],PDO::PARAM_STR);
					$command->bindParam(":ref",  $hitArr['ref'], PDO::PARAM_STR);
					$command->bindParam(":ref_md5",  $hitArr['ref_md5'], PDO::PARAM_STR);
					$command->execute();	
					$hitArr['ref_id'] = Yii::app()->db->getLastInsertID();
									
				}elseif(!empty($hitArr['ref_id'][0])){
					
					$sql='UPDATE tbl_stata_refs SET  visits=visits+1  WHERE id =:id';
					$command=$connection->createCommand($sql);
					$command->bindParam(":id", $hitArr['ref_id'][0]);
					$command->execute();
					$hitArr['ref_id'] = $hitArr['ref_id'][0];
				}
			}
			
			if(!empty($_SERVER['HTTP_USER_AGENT'])){
				$hitArr['http_user_agent'] = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
			}else{
				$hitArr['http_user_agent'] = "";
			}
			
			//Делаем вставку данных по пришедшему юзеру/
				$sql='INSERT INTO tbl_stata_visites_data SET date=:date, ref_id= :ref_id, http_user_agent=:http_user_agent, ip = :ip ';
				$command=$connection->createCommand($sql);
				$command->bindParam(":date", time(),PDO::PARAM_STR);
				$command->bindParam(":ref_id",  $hitArr['ref_id'], PDO::PARAM_STR);
				$command->bindParam(":http_user_agent", $hitArr['http_user_agent'], PDO::PARAM_STR);
				$command->bindParam(":ip", $hitArr['ip'],PDO::PARAM_STR);
				$command->execute();	
			
		}
		
		
		//вставка в общую статистику на день
		$sql='INSERT INTO  tbl_stata_by_date SET date = :date, hits= 1, hosts=1 ' .
				'ON DUPLICATE KEY UPDATE hits=hits+1';
				
		$sql = $sql.$hitArr['hosts_sql'];
		
		$command=$connection->createCommand($sql);
		$command->bindParam(":date", $hitArr['date'],PDO::PARAM_STR);
		$command->execute();
		
		//**КОНЕЦ: Счетчик посетителей**//
	}
}