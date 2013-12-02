@extends('admin_master')

@section('content')

<h2>Active Projects For {{ucwords(Auth::user()->username)}}:</h2>
<hr>

<?php 
	$id = Auth::user()->id;
	$activeProj = Project::whereRaw("UserID = " . $id . " and Status = 'active'")->get();
?>

<?php 
	if(count($activeProj) == 0) 
	{
		echo '<em>No projects found.</em>';
	}
	else
	{
		echo '</br><div class="panel panel-primary">
 				<div class="panel-heading">My Active Projects</div><table class="table table-hover">
  				<tr>
  				<th>Project</th>
  				<th>Start Date</th>
  				<th>Due Date</th>
  				<th>Priority</th>
  				<th>Latest Revision</th>';

  		for($i = 0; $i < count($activeProj); $i++)
  		{
  			$a = $activeProj[$i];
  			$url = URL::action('AdminController@getAdmin_project_info', [$a->id]);
        echo '<tr><td>' . '<a href="' . $url . '">' . $a->ProjectName . '</a></td>';

  			echo '<td>' . date("m-d-Y", strtotime($a->StartDate)) . '</td>
  			<td>' . date("m-d-Y", strtotime($a->DueDate)) . '</td>
  			<td>';

  			if($a->Priority == 'high')
  			{
  				echo '<span class="label label-danger">' . ucwords($a->Priority) . '</span></td>';
  			}
  			elseif($a->Priority == 'medium')
  			{
  				echo '<span class="label label-warning">' . ucwords($a->Priority) . '</span></td>';
  			}
  			else
  			{
  				echo '<span class="label label-info">' . ucwords($a->Priority) . '</span></td>';
  			}
  			
  			echo '<td>' . $a->updated_at . '</td>
  			</tr>';
  		}
	}
?>
  
  	</tr>
  </table>
</div>





@stop