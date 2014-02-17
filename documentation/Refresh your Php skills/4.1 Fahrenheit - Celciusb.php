<?php 
function celciusToFahrenheit($celcius){
	//Your code here
	$fahr = $celcius;
	return $fahr;
}

echo '<table>';
echo '<tr>';
echo '<th>Celcius</th><th>Fahrenheit</th>';
echo '</tr>';
for($i = -20; $i < 41; $i += 5){
	echo "<tr><td>$i</td><td>" . celciusToFahrenheit($i) . " </td></tr>";
}
echo '</table>';

?>