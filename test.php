<?php

$fh=fopen("data1.txt","r");


function GetDistance($x1,$y1,$x2,$y2)
{
	return sqrt(($x1-$x2)**2+($y1-$y2)**2);
}

function GetNextLine()
{
	global $fh;
	return fgets($fh);

	//return readline();
}

while($line_count=GetNextLine())
{
	$line_count=intval($line_count);

	$points = array();
	$xpoints = array();
	$ypoints = array();
	$dist = array();

	for ($i=0; $i<$line_count; $i++)
	{
		$line=GetNextLine();
		preg_match("/[\d\.]+\ [\d\.]+/",$line,$res);
		$orig_position=explode(" ",$res[0]);
		//echo "start point: ".$orig_position[0].", ".$orig_position[1]."\n";
		preg_match_all('/[\D+]+\s+[\d\.-]+/', $line, $comm_arr);
		//walk cammands array, calculate final position
		$angle=0;
		$x=$orig_position[0];
		$y=$orig_position[1];

		foreach ($comm_arr[0] as $row )
		{
			$res=preg_split('/\s+/',trim($row));

			if ($res[0]=="walk") //walking
			{
				$x=$x+floatval($res[1])*cos(deg2rad($angle));
				$y=$y+floatval($res[1])*sin(deg2rad($angle));
			}
			else //changing angle
			{
				$angle+=floatval($res[1]);
			}
		}
		$xpoints[$i]=$x;
		$ypoints[$i]=$y;

	}
	// average
	$ax=array_sum($xpoints)/count($xpoints);
	$ay=array_sum($ypoints)/count($ypoints);

	//distances from the average
	for ($i=0; $i<$line_count; $i++)
	{
		$dist[$i]=GetDistance($ax,$ay,$xpoints[$i],$ypoints[$i]);
	}

	//result
	echo $ax." ".$ay." ".max($dist)."\n";
}

fclose($fh);





