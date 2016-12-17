<?php
/**
 * pagination helper 
 *
 * @author Mizno Kruge
 */
class PageHelper extends AppHelper 
{
	public function render($base_url,$page,$count)
	{
		$page = (int)$page;
		$count = (int)$count;
		$pages = '<div class="pagination">';
		if( $page === 1 )
			$pages .= '<span class="prev disabled">Previous</span>';
		else
			$pages .= '<span class="prev"><a href="'.$base_url.'?page='.($page - 1).'">Previous</a></span>';

		for( $iloop = 1;$iloop <= $count;$iloop++ )
		{
			if( $page == $iloop ){
				$pages .= '<span class="current">'.$iloop.'</span>';
				continue;
			}

			$pages .= '<span><a href="'.$base_url.'?page='.$iloop.'">'.$iloop.'</a></span>';
		}

		if( $page == $count ){
			$pages .= '<span class="next disabled"> Next </span>';
		}else{
			$pages .= '<span class="next"><a href="'.$base_url.'?page='.($page + 1).'">Next</a></span>';
		}

		$pages .= '</div>';
		return $pages;		
	}
}