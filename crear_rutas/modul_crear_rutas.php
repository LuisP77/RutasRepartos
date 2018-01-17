<?php

function Facturacio_Comanda_Array_CrearRutas($link,$idc)
{  
	$html = "";
   
	$sql = <<<SQL
SELECT id_producte, comprats, cost, iva, a_pes
FROM comandes,  comandes_carret
WHERE comandes.id = '$idc'
AND comandes_carret.id_comanda = comandes.id
AND estat='1' AND entregat = 1 AND pagat = 1 
SQL;
    
	$result = mysql_query($sql, $link);
	$total = mysql_num_rows($result);
	if ($total==0)
	{
	  //return "No hi han comandes pendents!!";
	}
    
    $iva_general=0;  //21
    $iva_reduit=0;   //10
    $iva_super_reduit=0;   //4

    $total_iva_general=0;  //21
    $total_iva_reduit=0;   //10
    $total_iva_super_reduit=0;   //4
    
    $error=0;
    $errors = array();
    
	for($x=0;$x<$total;$x++)
	{
	    $id_producte =  intval(mysql_result($result,$x,"id_producte"));
		$comprats =  intval(mysql_result($result,$x,"comprats"));
		$cost =  intval(mysql_result($result,$x,"cost"));
		$iva =  intval(mysql_result($result,$x,"iva"));
		$a_pes =  mysql_result($result,$x,"a_pes");
      
		if ($iva==0)
		{
			$iva = Get_Iva_Producte($link,$id_producte);
		}
          
		if ($a_pes=="si")
		{
			$comprats = $comprats / 1000;      
		}
            
		switch($iva)
		{
			case 21:
             $total_iva_general=$total_iva_general+ceil($comprats*$cost);
             break;
			case 10:
             $total_iva_reduit=$total_iva_reduit+ceil($comprats*$cost);
             break;
			case 4:
             $total_iva_super_reduit=$total_iva_super_reduit+ceil($comprats*$cost);
             break;
			default:
             $error++;
 //            echo " <a href=/admin/productes-nou.php?id=$id_producte>$id_producte</a> ";
             $errors[]=$id_producte;
             break;
		}
	}
    
      $sql = <<<SQL
    SELECT comandes.id,total_desp,comandes_entrega.dia as entrega,data_pagat,comandes.quan,metode_pagament,
	comandes.descompte, comandes_descomptes.descompte as descompte2
    FROM comandes_entrega, comandes LEFT JOIN comandes_descomptes ON comandes.id = comandes_descomptes.id_comanda
    WHERE comandes.id = '$idc'
    AND comandes.id = comandes_entrega.id_comanda
SQL;
	  $result = mysql_query($sql, $link);
	  $total = mysql_num_rows($result);

      $id =  mysql_result($result,0,"id");
      $quan =  mysql_result($result,0,"quan");
      $entrega =  mysql_result($result,0,"entrega");
      $data_pagat =  mysql_result($result,0,"data_pagat");
      $metode_pagament =  mysql_result($result,0,"metode_pagament");
      $despeses_amb_iva =  intval(mysql_result($result,0,"total_desp"));
      //$tipus_descompte =  mysql_result($result,0,"tipus_descompte");
      $descompte_amb_iva =  intval(mysql_result($result,0,"descompte"));
	  $descompte2_amb_iva =  intval(mysql_result($result,0,"descompte2"));
    
        $despeses_sense_iva = round($despeses_amb_iva / 1.21,1);
        $despeses_iva = $despeses_amb_iva - $despeses_sense_iva;
        
        $descompte_amb_iva=0-$descompte_amb_iva;
        $descompte_sense_iva = round($descompte_amb_iva / 1.10,1);
        $descompte_iva = $descompte_amb_iva - $descompte_sense_iva;
		
        $descompte2_amb_iva=0-$descompte2_amb_iva;
        $descompte2_sense_iva = round($descompte2_amb_iva / 1.10,1);
        $descompte2_iva = $descompte2_amb_iva - $descompte2_sense_iva;		
        
        //$total_iva_general = $total_iva_general + $despeses_amb_iva;
        
        $total_iva_general_real = $total_iva_general;
        $total_iva_reduit_real = $total_iva_reduit;
        $total_iva_super_reduit_real = $total_iva_super_reduit;
        
        $total_sense_iva_general = $total_iva_general / 1.21;  
        $total_sense_iva_reduit = $total_iva_reduit / 1.10;    
        $total_sense_iva_super_reduit = $total_iva_super_reduit / 1.04;
        
        $cost_iva_general = $total_iva_general - $total_sense_iva_general;
        $cost_iva_reduit = $total_iva_reduit - $total_sense_iva_reduit;
        $cost_iva_super_reduit = $total_iva_super_reduit - $total_sense_iva_super_reduit;
        
        $total_sense_iva_general = round($total_sense_iva_general,0);
        $total_iva_general =  round($total_iva_general,0);
        $total_sense_iva_reduit =  round($total_sense_iva_reduit,0);
        $total_iva_reduit =  round($total_iva_reduit,0);
        $total_sense_iva_super_reduit =  round($total_sense_iva_super_reduit,0);
        $total_iva_super_reduit =  round($total_iva_super_reduit,0);
        $cost_iva_general =  round($cost_iva_general,0);
        $cost_iva_reduit =  round($cost_iva_reduit,0);
        $cost_iva_super_reduit =  round($cost_iva_super_reduit,0);
    
        $total_sense_iva_general = $total_sense_iva_general / 100;
        $total_iva_general = $total_iva_general / 100;
        $total_sense_iva_reduit = $total_sense_iva_reduit / 100;
        $total_iva_reduit = $total_iva_reduit  / 100;
        $total_sense_iva_super_reduit = $total_sense_iva_super_reduit / 100;
        $total_iva_super_reduit = $total_iva_super_reduit / 100;
        $cost_iva_general = $cost_iva_general / 100;
        $cost_iva_reduit = $cost_iva_reduit / 100;
        $cost_iva_super_reduit = $cost_iva_super_reduit / 100;
        
        $despeses_sense_iva = $despeses_sense_iva/100;
        $despeses_amb_iva = $despeses_amb_iva/100;
        $despeses_iva = $despeses_iva/100;
        
        $descompte_iva = $descompte_iva/100;
        $descompte_amb_iva = $descompte_amb_iva / 100;
        $descompte_sense_iva = $descompte_sense_iva /100;
		
		$descompte2_iva = $descompte2_iva/100;
        $descompte2_amb_iva = $descompte2_amb_iva / 100;
        $descompte2_sense_iva = $descompte2_sense_iva /100;
        
        $tots_sense=$total_sense_iva_general+$total_sense_iva_reduit+$total_sense_iva_super_reduit;
        $tots=$total_iva_general+$total_iva_reduit+$total_iva_super_reduit;
        
        $ivas_total=$cost_iva_general+$cost_iva_reduit+$cost_iva_super_reduit;
        //$final = $ivas_total + $tots_sense;
        $total_iva_general_real = ceil($total_iva_general_real)/100;
        $total_iva_reduit_real = ceil($total_iva_reduit_real)/100;
        $total_iva_super_reduit_real = ceil($total_iva_super_reduit_real)/100;
        $final = $total_iva_general_real + $total_iva_reduit_real + $total_iva_super_reduit_real+$despeses_amb_iva+$descompte_amb_iva+$descompte2_amb_iva;
    
    //---------------------
 
	$resultat = array();
	$resultat['id']=$id;
	$resultat['idc']=$idc;
	
	$resultat['data_entrega']=$entrega;
	$resultat['data_pagat']=$data_pagat;
	$resultat['total_sense_iva_super_reduit']=$total_sense_iva_super_reduit;
	$resultat['total_sense_iva_reduit']=$total_sense_iva_reduit;
	$resultat['total_sense_iva_general']=$total_sense_iva_general;
	$resultat['despeses_sense_iva']=$despeses_sense_iva;
	$resultat['ivas_total']=$ivas_total;
	$resultat['despeses_iva']=$despeses_iva;
	$resultat['descompte_sense_iva']=$descompte_sense_iva;
	$resultat['descompte_iva']=$descompte_iva;
	$resultat['total']=$final;
	$resultat['metode_pagament']=$metode_pagament;
	//$resultat['']=$;
	return $resultat;
}

?>