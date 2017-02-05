<?php
require_once 'core/init.php';

if(Input::exists('get'))
{
    $text=Input::get('name');
    $db = DB::getInstance();
    $data=$db->get('contact',array('name','=',$text));
//    foreach ($data->results()[0] as $result)
//    {
//        echo $result.'<br>';
//    }
    $count=$data->count();
//    echo $count;
    $i=0;
    echo "<table>
                <tr>
                    <th>Name</th>
                    <th></th>
                    <th>Contact</th>
                    <th></th>
                    <th>Year</th>
                </tr>";
    while($i<$count)
    {
//        echo $data->results()[$i]->id;
        echo "  <tr>
                <td>".$data->results()[$i]->name."</td>
                <td></td>
                <td>".$data->results()[$i]->contact."</td>
                <td></td>
                <td>".$data->results()[$i]->year."</td>
                </tr>
               ";
        $i++;
    }
    echo "</table>";
}

?>