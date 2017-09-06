<html>
    <head>
		<title>WIP v0.1</title>
        <meta http-equiv="refresh" content="15" >
        <style>
            .bold {
                font-weight: bold;
            }
            .right {
				float: right;
			}
			.row{
				border-bottom: 1px dotted #003133;
			}
			
            .pri-top {
				color: #67989A;
			}
            .pri-hi {
                color: #417D80;
            }
            .pri-mid {
                color: #0D4A4D;
            }
            .pri-low {
                color: #003133;
            }
             
            .sec-top {
				color: #86C98A;
			}
            .sec-hi {
                color: #54A759;
            }
            .sec-mid {
                color: #116416;
            }
            .sec-low {
                color: #004304;
            }
            
        </style>
    </head>

<body>
    <div style="width: 400px;">
    <?php
    $row = 1;
    if (($handle = fopen("wip.csv", "r")) !== FALSE) {
        $records = array();
        $previous_day = False;
        $previous_date = new Datetime();
        $hour_sum = 0;
        $minute_sum = 0;
        $second_sum = 0;
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            
            # Timestamp
            $timestamp = $data[0];
            $task = $data[1];
            
            $date = new DateTime();
            $date->setTimestamp($timestamp);
            $date_formatted = $date->format('H:i:s');
            $day = $date->format('Y-m-d');
            
            if(!array_key_exists($day, $records)){
				$records[$day] = array();
			}
			$records[$day][] = array($date, $task);
            
            $interval = date_diff($date, $previous_date);

            $hours = $interval->h;
            $hours = $hours + ($interval->days*24);
            $hour_sum += $hours;
            $hours = sprintf('%02d', $hours);

            $minutes = $interval->i;
            $minute_sum += $minutes;
            $minutes = sprintf('%02d', $minutes);
            
            $seconds = $interval->s;
            $second_sum += $seconds;
            $seconds = sprintf('%02d', $seconds);
            
            $previous_date = $date;

            if($row != 2){
                echo "<span class='right'>";
                echo "<span class='sec-hi'>{$hours}</span>:";
                echo "<span class='sec-mid'>{$minutes}</span>:";
                echo "<span class='sec-low'>{$seconds}</span>";
                echo "</span>";
                echo "<br/>";
                echo "</div>";
            }
            
            if($day != $previous_day){
				$minute_sum += floor($second_sum / 60);
				$second_sum = $second_sum % 60;
				
				$hour_sum += floor($minute_sum / 60);
				$minute_sum = $minute_sum % 60;
				
				$second_sum = sprintf('%02d', $second_sum);
				$minute_sum = sprintf('%02d', $minute_sum);
				$hour_sum = sprintf('%02d', $hour_sum);
				
				/*
				echo "<div class='row'>
					<span class='right bold'>
						${hour_sum}:${minute_sum}:${second_sum}
					</span>
				</div>";
				*/
				
				$second_sum = 0;
				$minute_sum = 0;
				$hour_sum = 0;
				
                echo "<br/><strong>{$day}</strong></br>";
                $previous_day = $day;
            }
            
            echo "<div class='row'>";
            echo "<span class='pri-hi'>{$date_formatted}</span> - <span class='pri-mid'>{$task}</span> ";
        }
        
        $date = new DateTime();
        $interval = date_diff($date, $previous_date);
        $hours = $interval->h;
        $hours = $hours + ($interval->days*24);
        $hours = sprintf('%02d', $hours);
        
        $minutes = sprintf('%02d', $interval->i);
        $seconds = sprintf('%02d', $interval->s);
        
        echo "<span style='float: right'>";
		echo "<span class='sec-hi'>{$hours}</span>:";
		echo "<span class='sec-mid'>{$minutes}</span>:";
		echo "<span class='sec-low'>{$seconds}</span>";
        echo "</span>";
        echo "<br/>";
        
        fclose($handle);
    }

	/**
	$previous_day = new DateTime();
	$previous_day = $previous_day->format('Y-m-d');
	
    foreach(array_reverse($records) as $day => $record){
		echo "<h1><strong>{$day}</strong></h1>";
		
		$row = 0;
		foreach($record as $key => $entry){
            $date = $entry[0];
            $task = $entry[1];
            
            $date_formatted = $date->format('H:i:s');
            
            if($key != count($record)-1) $next_date = $record[$key+1][0];
            
            $interval = date_diff($date, $previous_date);
            #$previous_date = $date;
                        
            $hours = $interval->h;
            $hours = $hours + ($interval->days*24);
            $hours = sprintf('%02d', $hours);
            
            $minutes = sprintf('%02d', $interval->i);
            $seconds = sprintf('%02d', $interval->s);
            
			echo "<span class='pri-hi'>{$date_formatted}</span> - <span class='pri-mid'>{$task}</span> ";

			echo "<span style='float: right'>";
			echo "<span class='sec-hi'>{$hours}</span>:";
			echo "<span class='sec-mid'>{$minutes}</span>:";
			echo "<span class='sec-low'>{$seconds}</span>";
			echo "  ".$previous_date->format('H:i:s');
			echo "</span>";
			echo "<br/>";
						
			$row++;
		}
		
		$previous_day = $day;
	};
	**/
	
    ?>
    </div>
</body>
